<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyProfile;
use App\Slide;

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

        $slides = Slide::orderBy('order')->get();

        return view('home', compact('slides'));
    }
}
