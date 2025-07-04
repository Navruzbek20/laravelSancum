<?php

namespace App\Http\Controllers;

use App\Http\Resources\FrequencyResource;
use App\Models\Frequency;
use Illuminate\Http\Request;

class FrequencyController extends Controller
{
    /**
     * @group Frequency
     * 
     * Yangi frekans yozuvini yaratish
     * 
     * @bodyParam locus integer required Locus ID. Misol: 1
     * @bodyParam population integer required Population ID. Misol: 2
     * @bodyParam symbol string required Simvol. Misol: A
     * @bodyParam alel_name string required Alel nomi. Misol: A1
     * @bodyParam frequency double required Ehtimollik qiymati. Misol: 0.25
     * 
     * @response 201 {
     *   "message": "Maʼlumot saqlandi"
     * }
     */
    public function create(Request $request)
    {
        Frequency::create([
            'locus_id' => $request->locus,
            'population_id' => $request->population,
            'symbol' => $request->symbol,
            'alel_name' => $request->alel_name,
            'frequency' => $request->frequency
        ]);

        return response()->json(['message' => 'Maʼlumot saqlandi'], 201);
    }

    /**
     * @group Frequency
     * 
     * Frekans yozuvini yangilash
     * 
     * @urlParam id integer required Frekans IDsi. Misol: 1
     * @bodyParam locus integer required Locus ID. Misol: 1
     * @bodyParam population integer required Population ID. Misol: 2
     * @bodyParam symbol string required Simvol. Misol: A
     * @bodyParam alel_name string required Alel nomi. Misol: A1
     * @bodyParam frequency double required Ehtimollik qiymati. Misol: 0.25
     * 
     * @response 200 {
     *   "message": "Maʼlumot yangilandi"
     * }
     */
    public function update(Request $request, $id)
    {
        $frequency = Frequency::find($id);

        $frequency->locus_id = $request->get('locus');
        $frequency->population_id = $request->get('population');
        $frequency->symbol = $request->get('symbol');
        $frequency->alel_name = $request->get('alel_name');
        $frequency->frequency = $request->get('frequency');

        $frequency->save();

        return response()->json(['message' => 'Maʼlumot yangilandi']);
    }

    /**
     * @group Frequency
     * 
     * Frekans yozuvini o‘chirish
     * 
     * @urlParam id integer required O‘chiriladigan ID. Misol: 3
     * 
     * @response 201 {
     *   "message": "Malumot o‘chirildi"
     * }
     */
    public function delete($id)
    {
        $frequency = Frequency::find($id);
        $frequency->delete();
        return response()->json(['message' => 'Malumot o‘chirildi'], 201);
    }

    /**
     * @group Frequency
     * 
     * ID bo‘yicha frekans yozuvini ko‘rish
     * 
     * @urlParam id integer required ID. Misol: 1
     * 
     * @response 200 {
     *   "id": 1,
     *   "locus_id": 1,
     *   "population_id": 2,
     *   "symbol": "A",
     *   "alel_name": "A1",
     *   "frequency": 0.25
     * }
     */
    public function show($id)
    {
        $frequency = Frequency::find($id);
        return response()->json($frequency);
    }

    /**
     * @group Frequency
     * 
     * Barcha frekans yozuvlarini olish
     * 
     * @response 200 [
     *   {
     *     "id": 1,
     *     "locus_id": 1,
     *     "population_id": 2,
     *     "symbol": "A",
     *     "alel_name": "A1",
     *     "frequency": 0.25
     *   }
     * ]
     */
    public function index()
    {
        $frequencies = FrequencyResource::collection(Frequency::all());
        return response()->json($frequencies);
    }
}
