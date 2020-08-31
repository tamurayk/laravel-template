<?php

namespace App\Entities\Eloquents;

use App\Entities\Contracts\Task as TaskInterface;

class Task extends EloquentBase implements TaskInterface
{
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
