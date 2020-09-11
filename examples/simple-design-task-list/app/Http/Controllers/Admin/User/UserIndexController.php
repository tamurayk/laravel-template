<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;

class UserIndexController extends Controller
{
    public function __invoke()
    {
        return view('admin.user.index', [
            'tasks' => [],
        ]);
    }
}
