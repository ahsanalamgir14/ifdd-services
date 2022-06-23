<?php

namespace App\Http\Controllers\Api;

use App\Models\Odd;
use App\Models\Osc;
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
            $count = $this->countOscByOdd($odd->id);
            $odd->count_osc = $count;
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
    public function show($id)
    {
        $odd = Odd::find($id);
        $odd->categorieOdd;
        $count = $this->countOscByOdd($id);
        $odd->count_osc = $count;
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
    public function update(Request $request, $id)
    {
        $odd = Odd::find($id);


        try {
            DB::beginTransaction();

            $odd->name = $request->name ?? $odd->name;
            $odd->number = $request->number ?? $odd->number;
            $odd->number_categorie = $request->number_categorie ?? $odd->number_categorie;
            $odd->logo_odd = $request->logo_odd ?? $odd->logo_odd;
            $odd->color = $request->color ?? $odd->color;
            $odd->save();


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

    // get a odd by id and return the number of oscs associated to this odd by categorieOdd
    public function countOscByOdd($idOdd)
    {
        $count = DB::table('oscs')
            ->join('categorie_odds', 'osc_categorie_odds.categorie_odd_id', '=', 'categorie_odds.id')
            ->join('odds', 'categorie_odds.id_odd', '=', 'odds.id')
            ->where('odds.id', '=', $idOdd)
            ->count();
        return $count;
    }

    /*  public function countOscByOdd($idOdd)
    {
        $oscs = Osc::all();
        $count = 0;
        $data = array();
        foreach ($oscs as $osc) {
            foreach ($osc->categorieOdds as $categorieOdd) {
                if ($categorieOdd->odd->id == $idOdd) {

                    $bool = $this->checkIfOscInDataArray($data, $osc);
                    if ($bool == false) {
                        $data[] = $osc;
                        $count++;
                    }
                }
            }
        }
        return $count;
    }*/
}
