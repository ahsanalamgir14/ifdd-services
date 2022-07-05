<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ZoneIntervention
 *
 * @property int $id
 * @property int $osc_id
 * @property string $name
 * @property string $longitude
 * @property string $latitude
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention newQuery()
 * @method static \Illuminate\Database\Query\Builder|ZoneIntervention onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention query()
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention whereOscId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoneIntervention whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ZoneIntervention withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ZoneIntervention withoutTrashed()
 * @mixin \Eloquent
 */
class ZoneIntervention extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function oscs()
    {
        return $this->belongsTo(Osc::class, 'osc_id');
    }
}
