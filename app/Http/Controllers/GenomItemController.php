<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Genom;
use App\Models\GenomItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenomItemController extends Controller
{
    public function storeFullGenomData(Request $request)
{
    try {
        $request->validate([
            'locus_group_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.locus_id' => 'required|integer',
            'items.*.a1' => 'required|string',
            'items.*.a2' => 'required|string',
            'items.*.a3' => 'required|string',
            'items.*.a4' => 'required|string',
            'items.*.a5' => 'required|string',
            'items.*.a6' => 'required|string',
            'items.*.a7' => 'required|string',
            'items.*.a8' => 'required|string',
            'items.*.a9' => 'required|string'
        ]);
    // 1. Codes jadvaliga saqlash
    $code = new Code();
    $code->name = Str::random(30); // 30 xonali random kod
    $code->status = 1;
    $code->save();

    // 2. Genom jadvaliga saqlash
    $genom = new Genom();
    $genom->code_id = $code->id; // Code jadvalidan olingan id
    $genom->locus_group_id = $request->input('locus_group_id'); // tashqaridan keladi
    $genom->save();

    // 3. GenomItems jadvaliga saqlash (array bo‘lishi kerak)
    $items = $request->input('items'); // JSON array bo‘lishi kerak

    foreach ($items as $item) {
        $genomItem = new GenomItem();
        $genomItem->gemon_id = $genom->id; // Genomdan olingan id
        $genomItem->locus_id = $item['locus_id'];
        $genomItem->a1 = $item['a1'];
        $genomItem->a2 = $item['a2'];
        $genomItem->a3 = $item['a3'];
        $genomItem->a4 = $item['a4'];
        $genomItem->a5 = $item['a5'];
        $genomItem->a6 = $item['a6'];
        $genomItem->a7 = $item['a7'];
        $genomItem->a8 = $item['a8'];
        $genomItem->a9 = $item['a9'];
        $genomItem->status = 1;
        $genomItem->save();
    }

    return response()->json([
        'message' => 'Maʼlumotlar muvaffaqiyatli saqlandi',
        'code_id' => $code->id,
        'genom_id' => $genom->id
    ], 201);
} catch (\Exception $e) {
    return response()->json([
        'message' => 'Xatolik yuz berdi',
        'error' => $e->getMessage()
    ], 500);
}
}
}
