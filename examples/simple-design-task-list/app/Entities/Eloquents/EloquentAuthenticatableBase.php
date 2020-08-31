<?php
declare(strict_types=1);

namespace App\Entities\Eloquents;

use App\Entities\Contracts\EloquentBase;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Authenticatable
 * @package App\Entities\Eloquents
 */
abstract class EloquentAuthenticatableBase extends Authenticatable implements EloquentBase
{
    use Notifiable;
}
