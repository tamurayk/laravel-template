<?php

namespace App\Models\Eloquents;

use App\Models\Interfaces\AdministratorInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Administrator extends Authenticatable implements AdministratorInterface
{
    use HasFactory;

    protected $table = 'administrators';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'group_id',
        'name',
        'email',
        'password',
    ];

    /**
     * @inheritdoc
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasOne<Group>
     */
    public function group(): HasOne
    {
        return $this->hasOne(Group::class);
    }
}
