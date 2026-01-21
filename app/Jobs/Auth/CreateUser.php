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

        \DB::transaction(function () {
            $password = $this->request->get('password');

            if (empty($password)) {
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

            $this->model = user_model_class()::create($this->request->input());

            // Ensure user is enabled
            $this->model->update(['enabled' => true]);

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
                $this->model->roles()->attach($this->request->get('roles'));
            }

            if ($this->request->has('companies')) {
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
            }

            if (empty($this->model->companies)) {
                return;
            }

            foreach ($this->model->companies as $company) {
                Artisan::call('user:seed', [
                    'user' => $this->model->id,
                    'company' => $company->id,
                ]);
            }

            if ($this->shouldSendInvitation()) {
                $this->dispatch(new CreateInvitation($this->model));
            }
        });

        $this->clearPlansCache();

        event(new UserCreated($this->model, $this->request));

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

        // Don't send invitation if password is provided
        if (!empty($this->request->get('password', false))) {
            return false;
        }

        return true;
    }
}
