<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileApproval extends Model
{
    use SoftDeletes;

    /**
     * Database table name.
     */
    protected $table = 'file_approvals';

    /**
     * Mass assignable fields.
     */
    protected $fillable = [
        'title',
        'overview_short',
        'overview'
    ];

    /**
     * Model boot method.
     */
    protected static function boot()
    {
        parent::boot();

        // Delete all existing approvals for a given file when creating a new Approval.
        static::creating(function ($approval) {
            $approval->file->approvals->each->delete();
        });
    }

    /**
     * Relation to File.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
