<?php

namespace Tests;

class StatusTest extends TestCase
{
    public function testStatus()
    {
        $this->get('/status')->assertOk();
    }
}
