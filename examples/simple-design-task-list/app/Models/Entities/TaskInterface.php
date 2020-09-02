<?php
declare(strict_types=1);

namespace App\Models\Entities;

use App\Models\Eloquents\User;

/**
 * Interface TaskInterface
 * @package App\Models\Entities
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property User|null $user
 */
interface TaskInterface extends InterfaceBase
{
    //
}
