<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property bool $done
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Todo extends Model
{
    protected $fillable = ['title', 'done'];

    protected $casts = [
        'done' => 'boolean',
        'completed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Todo $todo) {
            if ($todo->isDirty('done')) {
                $todo->completed_at = $todo->done ? now() : null;
            }
        });
    }
}
