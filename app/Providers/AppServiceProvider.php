<?php

namespace App\Providers;

use App\Services\Application\Schedules\ScheduleRescheduleService;
use App\Services\Application\Schedules\ScheduleStoreService;
use App\Services\Application\Schedules\Status\ScheduleCanceledService;
use App\Services\Application\Schedules\Status\ScheduleFinishedService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(! $this->app->isProduction());
    }
}
