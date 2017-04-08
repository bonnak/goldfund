<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slide;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SlideController extends Controller
{
    public function getData()
    {
    	return Slide::orderBy('order')->get();
    }

    public function addNew(Request $request)
    {
    	$validator = \Validator::make($request->all(),[
            'slide' => 'mimes:jpeg,bmp,png|max:2048'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'error' => $validator->getMessageBag()->first()
            ], 403);
        }

        $slide = request()->file('slide');
        if( is_null($slide) || !$slide->isValid()) 
        {
            throw new HttpException(403, 'File is corrupted.');
        }

        $path = '/storage/' . $slide->store('images/slide');
        $order = Slide::orderBy('order', 'desc')->first();

        return Slide::create([
        	'image' => $path,
        	'order' => is_null($order) ? 1 : ($order->order + 1)
        ]);
    }

    public function delete($id)
    {
    	$slide = Slide::find($id);

    	if(is_null($slide)) throw new HttpException(404, 'Slide not found.');

    	$slide->delete();
    }

    public function update(Request $request)
    {
    	$slide = Slide::find($request->id);

    	if(is_null($slide)) throw new HttpException(404, 'Slide not found.');

    	$slide->order = $request->order;
    	$slide->save();

    	return Slide::orderBy('order')->get();
    }
}
