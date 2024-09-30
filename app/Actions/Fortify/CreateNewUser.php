<?php

namespace App\Actions\Fortify;

use App\Helpers\CustomHelpers;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Jetstream;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        $validator = Validator::make($input, [
            'username' => ['required', 'string', 'max:255'],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits_between:11,13', 'unique:users'],
            'password' => $this->passwordRules(),
            'password_confirmation' => ['required', 'string'],
        ],[
            'username.required' => 'Username tidak boleh kosong',
            'fullname.required' => 'Fullname tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email tersebut sudah terdaftar',
            'phone.required' => 'No HP tidak boleh kosong',
            'phone.numeric' => 'No HP harus berupa angka',
            'phone.unique' => 'No HP tersebut sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password_confirmation.required' => 'Konfirmasi Password tidak boleh kosong',
        ]);

        // Throw validation error if the input is invalid
        if ($validator->fails()) {
            // Use `toArray()` only if you're passing an array explicitly
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $validatedData = $validator->validated();
        $otp = rand(100000, 999999);

        $user = User::create([
            'user_id' => CustomHelpers::getUserId(),
            'username' => $validatedData['username'],
            'fullname' => $validatedData['fullname'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'plain_password' => $validatedData['password'],
            'status' => 0,
        'otp' => $otp, // Store OTP
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        // Send OTP email
        Mail::to($user->email)->send(new OtpMail($otp));
    }
}
