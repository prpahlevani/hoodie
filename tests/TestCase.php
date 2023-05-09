<?php

namespace Motrack\Hoodie\Tests;

use Motrack\Hoodie\Facades\Hoodie;
use Motrack\Hoodie\Providers\HoodieServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            HoodieServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Hoodie' => Hoodie::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
