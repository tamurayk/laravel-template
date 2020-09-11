<?php

namespace Tests\Feature\app\Http\Controllers\Admin\User;

use App\Models\Eloquents\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Tests\BaseTestCase;

class UserIndexControllerTest extends BaseTestCase
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
     */
    public function index_未ログインの場合はログイン画面にリダイレクト()
    {
        // 未ログインの場合

        // ユーザーとしてログインしている場合

        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function index_管理者でログインしている場合は200が返る()
    {
        // 管理者ログイン

        // HTTPリクエスト

        // 200が返る事を確認
        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function index_管理者でログインしている場合はユーザー一覧画面を表示()
    {
        // Generate test data.
        for ($i = 1; $i <= 3; $i++) {
            factory(User::class, 1)->create([
                'id' => $i,
                'name' => sprintf('user-%s', $i),
            ]);
        }
        $this->assertEquals(3, DB::table('users')->count());

        // TODO: ADD authentication.

        // TODO: Check authenticated.

        // HTTP request
        $response = $this->get('/admin/users');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('admin.user.index');

        // Assert view vars
        $expected = new Collection([
            (new User())->newQuery()->find(1),
            (new User())->newQuery()->find(2),
            (new User())->newQuery()->find(3),
        ]);
        $response->assertViewHas('users', $expected);

        // Assert HTML
        $this->assertNotFalse(strpos($response->content(), '<title>admin page</title>'));
        $this->assertNotFalse(strpos($response->content(), '<h1>users</h1>'));
        $this->assertNotFalse(strpos($response->content(), '<th>id</th>'));
        $this->assertNotFalse(strpos($response->content(), '<th>name</th>'));
        $this->assertNotFalse(strpos($response->content(), '<th>email</th>'));
        $this->assertNotFalse(strpos($response->content(), '<td>user-1</td>'));
        $this->assertNotFalse(strpos($response->content(), '<td>user-2</td>'));
        $this->assertNotFalse(strpos($response->content(), '<td>user-3</td>'));
        $this->assertFalse(strpos($response->content(), '<td>user-4</td>'));
    }
}
