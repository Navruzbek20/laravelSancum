<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocusResource;
use App\Models\Locus;
use Illuminate\Http\Request;

class LocusController extends Controller
{
    /**
     * @group Locus
     *
     * Barcha Locus yozuvlarini olish
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "name": "D3S1358",
     *     "status": true
     *   }
     * ]
     */
    public function getLocus()
    {
        return LocusResource::collection(Locus::paginate(env('PG')));
    }
    public function getAllLocus()
    {
        return LocusResource::collection(Locus::all());
    }

    /**
     * @group Locus
     *
     * ID bo‘yicha Locusni olish
     *
     * @urlParam id integer required Locus ID. Misol: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "D3S1358",
     *   "status": true
     * }
     */
    public function getLocusById($id)
    {
        return new LocusResource(Locus::find($id));
    }

    /**
     * @group Locus
     *
     * Yangi Locus yaratish
     *
     * @bodyParam name string required Locus nomi. Misol: D3S1358
     * @bodyParam status boolean optional Holati (true/false). Misol: true
     *
     * @response 201 {
     *   "id": 2,
     *   "name": "D3S1358",
     *   "status": true
     * }
     */
    public function createLocus(Request $request)
    {
        $locus = new Locus();
        $locus->name = $request->name;
        $locus->active = $request->active ?? false;
        $locus->save();
        return $locus;
    }

    /**
     * @group Locus
     *
     * Locusni yangilash
     *
     * @urlParam id integer required Locus ID. Misol: 1
     * @bodyParam name string required Yangi nomi. Misol: D3S1358
     * @bodyParam status boolean required Yangi status. Misol: true
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "D3S1358",
     *   "status": true
     * }
     */
    public function updateLocus(Request $request, $id)
    {
        $locus = Locus::find($id);
        $locus->name = $request->name;
        $locus->active = $request->active;
        $locus->save();
        return $locus;
    }

    /**
     * @group Locus
     *
     * Locusni o‘chirish
     *
     * @urlParam id integer required O‘chiriladigan ID. Misol: 1
     *
     * @response 200 {
     *   "message": "Locus muvaffaqiyatli o‘chirildi"
     * }
     */
    public function deleteLocus($id)
    {
        $locus = Locus::find($id);
        $locus->delete();
        return response()->json(['message' => 'Locus muvaffaqiyatli o‘chirildi']);
    }

    /**
     * @group Locus
     *
     * Locusni statusini aktiv/inaktiv qilish
     *
     * @urlParam id integer required Locus ID. Misol: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "D3S1358",
     *   "status": false
     * }
     */
    public function setActive($id)
    {
        $row = Locus::find($id);
        $row->active = !$row->active;
        $row->save();
        return new LocusResource($row);
    }

    /**
     * @group Locus
     *
     * Population ID bo‘yicha locuslar ro‘yxati
     *
     * @urlParam id integer required Population ID. Misol: 2
     *
     * @response 200 [
     *   {
     *     "id": 4,
     *     "name": "D13S317",
     *     "status": true
     *   }
     * ]
     */
    public function getLocusByPopulationId($id)
    {
        return LocusResource::collection(Locus::where('population_id', $id)->get());
    }

    /**
     * @group Locus
     *
     * Locus ID bo‘yicha boshqa locuslar ro‘yxati
     *
     * @urlParam id integer required Locus ID. Misol: 1
     *
     * @response 200 [
     *   {
     *     "id": 5,
     *     "name": "FGA",
     *     "status": false
     *   }
     * ]
     */
    public function getLocusByLocusId($id)
    {
        return LocusResource::collection(Locus::where('locus_id', $id)->get());
    }
}
