<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use IbrahimBougaoua\FilamentSortOrder\Traits\SortOrder;

/**
 * App\Models\Thematique
 *
 * @property int $id
 * @property string $name
 * @property string $number
 * @property int $number_categorie
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CategorieThematique[] $categorieThematique
 * @property-read int|null $categorie_thematique_count
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique newQuery()
 * @method static \Illuminate\Database\Query\Builder|Thematique onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique query()
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique whereNumberCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Thematique withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Thematique withoutTrashed()
 * @mixin \Eloquent
 * @property string $logo_thematique
 * @property string $color
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thematique whereLogoThematique($value)
 */
class Thematique extends Model
{
    use HasFactory, SoftDeletes ,SortOrder;

    protected $fillable = [
        'name',
        'nom_en',
        'number',
        'number_categorie', 'logo_thematique', 'color'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];


    public function categorieThematique()
    {
        return $this->hasMany(CategorieThematique::class, 'id_thematique');
    }
}
