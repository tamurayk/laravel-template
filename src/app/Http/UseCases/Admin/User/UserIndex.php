<?php

namespace App\Http\UseCases\Admin\User;

use App\Http\UseCases\Admin\User\Interfaces\UserIndexInterface;
use App\Models\Eloquents\User;
use App\Models\Interfaces\UserInterface;

class UserIndex implements UserIndexInterface
{
    /** @var User */
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function __invoke()
    {
        $query = $this->user->newQuery();
        $users = $query->get();

        return $users;
    }
}
