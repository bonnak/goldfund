<?php
namespace App\Acme;

use App\Customer;

class Binary_BK
{	
	public static function queryPlacements($direction, $sponser_id)
	{
		$query = Customer::where('sponsor_id', $sponser_id)
                    ->Where('direction', $direction)
                    ->orderBy('placement_id', 'desc');
    return $query;
	}

	public static function placements($direction, $sponser_id = null)
	{
		$sponser_id = $sponser_id != null ?: 1;
		
		return self::queryPlacements($direction, $sponser_id)->get();
	}

	public static function lastPlacement($direction, $sponser_id = null)
	{
		$sponser_id = $sponser_id != null ?: 1;

		return self::queryPlacements($direction, $sponser_id)->first();
	}
}