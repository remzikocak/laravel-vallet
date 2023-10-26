<?php

declare(strict_types=1);

namespace RKocak\Vallet\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RKocak\Vallet\ValletServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ValletServiceProvider::class,
        ];
    }
}
