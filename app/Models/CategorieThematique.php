<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CategorieThematique
 *
 * @property int $id
 * @property string $category_number
 * @property string $intitule
 * @property int $id_thematique
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Thematique|null $thematique
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieThematique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieThematique newQuery()
 * @method static \Illuminate\Database\Query\Builder|CategorieThematique onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieThematique query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieThematique whereCategoryNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieThematique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieThematique whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieThematique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieThematique whereIdThematique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieThematique whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieThematique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CategorieThematique withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CategorieThematique withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Innovation[] $innovations
 * @property-read int|null $innovations_count
 */
class CategorieThematique extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_number',
        'intitule', 'nom_en', 'id_thematique',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];


    public function thematique()
    {
        return $this->belongsTo(Thematique::class, 'id_thematique');
    }

    public function innovations()
    {
        return $this->belongsToMany(Innovation::class, "innovation_categorie_thematiques", "categorie_thematique_id", "innovation_id");
    }
}
