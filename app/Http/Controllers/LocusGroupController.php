<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocusGroupResource;
use App\Models\LocusGroup;
use Illuminate\Http\Request;

class LocusGroupController extends Controller
{
    public function create(Request $request)
    {
        $locus = $request->input('locus');
        $group = $request->input('group');
        $locusGroup = new LocusGroup();
        $locusGroup->locus_id = $locus;
        $locusGroup->group_id = $group;
        $locusGroup->save();
        return response()->json(['message' => 'Malumot saqlandi'], 201);
    }
    public function delete($id)
    {
        $locusGroup = LocusGroup::find($id);
        $locusGroup->delete();
        return response()->json(['message' => 'Malumot o‘chirildi'], 201);
    }
    public function getLocusGroup()
    {
        $locusGroup = LocusGroupResource::collection(LocusGroup::all());
        return $locusGroup;
    }
    public function getLocusGroupByLocus($id)
    {
        $locusGroup = LocusGroupResource::collection(LocusGroup::where('locus_id', $id)->get());
        return $locusGroup;
    }
    public function getLocusGroupByGroup($id)
    {
        $locusGroup = LocusGroupResource::collection(LocusGroup::where('group_id', $id)->get());
        return $locusGroup;
    }
    public function undate(Request $request, $id)
    {
        $locus = $request->input('locus');
        $group = $request->input('group');
        $locusGroup = LocusGroup::find($id);
        $locusGroup->locus_id = $locus;
        $locusGroup->group_id = $group;
        $locusGroup->save();
        return response()->json(['message' => 'Malumot saqlandi'], 201);
    }
}
