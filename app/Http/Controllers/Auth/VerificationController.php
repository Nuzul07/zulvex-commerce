<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerificationController extends Controller
{
    // Show the email verification form
    public function showVerifyForm()
    {
        return Inertia::render('Auth/VerifyEmail');
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);

        $user = User::where('otp', $request->otp)
            ->where('otp_expires_at', '>', now())
            ->first();

        if ($user) {
            // OTP is valid, proceed with email verification
            $user->update([
                'email_verified_at' => now(),
                'otp' => null, // Clear the OTP after successful verification
                'otp_expires_at' => null,
                'status' => 1,
            ]);

            return redirect()->route('login');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP']);
    }
}
