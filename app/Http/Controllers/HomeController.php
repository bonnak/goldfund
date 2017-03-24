<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyProfile;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->check())
        {
            return redirect('account');
        }

        $company_profile = $this->getCompanyProfile();

        return view('home', compact('company_profile'));
    }


    private function getCompanyProfile()
    {
        return CompanyProfile::get()
                ->mapWithKeys(function ($item) {
                    return [$item['field'] => $item['value']];
                });
    }
}
