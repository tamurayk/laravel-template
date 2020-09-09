<?php

namespace Tests;

use Illuminate\Database\Connection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class BaseTestCase extends TestCase
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
        /** @var Connection $connection */
        $connection = DB::connection();
        $tables = $connection->getDoctrineSchemaManager()->listTableNames();

        // 各テスト毎のテストデータの独立性を保つように、テスト毎に truncate している
        foreach ($tables as $tableName) {
            DB::table($tableName)->truncate();
        }

        parent::tearDown();
    }
}
