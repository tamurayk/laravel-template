<?php
declare(strict_types=1);

namespace App\Entities\Contracts;

use Carbon\Carbon;

/**
 * Interface Task
 * @package App\Entities\Contracts
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property \App\Entities\Eloquents\User|null $user
 */
interface Task extends EloquentBase
{
    //
}
