<?php

namespace Tests\Feature\app\Http\Controllers\Task;

use App\Models\Eloquents\Task;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCaseBase;

class TaskIndexControllerTest extends TestCaseBase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function index_未ログインの場合はログイン画面にリダイレクト()
    {
        // 認証されていない事を確認
        $this->assertGuest(null);

        $response = $this->get('/tasks');

        // 未認証の場合は、login 画面にリダイレクトする事
        $response->assertStatus(302);
        $response->assertLocation('http://localhost/login');
        $response->assertRedirect('http://localhost/login');
    }

    /**
     * @test
     */
    public function index_ログイン中の場合は200が返る()
    {
        // 認証されていない事を確認
        $this->assertGuest(null);

        // 認証
        $user = factory(\App\Models\Eloquents\User::class)->create();
        $authUser = $this->actingAs($user, 'web');

        // 認証済みである事を確認
        $this->assertAuthenticated('web');

        // HTTP リクエスト
        $response = $authUser->get('/tasks');

        // 認証済みユーザーからのリクエストの場合は 200 が返る事
        $response->assertStatus(200);
        // 正しい Blade ファイルを表示している事
        $response->assertViewIs('tasks.index');
    }

    /**
     * @test
     */
    public function index_ログイン中ユーザーのタスク一覧を表示()
    {
        // Generate test data.
        factory(Task::class, 1)->create([
            'id' => 1,
            'user_id' => 1,
        ]);
        factory(Task::class, 1)->create([
            'id' => 2,
            'user_id' => 2,
        ]);
        factory(Task::class, 1)->create([
            'id' => 3,
            'user_id' => 1,
        ]);

        // Check not authenticate.
        $this->assertGuest(null);

        /**
         * user_id = 1
         */
        // Add authentication.
        $user = factory(\App\Models\Eloquents\User::class)->create([
            'id' => 1,
        ]);
        $authUser = $this->actingAs($user, 'web');

        // Check authenticated.
        $this->assertAuthenticated('web');

        // Http request
        $response = $authUser->get('/tasks');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');

        // Assert view vars.
        // note: 期待値は、中身が TaskEloquentModel の配列の Collection
        $expected = new Collection([
            (new Task())->newQuery()->find(1), //note: EloquentModel の find() は EloquentModel を返す
            (new Task())->newQuery()->find(3),
        ]);
        $response->assertViewHas('tasks', $expected);

        /**
         * user_id = 2
         */
        // Add authentication.
        $user = factory(\App\Models\Eloquents\User::class)->create([
            'id' => 2,
        ]);
        $authUser = $this->actingAs($user, 'web');

        // Http request
        $response = $authUser->get('/tasks');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');

        // Assert view vars.
        $expected = new Collection([
            (new Task())->newQuery()->find(2),
        ]);
        $response->assertViewHas('tasks', $expected);

    }
}
