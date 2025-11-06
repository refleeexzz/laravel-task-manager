<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Attachment Model
 * 
 * represents a file attachment linked to a task.
 * stores metadata about uploaded files including name,
 * path, type, and size.
 */
class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'filename',
        'path',
        'mime_type',
        'size',
    ];

    // prevent changing who uploaded the file
    protected $guarded = [
        'user_id',
    ];

    /**
     * get the task that this attachment belongs to.
     *
     * @return BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * get the user who uploaded the attachment.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
