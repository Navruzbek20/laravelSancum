<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Genom;
use App\Models\GenomItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

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
        $genomItem->genom_id = $genom->id; // Genomdan olingan id
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

public function storeFullGenomDocument(Request $request)
{
    try {
        // 1. Validatsiya
        $request->validate([
            'genom_id' => 'required|integer',
            'document' => 'required|file|mimes:txt|max:2048'
        ]);

        // 2. Faylni o'qish
        $file = $request->file('document');
        $fileContent = file_get_contents($file->getRealPath());
        $lines = explode("\n", $fileContent);

        // 3. Ma'lumotlarni ajratish
        $sampleGroups = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            $columns = preg_split('/\s+/', $line);
            if (count($columns) >= 3) {
                $sampleName = $columns[0];
                $locusId = $columns[2];
                $alleles = array_slice($columns, 3, 9);

                $sampleGroups[$sampleName][] = [
                    'locus_id' => $locusId,
                    'alleles' => $alleles
                ];
            }
        }

        // 4. Saqlash
        foreach ($sampleGroups as $sampleName => $data) {
            $code = new Code();
            $code->name = Str::random(30);
            $code->status = 1;
            $code->save();

            $genom = new Genom();
            $genom->code_id = $code->id;
            $genom->locus_group_id = $request->input('genom_id');
            $genom->sample_name = $sampleName;
            $genom->document_path = null;
            $genom->save();

            foreach ($data as $item) {
                $genomItem = new GenomItem();
                $genomItem->genom_id = $genom->id;
                $genomItem->locus_id = $item['locus_id'];

                for ($i = 1; $i <= 9; $i++) {
                    $allelValue = isset($item['alleles'][$i - 1]) ? $item['alleles'][$i - 1] : null;
                    $genomItem->{'a' . $i} = $allelValue;
                }

                $genomItem->status = 1;
                $genomItem->save();
            }
        }

        return response()->json([
            'message' => 'Muvaffaqiyatli saqlandi',
            'samples_processed' => count($sampleGroups)
        ], 201);

    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Validatsiya xatosi',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        // MAJBURIY XATO KO'RSATISH
        return response()->json([
            'message' => 'XATOLIK ANIQLANDI',
            'error_message' => $e->getMessage(),
            'error_file' => $e->getFile(),
            'error_line' => $e->getLine(),
            'error_trace' => $e->getTraceAsString()
        ], 500);
    }
}



}