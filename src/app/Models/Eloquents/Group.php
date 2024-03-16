<?php

namespace App\Models\Eloquents;

use App\Models\Interfaces\GroupInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Eloquent implements GroupInterface
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return BelongsTo<Administrator, Group>
     */
    public function administrator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }
}
