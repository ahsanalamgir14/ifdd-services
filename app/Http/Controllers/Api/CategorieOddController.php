<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCategorieOddRequest;
use App\Models\CategorieOdd;
use Illuminate\Support\Facades\DB;

/**
 *
 * @group ODD management
 *
 * APIs for managing ODDs
 */
class CategorieOddController extends BaseController
{

    /**
     * Get all CategorieOdds.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/getcategorieodds.json
     */
    public function index()
    {
        $categorieOdds = CategorieOdd::all();
        $categorieOdds->each(fn($categorieOdd) => $categorieOdd->odd);
        return $this->sendResponse($categorieOdds, 'Liste des CategorieOdds');
    }


    /**
     * Add a new CategorieOdd.
     *
     * @authenticated
     * @header Content-Type application/json
     * @bodyParam category_number string required the number of the categorieOdd. Example:12.1
     * @bodyParam intitule string required the title of the categorieOdd. Example: Faim
     * @bodyParam id_odd int required the id of the odd. Example: 1
     * @responseFile storage/responses/addcategorieodd.json
     */
    public function store(StoreCategorieOddRequest $request)
    {
        try {
            $categorieOdd = CategorieOdd::create($request->all());
            return $this->sendResponse($categorieOdd, 'CategorieOdd créé avec succès', 201);
        } catch (\Exception $e) {
            return $this->sendError('Erreur lors de la création de la catégorie.', $e->getMessage(), 400);
        }
    }


    /**
     * Show the specified CategorieOdd.
     * @urlParam CategorieOdd required The ID of the CategorieOdd. Example: 1
     * @responseFile storage/responses/showcategorieodd.json
     */
    public function show(CategorieOdd $categorieOdd)
    {
        return $this->sendResponse($categorieOdd, 'CategorieOdd retrouvé avec succès');
    }

    /**
     * Update the specified CategorieOdd.
     *
     * @authenticated
     * @header Content-Type application/json
     * @urlParam id required The ID of the CategorieOdd. Example: 1
     * @bodyParam category_number string required the number of the categorieOdd. Example:12.2
     * @bodyParam intitule string required the title of the categorieOdd. Example: Faim
     * @bodyParam id_odd int required the id of the odd. Example: 1
     * @responseFile storage/responses/updatecategorieodd.json
     */
    public function update(StoreCategorieOddRequest $request, $id)
    {

        try {
            DB::beginTransaction();

            $categorieOdd = CategorieOdd::find($id);
            $categorieOdd->update($request->all());

            DB::commit();
            return $this->sendResponse($categorieOdd, 'CategorieOdd modifié avec succès', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Erreur lors de la modification de la catégorie.', $e->getMessage(), 400);
        }
    }


    /**
     * Delete the specified CategorieOdd.
     *
     * @authenticated
     * @urlParam id required The ID of the CategorieOdd. Example: 1
     * @responseFile storage/responses/deletecategorieodd.json
     */
    public function destroy(CategorieOdd $categorieOdd)
    {

        try {
            $categorieOdd->delete();
            return $this->sendResponse($categorieOdd, 'CategorieOdd supprimé avec succès', 201);
        } catch (\Exception $e) {
            return $this->sendError('Erreur lors de la suppression de la catégorie.', $e->getMessage(), 400);
        }
    }
}
