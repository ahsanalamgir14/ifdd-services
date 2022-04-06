<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\OscCategorieOdd
 *
 * @property int $id
 * @property int $osc_id
 * @property int $categorie_odd_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OscCategorieOdd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OscCategorieOdd newQuery()
 * @method static \Illuminate\Database\Query\Builder|OscCategorieOdd onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OscCategorieOdd query()
 * @method static \Illuminate\Database\Eloquent\Builder|OscCategorieOdd whereCategorieOddId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OscCategorieOdd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OscCategorieOdd whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OscCategorieOdd whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OscCategorieOdd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OscCategorieOdd whereOscId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OscCategorieOdd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OscCategorieOdd withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OscCategorieOdd withoutTrashed()
 * @mixin \Eloquent
 */
class OscCategorieOdd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'osc_id',
        'categorie_odd_id', 'description',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
