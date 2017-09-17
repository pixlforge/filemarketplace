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
        'live' => 'boolean',
        'approved' => 'boolean'
    ];

    const APPROVAL_PROPERTIES = [
        'title',
        'overview_short',
        'overview'
    ];

    /**
     * Live attribute mutator.
     *
     * @param $value
     */
    public function setLiveAttribute($value)
    {
        if ($value === 'on') {
            $this->attributes['live'] = true;
        }

        if ($value === 'true' || $value === true) {
            $this->attributes['live'] = true;
        }

        if ($value === 'false' || $value === false) {
            $this->attributes['live'] = false;
        }
    }

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
     * Attribute to use as routing key.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'identifier';
    }

    /**
     * Checks wether the file should be visible to the user.
     *
     * @return bool
     */
    public function visible()
    {
        if (auth()->user()->isAdmin()) {
            return true;
        }

        if (auth()->user()->isTheSameAs($this->user)) {
            return true;
        }

        return $this->isApproved() && $this->isLive();
    }

    /**
     * Merge all updated approval properties with the File model.
     */
    public function mergeApprovalProperties()
    {
        $this->update(
            $this->approvals->first()->only(File::APPROVAL_PROPERTIES)
        );
    }

    /**
     * Delete all approvals.
     */
    public function deleteAllApprovals()
    {
        $this->approvals()->delete();
    }

    /**
     * Approve the file.
     */
    public function approve()
    {
        $this->updateToBeVisible();
        $this->approveAllUploads();
    }

    /**
     * Set the file as approved and live.
     */
    public function updateToBeVisible()
    {
        $this->update([
            'live' => true,
            'approved' => true
        ]);
    }

    /**
     * Set all uploads related to the file as approved.
     */
    public function approveAllUploads()
    {
        $this->uploads()->update([
            'approved' => true
        ]);
    }

    /**
     * Delete all unapproved uploads.
     */
    public function deleteUnapprovedUploads()
    {
        $this->uploads()->unapproved()->delete();
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
        return $this->price <= 0;
    }

    /**
     * Checks wether the file is live.
     *
     * @return bool
     */
    public function isLive()
    {
        return $this->live;
    }

    /**
     * Set the file as not live nor approved.
     */
    public function unlive()
    {
        $this->update([
            'live' => false
        ]);
    }

    /**
     * Checks wether the file is approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->approved;
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
     * Calculate the commission for a given file.
     *
     * @return float|int
     */
    public function calculateCommission()
    {
        return (config('filemarket.sales.commission') / 100) * $this->price;
    }

    /**
     * Checks wether a file matches a sale.
     *
     * @param Sale $sale
     */
    public function matchesSale(Sale $sale)
    {
        return $this->sales->contains($sale);
    }

    /**
     * Build a list of all uploads.
     */
    public function getUploadList()
    {
        return $this->uploads()->approved()->get()
            ->pluck('path')->toArray();
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

    /**
     * Relation to Sale.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
