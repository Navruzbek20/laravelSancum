<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocusResource;
use App\Models\Locus;
use Illuminate\Http\Request;

class LocusController extends Controller
{
    public function getLocus()
    {
        return LocusResource::collection(Locus::all());
    }
    public function getLocusById($id)
    {
        return new LocusResource(Locus::find($id));
    }
    public function deleteLocus($id)
    {
        $locus = Locus::find($id);
        $locus->delete();
        return response()->json(['message' => 'Locus muvaffaqiyatli o‘chirildi']);
    }
    public function updateLocus(Request $request, $id)
    {
        $locus = Locus::find($id);
        $locus->name = $request->name;
        $locus->status = $request->status;
        $locus->save();
        return $locus;
    }
    public function createLocus(Request $request)
    {
        $locus = new Locus();
        $locus->name = $request->name;
        $locus->status = $request->status ?? false;
        $locus->save();
        return $locus;
    }
    public function getLocusByPopulationId($id)
    {
        return LocusResource::collection(Locus::where('population_id', $id)->get());
    }
    public function getLocusByLocusId($id)
    {
        return LocusResource::collection(Locus::where('locus_id', $id)->get());
    }
    public function setActive($id)
    {
        $row = Locus::find($id);
        $row->status = !$row->status;
        $row->save();
        return new LocusResource($row);
    }
}
