<?php

namespace App\Http\Controllers\Api;

use App\Models\CategorieThematique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 *
 * @group THEMATIQUE management
 *
 * APIs for managing THEMATIQUEs
 */
class CategorieThematiqueController extends BaseController
{

    /**
     * Get all CategorieThematiques.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/getcategoriethematiques.json
     */
    public function index()
    {
        $categorieThematiques = CategorieThematique::all();
        $categorieThematiques->each(function ($categorieThematique) {
            $categorieThematique->thematique;
        });
        return $this->sendResponse($categorieThematiques, 'Liste des CategorieThematiques');
    }


    /**
     * Add a new CategorieThematique.
     *
     * @authenticated
     * @header Content-Type application/json
     * @bodyParam category_number string required the number of the categorieThematique. Example:12.1
     * @bodyParam intitule string required the title of the categorieThematique. Example: Faim
     * @bodyParam nom_en string required the english name of the category thematique. Example: Eat
     * @bodyParam id_thematique int required the id of the thematique. Example: 1
     * @responseFile storage/responses/addcategoriethematique.json
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'category_number' => 'required',
            'intitule' => 'required',
            'nom_en' => 'required',
            'id_thematique' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Erreur de paramètres.', $validator->errors(), 400);
        }

        try {
            DB::beginTransaction();


            $categorieThematique = CategorieThematique::create($request->all());
            DB::commit();
            return $this->sendResponse($categorieThematique, 'CategorieThematique créé avec succès', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Erreur lors de la création de la catégorie.', $e->getMessage(), 400);
        }
    }


    /**
     * Show the specified CategorieThematique.
     * @urlParam id required The ID of the CategorieThematique. Example: 1
     * @responseFile storage/responses/showcategoriethematique.json
     */
    public function show($id)
    {
        $categorieThematique = CategorieThematique::find($id);
        $categorieThematique->thematique;
        return $this->sendResponse($categorieThematique, 'CategorieThematique retrouvé avec succès');
    }

    /**
     * Update the specified CategorieThematique.
     *
     * @authenticated
     * @header Content-Type application/json
     * @urlParam id required The ID of the CategorieThematique. Example: 1
     * @bodyParam category_number string required the number of the categorieThematique. Example:12.2
     * @bodyParam intitule string required the title of the categorieThematique. Example: Faim
     * @bodyParam nom_en string required the english name of the category thematique. Example: Eat
     * @bodyParam id_thematique int required the id of the thematique. Example: 1
     * @responseFile storage/responses/updatecategoriethematique.json
     */
    public function update(Request $request, $id)
    {

        $validator =  Validator::make($request->all(), [
            'category_number' => 'required',
            'intitule' => 'required',
            'nom_en' => 'required',
            'id_thematique' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Erreur de paramètres.', $validator->errors(), 400);
        }

        try {
            DB::beginTransaction();

            $categorieThematique = CategorieThematique::find($id);
            $categorieThematique->update($request->all());

            DB::commit();
            return $this->sendResponse($categorieThematique, 'CategorieThematique modifié avec succès', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Erreur lors de la modification de la catégorie.', $e->getMessage(), 400);
        }
    }


    /**
     * Delete the specified CategorieThematique.
     *
     * @authenticated
     * @urlParam id required The ID of the CategorieThematique. Example: 1
     * @responseFile storage/responses/deletecategoriethematique.json
     */
    public function destroy($id)
    {

        try {
            DB::beginTransaction();

            $categorieThematique = CategorieThematique::find($id);
            $categorieThematique->delete();

            DB::commit();
            return $this->sendResponse($categorieThematique, 'CategorieThematique supprimé avec succès', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Erreur lors de la suppression de la catégorie.', $e->getMessage(), 400);
        }
    }
}
