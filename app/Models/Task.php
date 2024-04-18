<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Task
 *
 * @mixin Builder
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'delivered_at',
        'user_id'
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
