<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomHelpers
{
    public static function getUserId()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');

        do {
            // Generate a random 3-digit number
            $randNum = str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT);

            // Check if a user with this pattern exists
            $latestEntry = DB::table('users')
            ->where(DB::raw('SUBSTRING(user_id, 8, 3)'), '=', $randNum)   // Check the random number part
                ->where(DB::raw('SUBSTRING(user_id, 4, 2)'), '=', $month)     // Check the month part
                ->where(DB::raw('SUBSTRING(user_id, 6, 2)'), '=', $year)      // Check the year part
                ->first();
        } while ($latestEntry);

        // Construct the user_id with the format: ZLV + month + year + random 3-digit number
        $user_id = 'ZLV' . $month . $year . $randNum;

        return $user_id;
    }

    public static function getProductCode()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');

        do {
            // Generate a random 3-digit number
            $randNum = str_pad(random_int(1, 99999), 5, '0', STR_PAD_LEFT);

            // Check if a user with this pattern exists
            $latestEntry = DB::table('users')
                ->where(DB::raw('SUBSTRING(user_id, 6, 3)'), '=', $randNum)   // Check the random number part
                ->where(DB::raw('SUBSTRING(user_id, 2, 2)'), '=', $month)     // Check the month part
                ->where(DB::raw('SUBSTRING(user_id, 4, 2)'), '=', $year)      // Check the year part
                ->first();
        } while ($latestEntry);

        // Construct the user_id with the format: ZLV + month + year + random 3-digit number
        $p_code = $month . $year . $randNum;

        return $p_code;
    }

}