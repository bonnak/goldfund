<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlanLevelSponsor;

class LevelController extends Controller
{
    public function get()
    {
    	return PlanLevelSponsor::all();
    }
}
