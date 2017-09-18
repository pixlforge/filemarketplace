<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * Disable mass assignment protection for the following attributes.
     */
    protected $fillable = [
        'identifier',
        'buyer_email',
        'sale_price',
        'sale_commission'
    ];

    /**
     * Use the identifier attribute in routing.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'identifier';
    }

    /**
     * Compute total of commissions.
     *
     * @return mixed
     */
    public static function lifetimeCommission()
    {
        return static::all()->sum('sale_commission');
    }

    /**
     * Compute total of commission for this month.
     *
     * @return mixed
     */
    public static function commissionThisMonth()
    {
        return static::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->get()->sum('sale_commission');
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
     * Relation to File.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
