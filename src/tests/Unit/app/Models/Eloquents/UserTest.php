<?php
declare(strict_types=1);

namespace Test\Unit\app\Models\Eloquents;

use App\Models\Eloquents\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\AppTestCase;

class UserTest extends AppTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }


    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     * @group save
     */
    public function デフォルト値未設定のカラムの値を指定せずにsaveした場合は例外がthrowされる事()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     * @group save
     */
    public function 登録済みのemailを指定してsaveした場合は例外がthrowされる事()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     * @group save
     */
    public function saveできる事()
    {
        Carbon::setTestNow(Carbon::parse('2020-01-01 00:00:00'));

        $this->assertEquals(0, DB::table('users')->count(), 'テスト開始時点でテーブルが空である事を確認');

        $hash = Hash::make('c');
        $fill = [
            'name' => 'a',
            'email' => 'b',
            'password' => $hash,
        ];

        $userEloquent = new User();
        $user = $userEloquent->newInstance($fill);
        $result = $user->save();

        $this->assertTrue($result);
        $this->assertEquals(1, DB::table('users')->count(), 'レコードが1件追加されている事');
        $this->assertDatabaseHas('users', [
            'id' => 1,
            'name' => 'a',
            'email' => 'b',
            'email_verified_at' => null,
            'password' => $hash,
            'remember_token' => null,
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ]);
    }

    /**
     * @test
     */
    public function testFillable()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function testRelation()
    {
        $this->markTestIncomplete();
    }
}
