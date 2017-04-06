<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CompanyProfile;
use App\Service;

class PageController extends Controller
{
	public function aboutUs()
    {
        return CompanyProfile::where('field', 'about-us')
                                ->first();
    }

    public function updateAboutUs(Request $request)
    {
        $data = CompanyProfile::where('field', 'about-us')->first();

        if(is_null($data)) return response()->json(['error' => 'No data found.'], 422);

        $data->value = $request->value;
        $data->save();

        return response()->json(['msg' => 'Update successfully.'], 200);
    } 


    public function whatIsForex()
    {
        return CompanyProfile::where('field', 'what-is-forex')
                                ->first();
    }

    public function updateWhatIsForex(Request $request)
    {
        $data = CompanyProfile::where('field', 'what-is-forex')->first();

        if(is_null($data)) return response()->json(['error' => 'No data found.'], 422);

        $data->value = $request->value;
        $data->save();

        return response()->json(['msg' => 'Update successfully.'], 200);
    } 

    public function bitcoinMining()
    {
        return Service::where('slug', 'bitcoin-mining')
                        ->first();
    }

    public function updateBitcoinMining(Request $request)
    {
        $data = Service::where('slug', 'bitcoin-mining')->first();

        if(is_null($data)) return response()->json(['error' => 'No data found.'], 422);

        $data->description = $request->description;
        $data->save();

        return response()->json(['msg' => 'Update successfully.'], 200);
    } 

    public function forexTrading()
    {
        return Service::where('slug', 'forex-trading')
                        ->first();
    }

    public function updateForexTrading(Request $request)
    {
        $data = Service::where('slug', 'forex-trading')->first();

        if(is_null($data)) return response()->json(['error' => 'No data found.'], 422);

        $data->description = $request->description;
        $data->save();

        return response()->json(['msg' => 'Update successfully.'], 200);
    } 

    public function goldTrading()
    {
        return Service::where('slug', 'gold-trading')
                        ->first();
    }

    public function updateGoldTrading(Request $request)
    {
        $data = Service::where('slug', 'gold-trading')->first();

        if(is_null($data)) return response()->json(['error' => 'No data found.'], 422);

        $data->description = $request->description;
        $data->save();

        return response()->json(['msg' => 'Update successfully.'], 200);
    } 
}
