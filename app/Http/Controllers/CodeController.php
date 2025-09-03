<?php

namespace App\Http\Controllers;

use App\Http\Resources\CodeResource;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CodeController extends Controller
{
    public function create(Request $request)
    {
        $code = new Code();
        $code->name = Str::random(30); // 30 ta belgidan iborat random kod
        $code->status = 1;
        $code->save();

        return response()->json([
            'message' => 'Maʼlumot saqlandi',
            'data' => $code
        ], 201);
    }
    public function delte(Request $request, $id)
    {
        $code = Code::find($id);
        $code->delete();
        return response()->json([
            'message' => 'Maʼlumot oʻchirildi'
        ], 201);
    }
    public function show($id)
    {
        $code = Code::find($id);
        return response()->json([
            'message' => 'Maʼlumot oʻchirildi',
            'data' => $code
        ], 201);
    }
    public function index()
    {
        return CodeResource::collection(Code::all())->paginate(env('PG'));

    }
}
