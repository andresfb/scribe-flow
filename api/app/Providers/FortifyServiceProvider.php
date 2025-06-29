<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\LoginResponse;
use App\Actions\Fortify\LogoutResponse;
use App\Actions\Fortify\PasswordUpdateResponse;
use App\Actions\Fortify\RegisterResponse;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse as FortifyLoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse as FortifyLogoutResponse;
use Laravel\Fortify\Contracts\PasswordUpdateResponse as FortifyPasswordUpdateResponse;
use Laravel\Fortify\Contracts\RegisterResponse as FortifyRegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //customized login response
        $this->app->instance(FortifyLoginResponse::class, new LoginResponse);

        //customized register response
        $this->app->instance(FortifyRegisterResponse::class, new RegisterResponse);

        //customized logout response
        $this->app->instance(FortifyLogoutResponse::class, new LogoutResponse);

        //customized password update response
        $this->app->instance(FortifyPasswordUpdateResponse::class, new PasswordUpdateResponse);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', static function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', static function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
