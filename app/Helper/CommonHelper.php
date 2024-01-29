<?php

namespace App\Helper;

use App\Models\AgeGroup;
use App\Models\EventLocation;
use App\Models\ItemOrder;
use Illuminate\Http\Request;
use App\Models\TestTransaction;
use App\Models\PatientDetails;
use App\Models\PriceList;

class CommonHelper
{


    public static function getTestCount($created_date,$to_date,$test_name){
        return TestTransaction::whereBetween('created_at', [$created_date, $to_date])->where('inv_name', '=', $test_name)->count();
    }
    public static function getPatientCount($created_date,$to_date){
        return PatientDetails::whereBetween('created_at', [$created_date, $to_date])->count();
    }
    // public static function isNonCompetitive($status){
    //     return $status == self::NON_COMPETIVIVE;
    // }


    public static function getEventLocationId(){
        return request("location_string");
    }

    public static function getItemName($id)
    {
        $name = PriceList::where('id',$id)->value('name');
        return $name;
    }

    public static function generateSerialNumber()
    {
        // Get the last used serial number from the database
        $lastOrder = ItemOrder::latest()->first();
        $lastSerialNumber = $lastOrder ? (int)substr($lastOrder->order_no, -7) : 0; 
        $newSerialNumber = $lastSerialNumber + 1;

        // Return the new serial number formatted with leading zeros
        return str_pad($newSerialNumber, 4, '0', STR_PAD_LEFT);
    }
}
