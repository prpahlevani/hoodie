<?php

namespace Motrack\Hoodie\Facades;

use Illuminate\Support\Facades\Facade;
use Motrack\Hoodie\Interfaces\ApiResponderInterface;

class Hoodie extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return ApiResponderInterface::class;
    }
}
