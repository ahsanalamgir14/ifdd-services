<?php

namespace App\Http\Controllers\Api;

use App\Models\CategorieThematique;
use App\Models\Innovation;
use App\Models\ZoneIntervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 *
 * @group INNOVATION management
 *
 * APIs for managing INNOVATIONs
 */
class InnovationController extends BaseController
{
    /**
     * Get all INNOVATIONs.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/getinnovations.json
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page') ?? 50;
        //  $innovations = Innovation::paginate($per_page);
        $innovations = Innovation::where('active', 1)->paginate($per_page);
        $innovations->setPath(env('APP_URL') . '/api/innovation');

        foreach ($innovations as $innovation) {
            $innovation->user;
            foreach ($innovation->categorieThematiques as $categorieThematique) {
                $categorieThematique->thematique;
            }
            $innovation->zoneInterventions;
        }
        return $this->sendResponse($innovations, 'Liste des INNOVATIONs');
    }

    /**
     * getActiveInnovations.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/getinnovations.json
     */
    public function getActiveInnovations(Request $request)
    {
        $per_page = $request->input('per_page') ?? 50;
        $innovations = Innovation::where('active', 1)->paginate($per_page);
        $innovations->setPath(env('APP_URL') . '/api/innovation');

        foreach ($innovations as $innovation) {
            $innovation->user;
            foreach ($innovation->categorieThematiques as $categorieThematique) {
                $categorieThematique->thematique;
            }
            $innovation->zoneInterventions;
        }
        return $this->sendResponse($innovations, 'Liste des INNOVATIONs');
    }


    /**
     * Add a new INNOVATION.
     *
     * @authenticated
     * @header Content-Type application/json
     * @bodyParam name string required the name of the innovation. Example: Faim
     * @bodyParam abbreviation string required the abbreviation of the innovation. Example: F
     * @bodyParam pays string required the country of the innovation. Example: France
     * @bodyParam date_fondation string the date of the innovation. Example: 12/12/12
     * @bodyParam description string  the description of the innovation. Example: Faim
     * @bodyParam personne_contact string the contact person of the innovation. Example: Faim
     * @bodyParam telephone string  the telephone of the innovation. Example: 12
     * @bodyParam email_innovation string the email of the innovation. Example: Faim
     * @bodyParam site_web string  the website of the innovation. Example: Faim
     * @bodyParam facebook string  the facebook of the innovation. Example: Faim
     * @bodyParam twitter string  the twitter of the innovation. Example: Faim
     * @bodyParam instagram string  the instagram of the innovation. Example: Faim
     * @bodyParam linkedin string  the linkedin of the innovation. Example: Faim
     * @bodyParam longitude string required the longitude of the innovation. Example: Faim
     * @bodyParam latitude string required the latitude of the innovation. Example: Faim
     * @bodyParam reference string the reference of the innovation. Example: OMS
     * @bodyParam siege string required the siege of the innovation. Example: Faim
     * @bodyParam zone_intervention required the zone of the innovation. Example: [ {"name":"Zone","longitude":"13","latitude":"7"},{"name":"Zone2","longitude":"13","latitude":"7"},{"name":"Zone3","longitude":"13","latitude":"7"}]
     * @bodyParam innovationcategoriesThematique required the categories of the innovation. Example: [{"id" : 12,"description":"Une Innovation"},{"id" : 20,"description":"Une Innovation1"}]
     * @responseFile storage/responses/addinnovation.json
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        // $input['active'] = true;
        $validator = Validator::make($input, [
            'name' => 'required',
            'abbreviation' => 'required',
            'pays' => 'required',
            'date_fondation' => '',
            'description' => '',
            'personne_contact' => '',
            'telephone' => '',
            'email_innovation' => '',
            'site_web' => '',
            'facebook' => '',
            'twitter' => '',
            'instagram' => '',
            'linkedin' => '',
            'longitude' => 'required',
            'latitude' => 'required',
            'reference' => '',
            'siege' => 'required',
            'zone_intervention' => 'required',
            'innovationcategoriesThematique' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {
            DB::beginTransaction();

            $innovation =  $user->innovations()->create($input);

            foreach ($input['innovationcategoriesThematique'] as $categorieThematique) {
                $innovation->categorieThematiques()->attach($categorieThematique['id'], ['description' => $categorieThematique['description']]);
            }

            foreach ($request->zone_intervention as $zone) {
                ZoneIntervention::create([
                    'innovation_id' => $innovation->id,
                    'name' => $zone['name'],
                    'longitude' => $zone['longitude'],
                    'latitude' => $zone['latitude'],
                ]);
            }

            DB::commit();

            return $this->sendResponse($innovation, 'INNOVATION created successfully.', 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendError('Error', $th->getMessage(), 400);
        }
    }

    /**
     * Get a single INNOVATION.
     *
     * @urlParam id required The ID of the INNOVATION.
     * @responseFile storage/responses/getinnovation.json
     */
    public function show($id)
    {
        $innovation = Innovation::find($id);
        $innovation->user;
        foreach ($innovation->categorieThematiques as $categorieThematique) {
            $categorieThematique->thematique;
        }
        $innovation->zoneInterventions;
        return $this->sendResponse($innovation, 'INNOVATION retrieved successfully.');
    }

    /**
     * Update a INNOVATION.
     *
     * @urlParam id required The ID of the INNOVATION.
     * @authenticated
     * @header Content-Type application/json
     * @bodyParam name string required the name of the innovation. Example: Faim
     * @bodyParam abbreviation string required the abbreviation of the innovation. Example: F
     * @bodyParam pays string required the country of the innovation. Example: France
     * @bodyParam date_fondation string required the date of the innovation. Example: 12/12/12
     * @bodyParam description string  the description of the innovation. Example: Faim
     * @bodyParam personne_contact string required the contact person of the innovation. Example: Faim
     * @bodyParam telephone string required the telephone of the innovation. Example: 12
     * @bodyParam email_innovation string required the email of the innovation. Example: Faim
     * @bodyParam site_web string  the website of the innovation. Example: Faim
     * @bodyParam facebook string  the facebook of the innovation. Example: Faim
     * @bodyParam twitter string  the twitter of the innovation. Example: Faim
     * @bodyParam instagram string  the instagram of the innovation. Example: Faim
     * @bodyParam linkedin string  the linkedin of the innovation. Example: Faim
     * @bodyParam longitude string required the longitude of the innovation. Example: Faim
     * @bodyParam latitude string required the latitude of the innovation. Example: Faim
     * @bodyParam reference string the reference of the innovation. Example: OMS
     * @bodyParam siege string required the siege of the innovation. Example: Faim
     * @bodyParam zone_intervention required the zone of the innovation. Example: [ {"name":"Zone","longitude":"13","latitude":"7"},{"name":"Zone2","longitude":"13","latitude":"7"},{"name":"Zone3","longitude":"13","latitude":"7"}]
     * @bodyParam innovationcategoriesThematique required the categories of the innovation. Example: [{"id" : 12,"description":"Une Innovation"},{"id" : 20,"description":"Une Innovation1"}]
     * @responseFile storage/responses/updateinnovation.json
     */
    public function update(Request $request, $id)
    {
        $innovation = Innovation::find($id);


        $input = $request->all();


        try {
            DB::beginTransaction();


            $innovation->name = $request->name ?? $innovation->name;
            $innovation->abbreviation = $request->abbreviation ?? $innovation->abbreviation;
            $innovation->pays = $request->pays ?? $innovation->pays;
            $innovation->date_fondation = $request->date_fondation ?? $innovation->date_fondation;
            $innovation->description = $request->description ?? $innovation->description;
            $innovation->personne_contact = $request->personne_contact ?? $innovation->personne_contact;
            $innovation->telephone = $request->telephone ?? $innovation->telephone;
            $innovation->email_innovation = $request->email_innovation ?? $innovation->email_innovation;
            $innovation->site_web = $request->site_web ?? $innovation->site_web;
            $innovation->facebook = $request->facebook ?? $innovation->facebook;
            $innovation->twitter = $request->twitter ?? $innovation->twitter;
            $innovation->instagram = $request->instagram ?? $innovation->instagram;
            $innovation->linkedin = $request->linkedin ?? $innovation->linkedin;
            $innovation->longitude = $request->longitude ?? $innovation->longitude;
            $innovation->latitude = $request->latitude ?? $innovation->latitude;
            $innovation->reference = $request->reference ?? $innovation->reference;
            $innovation->siege = $request->siege ?? $innovation->siege;
            $innovation->document_link = $request->document_link ?? $innovation->document_link;

            if ($request->active) {
                $innovation->active = $request->active;
            }

            $innovation->save();

            if ($request->innovationcategoriesThematique) {
                $innovation->categorieThematiques()->detach();

                foreach ($input['innovationcategoriesThematique'] as $categorieThematique) {
                    $innovation->categorieThematiques()->attach($categorieThematique['id'], ['description' => $categorieThematique['description']]);
                }
            }

            if ($request->zone_intervention) {

                foreach ($request->zone_intervention as $zone) {
                    $zoneIntervention = ZoneIntervention::where('innovation_id', $innovation->id)->where('id', $zone['id'])->first();
                    if ($zoneIntervention) {
                        $zoneIntervention->name = $zone['name'];
                        $zoneIntervention->longitude = $zone['longitude'];
                        $zoneIntervention->latitude = $zone['latitude'];
                        $zoneIntervention->save();
                    } else {
                        ZoneIntervention::create([
                            'innovation_id' => $innovation->id,
                            'name' => $zone['name'],
                            'longitude' => $zone['longitude'],
                            'latitude' => $zone['latitude'],
                        ]);
                    }
                }
            }




            DB::commit();

            return $this->sendResponse($innovation, 'INNOVATION updated successfully.', 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendError('Error', $th->getMessage(), 400);
        }
    }

    /**
     * Delete a INNOVATION.
     *
     * @urlParam id required The ID of the INNOVATION.
     * @authenticated
     * @responseFile storage/responses/deleteinnovation.json
     */
    public function destroy($id)
    {
        $innovation = Innovation::find($id);

        try {
            DB::beginTransaction();

            $innovation->categorieThematiques()->detach();

            $innovation->zoneInterventions()->delete();

            $innovation->delete();

            DB::commit();

            return $this->sendResponse($innovation, 'INNOVATION deleted successfully.', 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendError('Error', $th->getMessage(), 400);
        }
    }


    /**
     * Search INNOVATIONs by idsCategorieThematique.
     * @bodyParam idsCategorieThematique required The ids of the categories of the INNOVATION. Example: 12,20
     * @responseFile storage/responses/searchinnovation.json
     */
    public function searchInnovation(Request $request)
{
    $idsCategorieThematique = explode(',', $request->idsCategorieThematique);

    $data = array();

    foreach ($idsCategorieThematique as $iValue) {
        $categorieThematique = CategorieThematique::find($iValue);
        $categorieThematique->innovations;

        foreach ($categorieThematique->innovations as $innovation) {
            // Ajoutez une condition pour vérifier si l'INNOVATION est active
            if ($innovation->active == 1) {
                $innovation->user;

                foreach ($innovation->categorieThematiques as $categorieThematique) {
                    $categorieThematique->thematique;
                }

                $innovation->zoneInterventions;

                $bool = $this->checkIfInnovationInDataArray($data, $innovation);

                if (!$bool) {
                    $data[] = $innovation;
                }
            }
        }
    }

    return $this->sendResponse($data, 'Active INNOVATION retrieved successfully.');
}





    /**
     * Search INNOVATIONs.
     *
     * @header Content-Type application/json
     * @urlParam q string required the query search. Example: ONG
     * @responseFile storage/responses/getinnovations.json
     */
 public function searchInnovationByQuery(Request $request)
    {
        $q  = $request->input('q');
        $innovations = INNOVATION::search($q)->get();

        foreach ($innovations as $innovation) {
            $innovation->user;
            foreach ($innovation->categorieThematiques as $categorieThematique) {
                $categorieThematique->thematique;
            }
            $innovation->zoneInterventions;
        }

        return $this->sendResponse($innovations, 'INNOVATION retrieved successfully.');
    }


    /**
     * Count INNOVATIONs.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/countinnovation.json
     */
    public function countInnovationInDb()
    {
        $innovations = Innovation::where('active', 1)->get();
        $count = count($innovations);
        return $this->sendResponse($count, 'number of INNOVATIONs in db');
    }
}
