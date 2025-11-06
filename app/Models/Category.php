<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Category Model
 * 
 * represents a category that can be assigned to multiple tasks.
 * categories help organize and filter tasks by type or context.
 */
class Category extends Model
{
    use HasFactory;

    /**
     * the attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'color',
        'description',
    ];

    /**
     * get all tasks that have this category.
     * many-to-many relationship.
     *
     * @return BelongsToMany
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class)
                    ->withTimestamps();
    }
}
