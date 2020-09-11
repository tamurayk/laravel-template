<?php

namespace App\Http\UseCases\Admin\User\Interfaces;

use App\Models\Interfaces\UserInterface;

interface UserIndexInterface
{
    public function __construct(UserInterface $user);

    public function __invoke();
}
