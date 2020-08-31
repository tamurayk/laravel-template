<?php

namespace App\Entities\Eloquents;

use App\Entities\Contracts\Task as TaskInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends EloquentBase implements TaskInterface
{
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
