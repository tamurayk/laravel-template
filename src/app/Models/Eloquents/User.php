<?php
declare(strict_types=1);

// FIXME: Laravel の標準的な慣習に従うように修正
namespace App\Models\Eloquents;

use App\Models\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements UserInterface
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * @return HasMany<Task>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
