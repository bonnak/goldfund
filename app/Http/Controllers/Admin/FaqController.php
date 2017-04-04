<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faq;

class FaqController extends Controller
{
    public function getData()
    {
    	return Faq::paginate(request()->input('per_page'));
    }

    public function update(Request $request)
    {
    	$faq = Faq::find($request->id);

    	if(is_null($faq)) return response()->json([ 'error' => 'No data found' ], 422);

    	$faq->question	= $request->question;
    	$faq->answer 	= $request->answer;
    	$faq->save();

    	return response()->json([ 'msg' => 'Update successfully'], 200);
    }

    public function create(Request $request)
    {
    	Faq::create([
    		'question'	=> $request->question,
    		'answer' 	=> $request->answer,
    	]);

    	return response()->json([ 'msg' => 'Create successfully'], 200);
    }
}
