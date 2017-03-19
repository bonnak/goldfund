<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plan;

class PlanController extends Controller
{
    public function get()
    {
    	return Plan::with('sponsor_levels')->paginate(request()->input('per_page'));
    }
}
