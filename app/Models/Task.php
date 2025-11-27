<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
    BelongsToMany
};

class Task extends Model
{
   protected $fillable = [
    'title',
    'description',
    'status',
    'parent_id',
    'start_date',
    'end_date',
    'estimated_hours',
    'actual_hours',
];


protected $casts = [
    'start_date'      => 'date',
    'end_date'        => 'date',
    'estimated_hours' => 'decimal:2',
    'actual_hours'    => 'decimal:2',
];

    protected static function booted()
    {
        static::deleting(function (Task $task) {
            // borrar todas las subtareas recursivamente
            foreach ($task->children as $child) {
                $child->delete();
            }
        });
    }

    // tarea padre
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    // subtareas directas
    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    // usuarios asignados
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }
}
