<?php
declare(strict_types=1);

namespace App\Models\Eloquents;

use App\Models\Interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

/**
 * Class Authenticatable
 * @package App\Models\Eloquents
 */
abstract class Authenticatable extends User implements BaseInterface
{
    use HasFactory;

    use Notifiable;
}
