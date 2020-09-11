<?php

namespace App\Models\Eloquents;

use App\Models\Interfaces\AdministratorInterface;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Administrator extends Authenticatable implements AdministratorInterface
{
    protected $table = 'administrators';

    /**
     * @var array
     */
    protected $fillable = [
        'group_id',
        'name',
        'email',
        'password',
    ];

    /**
     * @return HasOne
     */
    public function group(): HasOne
    {
        return $this->hasOne(Group::class);
    }
}
