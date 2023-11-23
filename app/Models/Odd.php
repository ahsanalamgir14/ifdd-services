<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use IbrahimBougaoua\FilamentSortOrder\Traits\SortOrder;

/**
 * App\Models\Odd
 *
 * @property int $id
 * @property string $name
 * @property string $number
 * @property int $number_categorie
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CategorieOdd[] $categorieOdd
 * @property-read int|null $categorie_odd_count
 * @method static \Illuminate\Database\Eloquent\Builder|Odd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Odd newQuery()
 * @method static \Illuminate\Database\Query\Builder|Odd onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Odd query()
 * @method static \Illuminate\Database\Eloquent\Builder|Odd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Odd whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Odd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Odd whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Odd whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Odd whereNumberCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Odd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Odd withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Odd withoutTrashed()
 * @mixin \Eloquent
 * @property string $logo_odd
 * @property string $color
 * @method static \Illuminate\Database\Eloquent\Builder|Odd whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Odd whereLogoOdd($value)
 */
class Odd extends Model
{
    use HasFactory, SoftDeletes ,SortOrder;

    protected $fillable = [
        'name',
        'name_en',
        'number',
        'number_categorie', 'logo_odd', 'color'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];


    public function categorieOdd()
    {
        return $this->hasMany(CategorieOdd::class, 'id_odd');
    }
}
