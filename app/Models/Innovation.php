<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

/**
 * App\Models\Innovation
 *
 * @property int $id
 * @property string $name
 * @property string $abbreviation
 * @property string $numero_innovation
 * @property string $pays
 * @property string $date_fondation
 * @property string|null $description
 * @property string $personne_contact
 * @property string $telephone
 * @property string $email_innovation
 * @property string|null $site_web
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $instagram
 * @property string|null $linkedin
 * @property string $longitude
 * @property string $latitude
 * @property string $siege
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation newQuery()
 * @method static \Illuminate\Database\Query\Builder|Innovation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereDateFondation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereEmailInnovation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereNumeroInnovation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation wherePays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation wherePersonneContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereSiege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereSiteWeb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Innovation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Innovation withoutTrashed()
 * @mixin \Eloquent
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CategorieThematique[] $categorieThematiques
 * @property-read int|null $categorie_thematiques_count
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereUserId($value)
 * @property bool $active
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Innovation whereActive($value)
 */
class Innovation extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'user_id',
        'name',
        'abbreviation',
        'pays',
        'date_fondation',
        'description',
        'personne_contact',
        'telephone',
        'email_innovation',
        'site_web',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'longitude',
        'latitude',
        'siege', 'active', 'reference',
        'document_link'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function categorieThematiques()
    {
        return $this->belongsToMany(CategorieThematique::class, "innovation_categorie_thematiques", "innovation_id", "categorie_thematique_id")->withPivot('description');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function zoneInterventions()
    {
        return $this->hasMany(ZoneIntervention::class, 'innovation_id');
    }

    public function innovationCategorieThematiques()
    {
        return $this->hasMany(InnovationCategorieThematique::class, 'innovation_id');
    }
}
