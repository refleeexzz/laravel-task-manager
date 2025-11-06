<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Comment Model
 * 
 * represents a comment on a task, allowing users to
 * discuss and collaborate on task details.
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'content',
    ];

    // prevent changing comment author
    protected $guarded = [
        'user_id',
    ];

    /**
     * get the task that this comment belongs to.
     *
     * @return BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * get the user who wrote the comment.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
