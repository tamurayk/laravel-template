<?php
declare(strict_types=1);

namespace App\Entities\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Interface User
 * @package App\Entities\Contracts
 * @property Collection|Task[]|null $tasks
 */
interface User extends EloquentBase
{
    /**
     * @return HasMany
     */
    public function tasks(): HasMany;
}
