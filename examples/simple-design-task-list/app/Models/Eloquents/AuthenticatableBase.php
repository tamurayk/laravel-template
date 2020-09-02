<?php
declare(strict_types=1);

namespace App\Models\Eloquents;

use App\Models\Entities\InterfaceBase;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class AuthenticatableBase
 * @package App\Models\Eloquents
 */
abstract class AuthenticatableBase extends Authenticatable implements InterfaceBase
{
    use Notifiable;
}
