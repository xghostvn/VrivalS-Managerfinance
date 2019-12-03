<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class helperController extends Controller
{
    //

    public static function formatDate($date)
    {
        try {
            $dt = new \DateTime($date);
            $date = $dt->format("Y-m-d");
        } catch (\Exception $e) {

        }
        $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));// 1 day
        return $date;

    }

    public static function formatMoney($number, $fractional=false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number . " VND";
    }

    public static function createSessionExport($type,$wallet_id,$to,$from)
    {
            session()->put('export',$type);
            session()->put('wallet_id',$wallet_id);
                if($type=='date') {
                    if($to&&$from) {
                        session()->put('to',$to);
                        session()->put('from',$from);
                    }
                }


    }



}
