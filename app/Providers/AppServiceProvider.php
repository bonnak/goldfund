<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\CompanyProfile;
use App\Service;

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

        // menu
        $menus = Service::select('title','id')->get();

        \View::share('menus', $menus);
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
