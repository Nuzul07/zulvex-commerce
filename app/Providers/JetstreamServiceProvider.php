<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Http\Responses\LoginResponse as ResponsesLoginResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LoginResponse;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        $this->app->singleton(LoginResponse::class, ResponsesLoginResponse::class);

        // Custom authentication logic for login
        Fortify::authenticateUsing(function (Request $request) {
            // Look for the user by email or username
            $user = User::where('email', $request->twoauth)
                ->orWhere('username', $request->twoauth)
                ->first();

            // If the user does not exist, throw an exception for wrong username/email
            if (!$user) {
                throw ValidationException::withMessages([
                    'twoauth' => ['username or email is incorrect'],
                ]);
            }

            // If the user exists but the password is incorrect
            if (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'password' => ['password is incorrect'],
                ]);
            }

            // If both checks pass, return the user
            return $user; // Only return the user if both checks are successful
        });
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
