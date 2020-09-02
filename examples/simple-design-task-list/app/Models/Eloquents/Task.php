<?php

namespace App\Models\Eloquents;

use App\Models\Entities\TaskInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends EloquentBase implements TaskInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
