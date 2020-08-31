<?php
declare(strict_types=1);

namespace App\Entities\Eloquents;

use App\Entities\Contracts\EloquentBase as EloquentBaseInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EloquentBase
 * @package App\Entities\Eloquents
 */
abstract class EloquentBase extends Model implements EloquentBaseInterface
{
    //
}
