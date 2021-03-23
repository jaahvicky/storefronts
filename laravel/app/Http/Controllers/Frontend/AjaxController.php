<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Suburb;

use App\Models\StoreDeliveryMethod;

use App\Models\Store;

class AjaxController extends BaseController
{

    // const ECONET_LOGISTICS_INDEX = 0;
    
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
	 * Fetches suburbs based on city id or all.
	 * 
	 * Only returns the suburbs related to a city if id is passed.
	 * 
	 * @param int $cityid
	 * @return App\Models\Store $store
	 */

    // need it for ajax functionality, so added it to a controller for use in the route
	public function getSuburbs($cityid = null)
	{

		$suburbs = [];

		if ($cityid) {
			$suburbs = Suburb::where('city_id', $cityid)->get();
		} else {
			$suburbs = Suburb::all();
		}

		return $suburbs;
	
	}

	/**
     * Fetches the store delivery methods
     * 
     * Only returns the logistics option if logistics is true,
     * depending on if the store is in Harare
     * 
     * @param boolean $logistics
     * @param boolean $propertyOrVehicle
     * @return array $storefront_delivery_method
    */
    public function getDeliveryMethods($logistics = false, $propertyOrVehicle = false)
    {
        
       $delivery_method = StoreDeliveryMethod::all();
        $storefront_delivery_method = [];
        foreach ($delivery_method as $delivery) {
           $storefront_delivery_method[$delivery->id]= $delivery->method;
        }

        $logistics = (!$logistics || $logistics === 'false') ? false : true;
        $propertyOrVehicle = (!$propertyOrVehicle || $propertyOrVehicle === 'false') ? false : true;

        if($propertyOrVehicle || !$logistics) {

            $logistics_index = Store::ECONET_LOGISTICS - 1;
            unset($delivery_method[$logistics_index]); // option no 1 - Use Econet Logistics
        }

        if($propertyOrVehicle) {

            $collect_in_store_index = Store::DELIVERY_COLLECT_IN_STORE - 1;
            unset( $delivery_method[$collect_in_store_index] );

        }

        return $delivery_method;

    }

}
