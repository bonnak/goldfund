<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends Controller
{
    public function get($id){
        $service = Service::find($id);
        return view('service', compact('service'));
    }
}
