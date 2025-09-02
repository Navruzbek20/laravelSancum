<?php

namespace App\Http\Controllers;

use App\Http\Resources\PopulationResource;
use App\Models\Population;
use Illuminate\Http\Request;

class PopulationController extends Controller
{
    /**
     * @group Population
     *
     * Aholi ro‘yxati
     *
     * Barcha aholi yozuvlarini olish.
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "name": "Toshkent",
     *     "status": "active"
     *   }
     * ]
     */
    public function getPopulation(){
        return PopulationResource::collection(Population::paginate(env('PG')));
    }

    /**
     * @group Population
     *
     * ID bo‘yicha aholi ma'lumotini olish
     *
     * @urlParam id integer Majburiy. Aholi yozuvi IDsi. Misol: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "Toshkent",
     *   "status": "active"
     * }
     */
    public function getPopulationById($id){
        return PopulationResource::collection(Population::find($id));

    }

    /**
     * @group Population
     *
     * Aholi yozuvini yaratish
     *
     * Yangi aholi yozuvini yaratadi.
     *
     * @bodyParam name string required Aholi nomi. Misol: Andijon
     * @bodyParam status string required Status (active/inactive). Misol: active
     *
     * @response 201 {
     *   "id": 2,
     *   "name": "Andijon",
     *   "status": "active"
     * }
     */
    public function createPopulation(Request $request){
        $population = new Population();
        $population->name = $request->name;
        $population->status = $request->status ?? false;
        $population->save();
        return $population;
    }

    /**
     * @group Population
     *
     * Aholi yozuvini yangilash
     *
     * @urlParam id integer required Yangilanadigan aholi IDsi. Misol: 1
     * @bodyParam name string required Aholi nomi. Misol: Namangan
     * @bodyParam status string required Status (active/inactive). Misol: inactive
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "Namangan",
     *   "status": "inactive"
     * }
     */
    public function updatePopulation(Request $request, $id){
        $population = Population::find($id);
        $population->name = $request->name;
        $population->status = $request->status ?? false;
        $population->save();
        return $population;
    }

    /**
     * @group Population
     *
     * Aholi yozuvini o‘chirish
     *
     * @urlParam id integer required O‘chiriladigan aholi IDsi. Misol: 1
     *
     * @response 200 {
     *   "message": "Aholi muvaffaqiyatli o‘chirildi"
     * }
     */
    public function deletePopulation($id){
        $population = Population::find($id);
        $population->delete();
        return response()->json(['message' => 'Aholi muvaffaqiyatli o‘chirildi']);
    }
    public function setActive($id){
        $population = Population::find($id);
        $population->status = !$population->status;
        $population->save();
        return $population;
    }
}
