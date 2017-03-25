<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyProfile;

class CompanyProfileController extends Controller
{
    public function getData()
    {
    	return CompanyProfile::get()
    			->mapWithKeys(function ($item) {
				    return [$item['field'] => $item['value']];
				});
    }
}
