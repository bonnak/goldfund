<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends Controller
{
    public function get($slug)
    {
        $service = Service::where('slug', $slug)->first();

        if(is_null($service)) return redirect('/');

        return view('service', compact('service'));
    }
}
