<?php
declare(strict_types=1);

namespace App\Http\UseCases\Admin\User\Interfaces;

use App\Models\Interfaces\UserInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface UserIndexInterface
{
    public function __construct(UserInterface $user);

    /**
     * @return LengthAwarePaginator<Model>
     */
    public function __invoke(
        array $paginatorParam = []
    ): LengthAwarePaginator;
}
