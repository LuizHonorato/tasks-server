<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'user_id', 'name', 'created_at', 'updated_at'];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
