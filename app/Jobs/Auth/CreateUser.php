<?php

namespace App\Jobs\Auth;

use App\Abstracts\Job;
use App\Events\Auth\UserCreated;
use App\Events\Auth\UserCreating;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use App\Traits\Plans;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CreateUser extends Job implements HasOwner, HasSource, ShouldCreate
{
    use Plans;

    public function handle()
    {
        $this->authorize();

        event(new UserCreating($this->request));

        \Log::info('Starting user creation transaction', ['request' => $this->request->all()]);

        \DB::transaction(function () {
            if (empty($this->request->get('password', false))) {
                $this->request->merge(['password' => Str::random(40)]);
            }

            // Employee users should always land on the main dashboard.
            $roles = (array) $this->request->get('roles', []);
            if (! empty($roles)) {
                $hasEmployeeRole = role_model_class()::whereIn('id', $roles)
                    ->where('name', 'employee')
                    ->exists();

                if ($hasEmployeeRole) {
                    $this->request->merge(['landing_page' => 'dashboard']);
                }
            }

            \Log::info('Creating user model', ['data' => $this->request->input()]);

            $this->model = user_model_class()::create($this->request->input());

            \Log::info('User model created', ['user_id' => $this->model->id]);

            // Upload picture
            if ($this->request->file('picture')) {
                $media = $this->getMedia($this->request->file('picture'), 'users');

                $this->model->attachMedia($media, 'picture');
            }

            if ($this->request->has('dashboards')) {
                $this->model->dashboards()->attach($this->request->get('dashboards'));
            }

            if ($this->request->has('permissions')) {
                $this->model->permissions()->attach($this->request->get('permissions'));
            }

            if ($this->request->has('roles')) {
                \Log::info('Attaching roles', ['roles' => $this->request->get('roles')]);
                $this->model->roles()->attach($this->request->get('roles'));
            }

            if ($this->request->has('companies')) {
                \Log::info('Attaching companies', ['companies' => $this->request->get('companies')]);
                if (app()->runningInConsole() || request()->isInstall()) {
                    $this->model->companies()->attach($this->request->get('companies'));
                } else {
                    $user = user();

                    $companies = $user->withoutEvents(function () use ($user) {
                        return $user->companies()->whereIn('id', $this->request->get('companies'))->pluck('id');
                    });

                    if ($companies->isNotEmpty()) {
                        $this->model->companies()->attach($companies->toArray());
                    }
                }
                \Log::info('Companies attached successfully');
            }

            if (empty($this->model->companies)) {
                \Log::info('No companies to attach, returning early');
                return;
            }

            \Log::info('Running user:seed for companies', ['companies' => $this->model->companies->pluck('id')->toArray()]);
            foreach ($this->model->companies as $company) {
                \Log::info('Running user:seed', ['user' => $this->model->id, 'company' => $company->id]);
                try {
                    // Temporarily skip seeding to isolate the issue
                    \Log::info('Skipping user:seed for debugging');
                    // Artisan::call('user:seed', [
                    //     'user' => $this->model->id,
                    //     'company' => $company->id,
                    // ]);
                } catch (\Exception $e) {
                    \Log::error('user:seed failed', ['error' => $e->getMessage()]);
                    throw $e;
                }
            }

            if ($this->shouldSendInvitation()) {
                \Log::info('Sending invitation');
                // Temporarily skip invitation to isolate the issue
                // $this->dispatch(new CreateInvitation($this->model));
                \Log::info('Skipping invitation for debugging');
            } else {
                \Log::info('Skipping invitation');
            }
        });

        $this->clearPlansCache();

        event(new UserCreated($this->model, $this->request));

        \Log::info('User creation completed successfully', ['user_id' => $this->model->id]);

        return $this->model;
    }

    /**
     * Determine if this action is applicable.
     */
    public function authorize(): void
    {
        $limit = $this->getAnyActionLimitOfPlan();
        if (! $limit->action_status) {
            throw new \Exception($limit->message);
        }
    }

    protected function shouldSendInvitation()
    {
        if (app()->runningUnitTests()) {
            return true;
        }

        if (app()->runningInConsole()) {
            return false;
        }

        if (request()->isInstall()) {
            return false;
        }

        return true;
    }
}
