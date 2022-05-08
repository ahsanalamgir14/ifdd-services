<?php

namespace App\Http\Controllers\Api;

use App\Models\CategorieOdd;
use App\Models\Osc;
use App\Models\ZoneIntervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 *
 * @group OSC management
 *
 * APIs for managing OSCs
 */
class OscController extends BaseController
{
    /**
     * Get all OSCs.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/getoscs.json
     */
    public function index()
    {
        $oscs = Osc::all();

        foreach ($oscs as $osc) {
            $osc->user;
            foreach ($osc->categorieOdds as $categorieOdd) {
                $categorieOdd->odd;
            }
            $osc->zoneInterventions;
        }
        return $this->sendResponse($oscs, 'Liste des OSCs');
    }

    /**
     * getActiveOscs.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/getoscs.json
     */
    public function getActiveOscs()
    {
        $oscs = Osc::where('active', 1)->get();

        foreach ($oscs as $osc) {
            $osc->user;
            foreach ($osc->categorieOdds as $categorieOdd) {
                $categorieOdd->odd;
            }
            $osc->zoneInterventions;
        }
        return $this->sendResponse($oscs, 'Liste des OSCs');
    }


    /**
     * Add a new OSC.
     *
     * @authenticated
     * @header Content-Type application/json
     * @bodyParam name string required the name of the osc. Example: Faim
     * @bodyParam abbreviation string required the abbreviation of the osc. Example: F
     * @bodyParam numero_osc string required the number of the osc. Example: 12
     * @bodyParam pays string required the country of the osc. Example: France
     * @bodyParam date_fondation string required the date of the osc. Example: 12/12/12
     * @bodyParam description string  the description of the osc. Example: Faim
     * @bodyParam personne_contact string required the contact person of the osc. Example: Faim
     * @bodyParam telephone string required the telephone of the osc. Example: 12
     * @bodyParam email_osc string required the email of the osc. Example: Faim
     * @bodyParam site_web string  the website of the osc. Example: Faim
     * @bodyParam facebook string  the facebook of the osc. Example: Faim
     * @bodyParam twitter string  the twitter of the osc. Example: Faim
     * @bodyParam instagram string  the instagram of the osc. Example: Faim
     * @bodyParam linkedin string  the linkedin of the osc. Example: Faim
     * @bodyParam longitude string required the longitude of the osc. Example: Faim
     * @bodyParam latitude string required the latitude of the osc. Example: Faim
     * @bodyParam siege string required the siege of the osc. Example: Faim
     * @bodyParam zone_intervention required the zone of the osc. Example: [ {"name":"Zone","longitude":"13","latitude":"7"},{"name":"Zone2","longitude":"13","latitude":"7"},{"name":"Zone3","longitude":"13","latitude":"7"}]
     * @bodyParam osccategoriesOdd required the categories of the osc. Example: [{"id" : 12,"description":"Une Osc"},{"id" : 20,"description":"Une Osc1"}]
     * @responseFile storage/responses/addosc.json
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'abbreviation' => 'required',
            'numero_osc' => 'required',
            'pays' => 'required',
            'date_fondation' => 'required',
            'description' => '',
            'personne_contact' => 'required',
            'telephone' => 'required',
            'email_osc' => 'required',
            'site_web' => '',
            'facebook' => '',
            'twitter' => '',
            'instagram' => '',
            'linkedin' => '',
            'longitude' => 'required',
            'latitude' => 'required',
            'siege' => 'required',
            'zone_intervention' => 'required',
            'osccategoriesOdd' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {
            DB::beginTransaction();

            $osc =  $user->oscs()->create($input);

            foreach ($input['osccategoriesOdd'] as $categorieOdd) {
                $osc->categorieOdds()->attach($categorieOdd['id'], ['description' => $categorieOdd['description']]);
            }

            foreach ($request->zone_intervention as $zone) {
                ZoneIntervention::create([
                    'osc_id' => $osc->id,
                    'name' => $zone['name'],
                    'longitude' => $zone['longitude'],
                    'latitude' => $zone['latitude'],
                ]);
            }

            DB::commit();

            return $this->sendResponse($osc, 'OSC created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendError('Error', $th->getMessage());
        }
    }

    /**
     * Get a single OSC.
     *
     * @urlParam id required The ID of the OSC.
     * @responseFile storage/responses/getosc.json
     */
    public function show($id)
    {
        $osc = Osc::find($id);
        $osc->user;
        foreach ($osc->categorieOdds as $categorieOdd) {
            $categorieOdd->odd;
        }
        $osc->zoneInterventions;
        return $this->sendResponse($osc, 'OSC retrieved successfully.');
    }

    /**
     * Update a OSC.
     *
     * @urlParam id required The ID of the OSC.
     * @authenticated
     * @header Content-Type application/json
     * @bodyParam name string required the name of the osc. Example: Faim
     * @bodyParam abbreviation string required the abbreviation of the osc. Example: F
     * @bodyParam numero_osc string required the number of the osc. Example: 12
     * @bodyParam pays string required the country of the osc. Example: France
     * @bodyParam date_fondation string required the date of the osc. Example: 12/12/12
     * @bodyParam description string  the description of the osc. Example: Faim
     * @bodyParam personne_contact string required the contact person of the osc. Example: Faim
     * @bodyParam telephone string required the telephone of the osc. Example: 12
     * @bodyParam email_osc string required the email of the osc. Example: Faim
     * @bodyParam site_web string  the website of the osc. Example: Faim
     * @bodyParam facebook string  the facebook of the osc. Example: Faim
     * @bodyParam twitter string  the twitter of the osc. Example: Faim
     * @bodyParam instagram string  the instagram of the osc. Example: Faim
     * @bodyParam linkedin string  the linkedin of the osc. Example: Faim
     * @bodyParam longitude string required the longitude of the osc. Example: Faim
     * @bodyParam latitude string required the latitude of the osc. Example: Faim
     * @bodyParam siege string required the siege of the osc. Example: Faim
     * @bodyParam zone_intervention required the zone of the osc. Example: [ {"name":"Zone","longitude":"13","latitude":"7"},{"name":"Zone2","longitude":"13","latitude":"7"},{"name":"Zone3","longitude":"13","latitude":"7"}]
     * @bodyParam osccategoriesOdd required the categories of the osc. Example: [{"id" : 12,"description":"Une Osc"},{"id" : 20,"description":"Une Osc1"}]
     * @responseFile storage/responses/updateosc.json
     */
    public function update(Request $request, Osc $osc)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'abbreviation' => 'required',
            'numero_osc' => 'required',
            'pays' => 'required',
            'date_fondation' => 'required',
            'description' => '',
            'personne_contact' => 'required',
            'telephone' => 'required',
            'email_osc' => 'required',
            'site_web' => '',
            'facebook' => '',
            'twitter' => '',
            'instagram' => '',
            'linkedin' => '',
            'longitude' => 'required',
            'latitude' => 'required',
            'siege' => 'required',
            'zone_intervention' => 'required',
            'osccategoriesOdd' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {
            DB::beginTransaction();

            $osc->update($input);

            $osc->categorieOdds()->detach();

            foreach ($input['osccategoriesOdd'] as $categorieOdd) {
                $osc->categorieOdds()->attach($categorieOdd['id'], ['description' => $categorieOdd['description']]);
            }

            $osc->zoneInterventions()->delete();

            foreach ($request->zone_intervention as $zone) {
                ZoneIntervention::create([
                    'osc_id' => $osc->id,
                    'name' => $zone['name'],
                    'longitude' => $zone['longitude'],
                    'latitude' => $zone['latitude'],
                ]);
            }

            DB::commit();

            return $this->sendResponse($osc, 'OSC updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendError('Error', $th->getMessage());
        }
    }

    /**
     * Delete a OSC.
     *
     * @urlParam id required The ID of the OSC.
     * @authenticated
     * @responseFile storage/responses/deleteosc.json
     */
    public function destroy($id)
    {
        $osc = Osc::find($id);

        try {
            DB::beginTransaction();

            $osc->categorieOdds()->detach();

            $osc->zoneInterventions()->delete();

            $osc->delete();

            DB::commit();

            return $this->sendResponse($osc, 'OSC deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendError('Error', $th->getMessage());
        }
    }


    /**
     * Search OSCs by idsCategorieOdd.
     * @bodyParam idsCategorieOdd required The ids of the categories of the OSC. Example: 12,20
     * @responseFile storage/responses/searchosc.json
     */
    public function searchOsc(Request $request)
    {
        $idsCategorieOdd = explode(',', $request->idsCategorieOdd);

        $data = array();

        for ($i = 0; $i < count($idsCategorieOdd); $i++) {
            $categorieOdd = CategorieOdd::find($idsCategorieOdd[$i]);
            $categorieOdd->oscs;
            foreach ($categorieOdd->oscs as $osc) {
                $osc->user;
                foreach ($osc->categorieOdds as $categorieOdd) {
                    $categorieOdd->odd;
                }
                $osc->zoneInterventions;
                $bool = $this->checkIfOscInDataArray($data, $osc);
                if ($bool == false) {
                    $data[] = $osc;
                }
            }
        }

        return $this->sendResponse($data, 'OSC retrieved successfully.');
    }




    /**
     * Search OSCs.
     *
     * @header Content-Type application/json
     * @urlParam q string required the query search. Example: ONG
     * @responseFile storage/responses/getoscs.json
     */

    public function searchOscByQuery(Request $request)
    {
        $q  = $request->input('q');


        $oscs = Osc::where('name', 'LIKE', '%' . $q . '%')
            ->orWhere('pays', 'LIKE', '%' . $q . '%')
            ->orWhere('abbreviation', 'LIKE', '%' . $q . '%')
            ->orWhere('description', 'LIKE', '%' . $q . '%')
            ->orWhere('siege', 'LIKE', '%' . $q . '%')
            ->get();

        foreach ($oscs as $osc) {
            $osc->user;
            foreach ($osc->categorieOdds as $categorieOdd) {
                $categorieOdd->odd;
            }
            $osc->zoneInterventions;
        }

        return $this->sendResponse($oscs, 'OSC retrieved successfully.');
    }


    /**
     * Count OSCs.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/countosc.json
     */
    public function countOscInDb()
    {
        $oscs = Osc::all();
        $count = count($oscs);
        return $this->sendResponse($count, 'number of OSCs in db');
    }
}
