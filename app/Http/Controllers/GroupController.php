<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function createGroup(Request $request)
    {
        $group = new Group();
        $group->name = $request->name;
        $group->status = $request->status ?? false;
        $group->save();
        return $group;
    }
    public function updateGroup(Request $request, $id)
    {
        $group = Group::find($id);
        $group->name = $request->name;
        $group->status = $request->status;
        $group->save();
        return $group;
    }
    public function getGroup()
    {
        return GroupResource::collection(Group::all());
    }
    public function getGroupById($id)
    {
        return GroupResource::collection(Group::all())->where('id', $id)->first();
    }
    public function deleteGroup($id)
    {
        $group = Group::find($id);
        $group->delete();
        return response()->json(['message' => 'Guruh muvaffaqiyatli o‘chirildi']);
    }
    public function setActive($id){
        $group = Group::find($id);
        $group->status = !$group->status;
        $group->save();
        return $group;
    }
}
