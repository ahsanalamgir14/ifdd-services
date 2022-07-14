<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CategorieOdd
 *
 * @property int $id
 * @property string $category_number
 * @property string $intitule
 * @property int $id_odd
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Odd|null $odd
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieOdd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieOdd newQuery()
 * @method static \Illuminate\Database\Query\Builder|CategorieOdd onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieOdd query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieOdd whereCategoryNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieOdd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieOdd whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieOdd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieOdd whereIdOdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieOdd whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieOdd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CategorieOdd withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CategorieOdd withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Osc[] $oscs
 * @property-read int|null $oscs_count
 */
class CategorieOdd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_number',
        'intitule', 'id_odd',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];


    public function odd()
    {
        return $this->belongsTo(Odd::class, 'id_odd');
    }

    public function oscs()
    {
        return $this->belongsToMany(Osc::class, "osc_categorie_odds", "categorie_odd_id", "osc_id");
    }
}
