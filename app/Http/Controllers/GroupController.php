<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * @group Group
     *
     * Yangi guruh yaratish
     *
     * @bodyParam name string required Guruh nomi. Misol: 13-marker group
     * @bodyParam status boolean optional Holati. Misol: true
     *
     * @response 201 {
     *   "id": 1,
     *   "name": "13-marker group",
     *   "status": true
     * }
     */
    public function createGroup(Request $request)
    {
        $group = new Group();
        $group->name = $request->name;
        $group->status = $request->status ?? false;
        $group->save();
        return $group;
    }

    /**
     * @group Group
     *
     * Guruhni yangilash
     *
     * @urlParam id integer required Guruh IDsi. Misol: 1
     * @bodyParam name string required Yangi nomi. Misol: X-group
     * @bodyParam status boolean required Yangi holati. Misol: false
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "X-group",
     *   "status": false
     * }
     */
    public function updateGroup(Request $request, $id)
    {
        $group = Group::find($id);
        $group->name = $request->name;
        $group->status = $request->status;
        $group->save();
        return $group;
    }

    /**
     * @group Group
     *
     * Barcha guruhlarni olish
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "name": "Group A",
     *     "status": true
     *   }
     * ]
     */
    public function getGroup()
    {
        return GroupResource::collection(Group::paginate(env('PG')));
    }

    /**
     * @group Group
     *
     * ID bo‘yicha guruhni olish
     *
     * @urlParam id integer required Guruh IDsi. Misol: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "Group A",
     *   "status": true
     * }
     */
    public function getGroupById($id)
    {
        return GroupResource::collection(Group::all())->where('id', $id)->first();
    }

    /**
     * @group Group
     *
     * Guruhni o‘chirish
     *
     * @urlParam id integer required Guruh IDsi. Misol: 1
     *
     * @response 200 {
     *   "message": "Guruh muvaffaqiyatli o‘chirildi"
     * }
     */
    public function deleteGroup($id)
    {
        $group = Group::find($id);
        $group->delete();
        return response()->json(['message' => 'Guruh muvaffaqiyatli o‘chirildi']);
    }

    /**
     * @group Group
     *
     * Guruh statusini faollashtirish yoki o‘chirish
     *
     * @urlParam id integer required Guruh IDsi. Misol: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "Group A",
     *   "status": false
     * }
     */
    public function setActive($id)
    {
        $group = Group::find($id);
        $group->active = !$group->active;
        $group->save();
        return $group;
    }
}