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

    /**
     * @throws \Throwable
     */
    public function tearDown(): void
    {
        // RefreshDatabase トレイトで migration が行われるのはテスト開始時に一度だけの為、
        // 各テスト毎に migration:refresh して、各テスト毎のテストデータの独立性を保つようにしている
        Artisan::call('migrate:refresh');
        parent::tearDown();
    }
}
