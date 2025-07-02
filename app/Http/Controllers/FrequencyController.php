<?php

namespace App\Http\Controllers;

use App\Http\Resources\FrequencyResource;
use App\Models\Frequency;
use Illuminate\Http\Request;

class FrequencyController extends Controller
{
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
    
    public function delete($id)
    {
        $frequency = Frequency::find($id);
        $frequency->delete();
        return response()->json(['message' => 'Malumot o‘chirildi'], 201);
    }
    public function show($id)
    {
        $frequency = Frequency::find($id);
        return response()->json($frequency);
    }
    public function index()
    {
        $frequencies = FrequencyResource::collection(Frequency::all()); 
        return response()->json($frequencies);
    }
}
