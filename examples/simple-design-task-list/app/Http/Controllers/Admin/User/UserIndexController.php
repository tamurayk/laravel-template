<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Admin\User\Interfaces\UserIndexInterface;

class UserIndexController extends Controller
{
    public function __invoke(UserIndexInterface $useCase)
    {
        $users = $useCase();

        return view('admin.user.index', [
            'users' => $users,
        ]);
    }
}
