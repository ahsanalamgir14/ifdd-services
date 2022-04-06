<?php

namespace App\Http\Controllers\Api;

use App\Models\ZoneIntervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 *
 * @group ZoneIntervention management
 *
 * APIs for managing ZoneInterventions
 */
class ZoneInterventionController extends BaseController
{

    /**
     * Get all ZoneInterventions.
     *
     * @header Content-Type application/json
     * @responseFile storage/responses/getzoneinterventions.json
     */
    public function index()
    {
        $zoneInterventions = ZoneIntervention::all();


        return $this->sendResponse($zoneInterventions, 'Liste des ZoneInterventions');
    }


    /**
     * Add a new ZoneIntervention.
     * @authenticated
     *
     * @bodyParam osc_id int required The osc id.
     * @bodyParam name string required The name of zoneIntervention. Example: Faim
     * @bodyParam longitude string required The longitude of zoneIntervention. Example: 13
     * @bodyParam latitude string required The latitude of zoneIntervention. Example: 2
     * @responseFile storage/responses/addzoneintervention.json
     *
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'osc_id' => 'required',
            'name' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {

            DB::beginTransaction();

            $zoneIntervention = ZoneIntervention::create($input);

            DB::commit();

            return $this->sendResponse($zoneIntervention, 'ZoneIntervention created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError('Error', $e->getMessage());
        }
    }



    /**
     * Get a single ZoneIntervention.
     *
     * @urlParam id required The ID of the ZoneIntervention.
     * @responseFile storage/responses/getzoneintervention.json
     */

    public function show($id)
    {
        $zoneIntervention = ZoneIntervention::find($id);
        $zoneIntervention->oscs;

        return $this->sendResponse($zoneIntervention, 'ZoneIntervention retrieved successfully.');
    }

    /**
     * Update a ZoneIntervention.
     * @authenticated
     *
     * @bodyParam osc_id int required The osc id.
     * @bodyParam name string required The name of zoneIntervention. Example: Faim
     * @bodyParam longitude string required The longitude of zoneIntervention. Example: 13
     * @bodyParam latitude string required The latitude of zoneIntervention. Example: 2
     * @responseFile storage/responses/updatezoneintervention.json
     *
     */
    public function update(Request $request, ZoneIntervention $zoneIntervention)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'osc_id' => 'required',
            'name' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {

            DB::beginTransaction();

            $zoneIntervention->update($input);

            DB::commit();

            return $this->sendResponse($zoneIntervention, 'ZoneIntervention updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError('Error', $e->getMessage());
        }
    }


    /**
     * Delete a ZoneIntervention.
     * @authenticated
     *
     * @urlParam id required The ID of the ZoneIntervention.
     * @responseFile storage/responses/deletezoneintervention.json
     */
    public function destroy(ZoneIntervention $zoneIntervention)
    {
        try {

            DB::beginTransaction();

            $zoneIntervention->delete();

            DB::commit();

            return $this->sendResponse($zoneIntervention, 'ZoneIntervention deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError('Error', $e->getMessage());
        }
    }
}
