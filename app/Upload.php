<?php

namespace App;

use App\Traits\HasApprovals;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use SoftDeletes, HasApprovals;

    /**
     * Mass assignable fields.
     */
    protected $fillable = [
        'filename',
        'size',
        'approved'
    ];

    /**
     * Build the full path.
     */
    public function getPathAttribute()
    {
        return storage_path("app/files/{$this->file->identifier}/{$this->filename}");
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

    /**
     * Relation to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
