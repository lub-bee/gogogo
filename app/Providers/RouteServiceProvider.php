<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';
    public const ADMIN_HOME = '/management';
    public const SUPPORT_HOME = '/management';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configurateRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        $this->redirectUserByRole();
    }

    /**
     * Redirects the user based on their role.
     *
     * This function checks if the user is authenticated and redirects them to the appropriate route
     * based on their role. If the user is not authenticated, it does nothing.
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function redirectUserByRole()
    {
        Auth::user() ? function(){
            dd(Auth::user()->rank);
            switch (Auth::user()->rank) {
                case User::RANK_ADMIN:
                    return redirect()->route(self::ADMIN_HOME);
                case User::RANK_SUPPORT:
                    return redirect()->route(self::SUPPORT_HOME);
                default:
                    return redirect()->route(self::HOME);
            }
        } : null;
    }

    /**
     * Configures rate limiting for the 'api' route.
     *
     * This function sets up rate limiting for the 'api' route using Laravel's RateLimiter.
     * It limits the number of requests per minute for each user, identified by their ID or IP address.
     *
     * @return void
     */
    public function configurateRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
