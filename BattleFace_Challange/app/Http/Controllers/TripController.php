<?php

namespace App\Http\Controllers;

use App\Models\QoutesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TripController extends Controller
{
    //18-30 0.6
    //31-40 0.7
    //41-50 0.8
    //51-60 0.9
    //61-70 1
    public function calculateAgeLoad($age) {
        $ageAsNum = (int) $age;
        switch($ageAsNum) {
            case ($ageAsNum >= 18 && $ageAsNum <= 30):
                return 0.6;
            case ($ageAsNum >= 31 && $ageAsNum <= 40):
                return 0.7;
            case ($ageAsNum >= 41 && $ageAsNum <= 50):
                return 0.8;
            case ($ageAsNum >= 51 && $ageAsNum <= 60):
                return 0.9;
            case ($ageAsNum >= 61 && $ageAsNum <= 70):
                return 1.0;
            default:
                break;
        }
    }

    public function postQuotation(Request $request){
        $FIXED_RATE_PER_DAY = 3.00;

        $currency = $request->input('currency');
        $country = $request->input('country');
        $ages = $request->input('ages');
        $total = $request->input('total');
        $start = $request->input('start');
        $end = $request->input('end');
        $startDate = Carbon::parse($start,'EST');
        $endDate = Carbon::parse($end,'EST');

        $tripLength = $startDate->diffInDays($endDate);

        //these ages need to be comma separated.
        $listOfAges = explode(",", $ages);
        $totalPrice = 0.0;

        // calc the total price of the policy based on the fixed rate per day, individual age load, and trip length
        foreach($listOfAges as $age) {
            if($age >= 18) {
                $load = $this->calculateAgeLoad($age);
                $totalPrice += ($FIXED_RATE_PER_DAY * $load * $tripLength);
            }
        }

        $quotation = QoutesModel::create([
            'ages'=> $ages,
            'destination'=>  $country,
            'currency'=> $currency,
            'total'=> floatval($total),
            'start_date'=>$startDate,
            'end_date'=> $endDate
        ]);



        return response()->json([
            'currency_id' => $currency,
            'total' => $totalPrice,
            'quotation_id' => $quotation->id,
            'diff'=>$tripLength
        ]);
    }
}
