<?php

namespace Tapp\Ezeep\Tests;

use Orchestra\Testbench\TestCase;
use Tapp\Ezeep\EzeepServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [EzeepServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
