<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\InnovationCategorieThematique
 *
 * @property int $id
 * @property int $innovation_id
 * @property int $categorie_thematique_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|InnovationCategorieThematique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InnovationCategorieThematique newQuery()
 * @method static \Illuminate\Database\Query\Builder|InnovationCategorieThematique onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InnovationCategorieThematique query()
 * @method static \Illuminate\Database\Eloquent\Builder|InnovationCategorieThematique whereCategorieThematiqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InnovationCategorieThematique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InnovationCategorieThematique whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InnovationCategorieThematique whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InnovationCategorieThematique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InnovationCategorieThematique whereInnovationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InnovationCategorieThematique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|InnovationCategorieThematique withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InnovationCategorieThematique withoutTrashed()
 * @mixin \Eloquent
 */
class InnovationCategorieThematique extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'innovation_id',
        'categorie_thematique_id', 'description',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
