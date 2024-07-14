<?php

namespace App\Http\Controllers\Api;

use App\Models\Thematique;
use App\Models\Innovation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 *
 * @group THEMATIQUE management
 *
 * APIs for managing THEMATIQUEs
 */

class ThematiqueController extends BaseController
{
    /**
     * Get all THEMATIQUEs.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/getthematiques.json
     */
    public function index()
    {
        $thematiques = Thematique::orderBy('id','asc')->get();

        foreach ($thematiques as $thematique) {
          $thematique->categorieThematique = $thematique->categorieThematique()->orderBy('id', 'asc')->get();
            $count = $this->countInnovationByThematique($thematique->id);
            $thematique->count_innovation = $count;
        }
        return $this->sendResponse($thematiques, 'Liste des Thématiques');
    }

    /**
     * Add a new Thematique.
     *
     * @authenticated
     * @header Content-Type application/json
     * @bodyParam name string required the name of the thematique. Example: Faim
     * @bodyParam nom_en string required the english name of the thematique. Example: Eat
     * @bodyParam number int required the number of the thematique. Example: 12
     * @bodyParam number_categorie int required number of categories contained in this thematique. Example: 2
     * @bodyParam logo_thematique string required the url of the logo of the thematique. Example: http://www.logo.com
     * @bodyParam color string required the color of the thematique. Example: #000000
     * @responseFile storage/responses/addthematique.json
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'nom_en' => 'required',
            'number' => 'required',
            'number_categorie' => 'required',
            'logo_thematique' => 'required',
            'color' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Erreur de paramètres.', $validator->errors(), 400);
        }

        try {
            DB::beginTransaction();

            $thematique = Thematique::create($request->all());

            DB::commit();

            return $this->sendResponse($thematique, "Création de la thématique reussie", 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Erreur.', ['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Show Thematique.
     *
     * @header Content-Type application/json
     * @urlParam id int required the id of the thematique. Example: 2
     * @responseFile storage/responses/showthematique.json
     */
    public function show($id)
    {
        $thematique = Thematique::find($id);
        $thematique->categorie_thematique = $thematique->categorieThematique()->orderBy('id', 'asc')->get();
        $count = $this->countInnovationByThematique($id);
        $thematique->count_innovation = $count;
        return $this->sendResponse($thematique, 'Thématique trouvé');
    }

    /**
     * Update Thematique.
     *
     * @authenticated
     * @header Content-Type application/json
     * @urlParam id int required the id of the thematique. Example: 2
     * @bodyParam name string  the name of the thematique. Example: Faim
     * @bodyParam nom_en string the english name of the thematique. Example: Eat
     * @bodyParam number int required the number of the thematique. Example: 12
     * @bodyParam number_categorie int required number of categories contained in this thematique. Example: 2
     * @bodyParam logo_thematique string required the url of the logo of the thematique. Example: http://www.logo.com
     * @bodyParam color string required the color of the thematique. Example: #000000
     * @responseFile storage/responses/updatethematique.json
     */
    public function update(Request $request, $id)
    {
        $thematique = Thematique::find($id);


        try {
            DB::beginTransaction();

            $thematique->name = $request->name ?? $thematique->name;
            $thematique->nom_en = $request->nom_en ?? $thematique->nom_en;
            $thematique->number = $request->number ?? $thematique->number;
            $thematique->number_categorie = $request->number_categorie ?? $thematique->number_categorie;
            $thematique->logo_thematique = $request->logo_thematique ?? $thematique->logo_thematique;
            $thematique->color = $request->color ?? $thematique->color;
            $thematique->save();


            DB::commit();

            return $this->sendResponse($thematique, "Modification de la thématique reussie", 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Erreur.', ['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Delete Thematique.
     *
     * @authenticated
     * @header Content-Type application/json
     * @urlParam id int required the id of the thematique. Example: 2
     * @responseFile storage/responses/deletethematique.json
     */
    public function destroy($id)
    {
        $thematique = Thematique::find($id);
        try {
            DB::beginTransaction();

            $thematique->delete();

            DB::commit();

            return $this->sendResponse($thematique, "Suppression de la thématique reussie", 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Erreur.', ['error' => $th->getMessage()], 400);
        }
    }

    // generate sql query to count all innovations by thematique id and return the number of innovations associated to this thematique by categorieThematique
    public function countInnovationByThematique($idThematique)
    {
        $sql = "SELECT COUNT(DISTINCT innovation_categorie_thematiques.innovation_id) as count
FROM innovation_categorie_thematiques
INNER JOIN categorie_thematiques ON innovation_categorie_thematiques.categorie_thematique_id = categorie_thematiques.id
INNER JOIN thematiques ON categorie_thematiques.id_thematique = thematiques.id
INNER JOIN innovations ON innovation_categorie_thematiques.innovation_id = innovations.id
WHERE thematiques.id = $idThematique
  AND innovations.active = true";
        $count = DB::select($sql);
        return $count[0]->count;
    }
}
