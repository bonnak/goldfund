<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\CompanyProfile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(500);


        $company_profile = CompanyProfile::get()
                            ->mapWithKeys(function ($item) {
                                return [$item['field'] => $item['value']];
                            });

        \View::share('company_profile', $company_profile);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
