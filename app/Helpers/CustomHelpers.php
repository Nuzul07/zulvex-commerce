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
            $latestEntry = DB::table('products')
                ->where(DB::raw('SUBSTRING(p_code, 6, 5)'), '=', $randNum)   // Check the random number part
                ->where(DB::raw('SUBSTRING(p_code, 2, 2)'), '=', $month)     // Check the month part
                ->where(DB::raw('SUBSTRING(p_code, 4, 2)'), '=', $year)      // Check the year part
                ->first();
        } while ($latestEntry);

        // Construct the user_id with the format: ZLV + month + year + random 3-digit number
        $p_code = $month . $year . $randNum;

        return $p_code;
    }

    public static function getVoucherCode()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');

        do {
            // Generate a random 3-digit number
            $randNum = str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT);

            // Check if a user with this pattern exists
            $latestEntry = DB::table('vouchers')
                ->where(DB::raw('SUBSTRING(v_code, 6, 3)'), '=', $randNum)   // Check the random number part
                ->where(DB::raw('SUBSTRING(v_code, 2, 2)'), '=', $month)     // Check the month part
                ->where(DB::raw('SUBSTRING(v_code, 4, 2)'), '=', $year)      // Check the year part
                ->first();
        } while ($latestEntry);

        // Construct the user_id with the format: ZLV + month + year + random 3-digit number
        $v_code = 'VCR' . $month . $year . $randNum;

        return $v_code;
    }

    public static function getAddressCode()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');

        do {
            // Generate a random 4-digit number
            $randNum = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);

            // Check if a user with this pattern exists
            $latestEntry = DB::table('addresses')
                ->where(DB::raw('SUBSTRING(adr_code, 6, 4)'), '=', $randNum)   // Check the random number part
                ->where(DB::raw('SUBSTRING(adr_code, 2, 2)'), '=', $month)     // Check the month part
                ->where(DB::raw('SUBSTRING(adr_code, 4, 2)'), '=', $year)      // Check the year part
                ->first();
        } while ($latestEntry);

        // Construct the user_id with the format: ZLV + month + year + random 3-digit number
        $adr_code = 'ADR' . $month . $year . $randNum;

        return $adr_code;
    }

    public static function getReviewCode()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');

        do {
            // Generate a random 3-digit number
            $randNum = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);

            // Check if a user with this pattern exists
            $latestEntry = DB::table('reviews')
            ->where(DB::raw('SUBSTRING(r_code, 6, 4)'), '=', $randNum)   // Check the random number part
                ->where(DB::raw('SUBSTRING(r_code, 2, 2)'), '=', $month)     // Check the month part
                ->where(DB::raw('SUBSTRING(r_code, 4, 2)'), '=', $year)      // Check the year part
                ->first();
        } while ($latestEntry);

        // Construct the user_id with the format: ZLV + month + year + random 3-digit number
        $r_code = 'REV' . $month . $year . $randNum;

        return $r_code;
    }

    public static function getPaymentCode()
    {
        $day = Carbon::now()->format('d');
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');

        do {
            // Generate a random 3-digit number
            $randNum = str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT);

            // Check if a user with this pattern exists
            $latestEntry = DB::table('payments')
            ->where(DB::raw('SUBSTRING(payment_code, 8, 3)'), '=', $randNum)   // Check the random number part
                ->where(DB::raw('SUBSTRING(payment_code, 2, 2)'), '=', $day)     // Check the month part
                ->where(DB::raw('SUBSTRING(payment_code, 4, 2)'), '=', $month)
                ->where(DB::raw('SUBSTRING(payment_code, 6, 2)'), '=', $year)      // Check the year part
                ->first();
        } while ($latestEntry);

        // Construct the user_id with the format: ZLV + month + year + random 3-digit number
        $payment_code = 'PAY' . $day . $month . $year . $randNum;

        return $payment_code;
    }

    public static function getWishlistCode()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');

        do {
            // Generate a random 3-digit number
            $randNum = str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT);

            // Check if a user with this pattern exists
            $latestEntry = DB::table('wishlists')
            ->where(DB::raw('SUBSTRING(w_code, 6, 3)'), '=', $randNum)// Check the month part
                ->where(DB::raw('SUBSTRING(w_code, 2, 2)'), '=', $month)
                ->where(DB::raw('SUBSTRING(w_code, 4, 2)'), '=', $year)      // Check the year part
                ->first();
        } while ($latestEntry);

        // Construct the user_id with the format: ZLV + month + year + random 3-digit number
        $w_code = 'WSH'. $month . $year . $randNum;

        return $w_code;
    }

    public static function getCartCode()
    {
        $day = Carbon::now()->format('d');
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');

        do {
            // Generate a random 3-digit number
            $randNum = str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT);

            // Check if a user with this pattern exists
            $latestEntry = DB::table('wishlists')
            ->where(DB::raw('SUBSTRING(w_code, 8, 3)'), '=', $randNum) // Check the month part
                ->where(DB::raw('SUBSTRING(w_code, 2, 2)'), '=', $day)
                ->where(DB::raw('SUBSTRING(w_code, 4, 2)'), '=', $month)
                ->where(DB::raw('SUBSTRING(w_code, 6, 2)'), '=', $year)      // Check the year part
                ->first();
        } while ($latestEntry);

        // Construct the user_id with the format: ZLV + month + year + random 3-digit number
        $c_code = 'CR'. $day . $month . $year . $randNum;

        return $c_code;
    }

}