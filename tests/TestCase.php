<?php

namespace Tests;

use RonasIT\Support\Testing\TestCase as BaseTestCase;
use RonasIT\AutoDoc\Traits\AutoDocTestCaseTrait;

abstract class TestCase extends BaseTestCase
{
    use AutoDocTestCaseTrait;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->loadEnvironmentFrom('.env.testing');
    }
}
