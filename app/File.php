<?php

namespace App;

use App\Traits\HasApprovals;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\File
 *
 * @property-read \App\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property string $identifier
 * @property int $user_id
 * @property string $title
 * @property string $overview_short
 * @property string $overview
 * @property float $price
 * @property int $live
 * @property int $approved
 * @property int $finished
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereFinished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereOverview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereOverviewShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUserId($value)
 */
class File extends Model
{
    use SoftDeletes, HasApprovals;

    /**
     * Mass assignable fields.
     */
    protected $fillable = [
        'title',
        'overview_short',
        'overview',
        'price',
        'live',
        'approved',
        'finished'
    ];

    /**
     * Cast fields into specific types.
     */
    protected $casts = [
        'live' => 'boolean'
    ];

    const APPROVAL_PROPERTIES = [
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

        static::creating(function ($file) {
            $file->identifier = uniqid(true);
        });
    }

    /**
     * Field to use as routing key.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'identifier';
    }

    /**
     * Return finished files.
     *
     * @return File|\Illuminate\Database\Eloquent\Builder
     */
    public function scopeFinished(Builder $builder)
    {
        return $builder->where('finished', true);
    }

    /**
     * Checks wether the file is free.
     *
     * @return bool
     */
    public function isFree()
    {
        return $this->price === 0;
    }

    /**
     * Checks wether the file is live.
     *
     * @return bool
     */
    public function isLive()
    {
        return $this->live === true;
    }

    /**
     * Checks wether the updated model needs to be approved after a change.
     *
     * @param array $approvalProperties
     * @return bool
     */
    public function needsApproval($approvalProperties = [])
    {
        if ($this->currentPropertiesDifferToGiven($approvalProperties)) {
            return true;
        }

        if ($this->uploads()->unapproved()->count()) {
            return true;
        }

        return false;
    }

    /**
     * Create the approval.
     */
    public function createApproval($approvalProperties = [])
    {
        $this->approvals()->create($approvalProperties);
    }

    /**
     * Checks if the request properties differ from current value.
     *
     * @param array $properties
     * @return bool
     */
    protected function currentPropertiesDifferToGiven($properties = [])
    {
        return array_only($this->toArray(), self::APPROVAL_PROPERTIES) !== $properties;
    }

    /**
     * Live attribute mutator.
     *
     * @param $value
     */
    public function setLiveAttribute($value)
    {
        $this->attributes['live'] = $value === 'on' ? true : false;
    }

    /**
     * Relation to Upload.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function uploads()
    {
        return $this->hasMany(Upload::class);
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

    /**
     * Relation to FileApproval.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvals()
    {
        return $this->hasMany(FileApproval::class);
    }
}
