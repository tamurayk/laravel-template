<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\AdminController;
use App\Http\UseCases\Admin\User\Interfaces\UserIndexInterface;

class UserIndexController extends AdminController
{
    public function __invoke(UserIndexInterface $useCase)
    {
        $users = $useCase();

        return view('admin.user.index', [
            'users' => $users,
        ]);
    }
}
