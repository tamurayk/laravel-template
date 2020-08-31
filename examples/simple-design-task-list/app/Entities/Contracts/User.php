<?php
declare(strict_types=1);

namespace App\Entities\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Interface User
 * @package App\Entities\Contracts
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $string
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|Task[]|null $tasks
 */
interface User extends EloquentBase
{
    /**
     * @return HasMany
     */
    public function tasks(): HasMany;
}
