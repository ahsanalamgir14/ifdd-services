<?php

namespace App\Http\Controllers\Api;

use App\Models\Odd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 *
 * @group ODD management
 *
 * APIs for managing ODDs
 */

class OddController extends BaseController
{
    /**
     * Get all ODDs.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/getodds.json
     */
    public function index()
    {
        $odds = Odd::all();

        foreach ($odds as $odd) {
            $odd->categorieOdd;
        }
        return $this->sendResponse($odds, 'Liste des ODDs');
    }

    /**
     * Add a new Odd.
     *
     * @authenticated
     * @header Content-Type application/json
     * @bodyParam name string required the name of the odd. Example: Faim
     * @bodyParam number int required the number of the odd. Example: 12
     * @bodyParam number_categorie int required number of categories contained in this odd. Example: 2
     * @bodyParam logo_odd string required the url of the logo of the odd. Example: http://www.logo.com
     * @bodyParam color string required the color of the odd. Example: #000000
     * @responseFile storage/responses/addodd.json
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required',
            'number_categorie' => 'required',
            'logo_odd' => 'required',
            'color' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Erreur de paramètres.', $validator->errors(), 400);
        }

        try {
            DB::beginTransaction();

            $odd = Odd::create($request->all());

            DB::commit();

            return $this->sendResponse($odd, "Création de l'odd reussie", 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Erreur.', ['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Show Odd.
     *
     * @header Content-Type application/json
     * @urlParam id int required the id of the odd. Example: 2
     * @responseFile storage/responses/showodd.json
     */
    public function show(Odd $odd)
    {
        $odd->categorieOdd;
        return $this->sendResponse($odd, 'Odd trouvé');
    }

    /**
     * Update Odd.
     *
     * @authenticated
     * @header Content-Type application/json
     * @urlParam id int required the id of the odd. Example: 2
     * @bodyParam name string required the name of the odd. Example: Faim
     * @bodyParam number int required the number of the odd. Example: 12
     * @bodyParam number_categorie int required number of categories contained in this odd. Example: 2
     * @bodyParam logo_odd string required the url of the logo of the odd. Example: http://www.logo.com
     * @bodyParam color string required the color of the odd. Example: #000000
     * @responseFile storage/responses/updateodd.json
     */
    public function update(Request $request, Odd $odd)
    {

        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required',
            'number_categorie' => 'required',
            'logo_odd' => 'required',
            'color' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Erreur de paramètres.', $validator->errors(), 400);
        }

        try {
            DB::beginTransaction();

            $odd->update($request->all());

            DB::commit();

            return $this->sendResponse($odd, "Modification de l'odd reussie", 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Erreur.', ['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Delete Odd.
     *
     * @authenticated
     * @header Content-Type application/json
     * @urlParam id int required the id of the odd. Example: 2
     * @responseFile storage/responses/deleteodd.json
     */
    public function destroy(Odd $odd)
    {
        try {
            DB::beginTransaction();

            $odd->delete();

            DB::commit();

            return $this->sendResponse($odd, "Suppression de l'odd reussie", 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Erreur.', ['error' => $th->getMessage()], 400);
        }
    }
}
