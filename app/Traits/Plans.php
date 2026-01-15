<?php

namespace App\Traits;

use App\Traits\SiteApi;
use App\Utilities\Date;
use Illuminate\Support\Facades\Cache;

trait Plans
{
    use SiteApi;

    public function clearPlansCache(): void
    {
        Cache::forget('plans.limits');
    }

    public function getUserLimitOfPlan(): object
    {
        return $this->unlimitedLimit();
    }

    public function getCompanyLimitOfPlan(): object
    {
        return $this->unlimitedLimit();
    }

    public function getInvoiceLimitOfPlan(): object
    {
        return $this->unlimitedLimit();
    }

    public function getAnyActionLimitOfPlan(): object
    {
        return $this->unlimitedLimit();
    }

    public function getPlanLimitByType($type): object
    {
        return $this->unlimitedLimit();
    }

    /** @return object|false */
    public function getPlanLimits()
    {
        return (object) [
            'user' => $this->unlimitedLimit(),
            'company' => $this->unlimitedLimit(),
            'invoice' => $this->unlimitedLimit(),
        ];
    }

    private function unlimitedLimit(): object
    {
        $limit = new \stdClass();
        $limit->action_status = true;
        $limit->view_status = true;
        $limit->message = "Success";
        return $limit;
    }
}