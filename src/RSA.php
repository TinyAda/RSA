<?php namespace TinyAda\RSA;

use Illuminate\Support\Facades\Facade;

class RSA extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rsa';
    }

}