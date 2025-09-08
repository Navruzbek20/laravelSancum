<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocusGroupResource;
use App\Models\LocusGroup;
use Illuminate\Http\Request;

class LocusGroupController extends Controller
{
    /**
     * @group Locus-Group
     *
     * Locus va Groupni bog‘lash
     *
     * Yangi locus-group bog‘lanishini yaratish.
     *
     * @bodyParam locus integer required Locus ID. Misol: 1
     * @bodyParam group integer required Group ID. Misol: 2
     *
     * @response 201 {
     *   "message": "Malumot saqlandi"
     * }
     */
    public function createLocGroup(Request $request)
    {

        try {
            $locusGroup = LocusGroup::create([
                'locus_id' => $request->locus_id,
                'group_id' => $request->group_id,
            ]);

            return response()->json([
                'message' => 'Malumot saqlandi',
                'data' => $locusGroup
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
    /**
     * @group Locus-Group
     *
     * Locus-Groupni o‘chirish
     *
     * @urlParam id integer required O‘chiriladigan bog‘lanish IDsi. Misol: 5
     *
     * @response 201 {
     *   "message": "Malumot o‘chirildi"
     * }
     */
    public function delete($id)
    {
        $locusGroup = LocusGroup::find($id);
        $locusGroup->delete();
        return response()->json(['message' => 'Malumot o‘chirildi'], 201);
    }

    /**
     * @group Locus-Group
     *
     * Barcha Locus-Group bog‘lanishlarini olish
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "locus_id": 1,
     *     "group_id": 2
     *   }
     * ]
     */
    public function getLocusGroup()
    {

        return LocusGroupResource::collection(LocusGroup::paginate(env('PG')));
    }

    /**
     * @group Locus-Group
     *
     * Locus ID bo‘yicha Locus-Group bog‘lanishlarini olish
     *
     * @urlParam id integer required Locus ID. Misol: 1
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "locus_id": 1,
     *     "group_id": 2
     *   }
     * ]
     */
    public function getLocusGroupByLocus($id)
    {
        return LocusGroupResource::collection(LocusGroup::where('locus_id', $id)->get());
    }

    /**
     * @group Locus-Group
     *
     * Group ID bo‘yicha Locus-Group bog‘lanishlarini olish
     *
     * @urlParam id integer required Group ID. Misol: 2
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "locus_id": 1,
     *     "group_id": 2
     *   }
     * ]
     */
    public function getLocusGroupByGroup($id)
    {
        return LocusGroupResource::collection(LocusGroup::where('group_id', $id)->get());
    }

    /**
     * @group Locus-Group
     *
     * Locus-Group bog‘lanishini yangilash
     *
     * @urlParam id integer required Yangilanadigan bog‘lanish IDsi. Misol: 4
     * @bodyParam locus integer required Locus ID. Misol: 1
     * @bodyParam group integer required Group ID. Misol: 3
     *
     * @response 201 {
     *   "message": "Malumot saqlandi"
     * }
     */
    public function update(Request $request, $id)
    {

        $locusGroup = LocusGroup::find($id);
        $locusGroup->locus_id = $request->get('locus_id');
        $locusGroup->group_id = $request->get('group_id');
        $locusGroup->save();
        return response()->json(['message' => 'Malumot saqlandi'], 201);
    }
}
