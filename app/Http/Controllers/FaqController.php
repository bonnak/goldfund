<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;

class FaqController extends Controller
{
    public function get(){
        $faqList = Faq::all();
        return view('faq', compact('faqList'));
    }
}
