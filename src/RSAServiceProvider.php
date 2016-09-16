<?php namespace TinyAda\RSA;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class RSAServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('rsa.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('rsa', function () {
            return $this->app->make('TinyAda\RSA\RSALib');
        });
    }
}
