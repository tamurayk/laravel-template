<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class TestCaseBase extends TestCase
{
    // Run migration automatically before run test.
    // Undo data changed during the test.
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Clear config cache before run test.
        Artisan::call('config:clear');
    }
}
