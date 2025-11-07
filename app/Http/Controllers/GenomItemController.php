<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenomItemResource;
use App\Models\Code;
use App\Models\Genom;
use App\Models\GenomItem;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class GenomItemController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // 🔹 1. Validatsiya
            $request->validate([
                'locus_group_id' => 'required|integer',
                'items' => 'required|array|min:1',
                'items.*.locus_id' => 'required|integer',
                'card_data' => 'nullable|array',
            ]);

            // 🔹 2. Code yaratamiz
            $code = new Code();
            $code->name = Str::random(30);
            $code->active = false;
            $code->save();

            // 🔹 3. Genom yaratamiz
            $genom = new Genom();
            $genom->code_id = $code->id;
            $genom->locus_group_id = $request->input('locus_group_id');
            $genom->active = false;
            $genom->save();

            // 🔹 4. GenomItem’larni yaratamiz
            foreach ($request->input('items') as $item) {
                $genomItem = new GenomItem();
                $genomItem->genom_id = $genom->id;
                $genomItem->locus_id = $item['locus_id'];
                $genomItem->a1 = $item['a1'] ?? null;
                $genomItem->a2 = $item['a2'] ?? null;
                $genomItem->a3 = $item['a3'] ?? null;
                $genomItem->a4 = $item['a4'] ?? null;
                $genomItem->a5 = $item['a5'] ?? null;
                $genomItem->a6 = $item['a6'] ?? null;
                $genomItem->a7 = $item['a7'] ?? null;
                $genomItem->a8 = $item['a8'] ?? null;
                $genomItem->a9 = $item['a9'] ?? null;
                $genomItem->active = false;
                $genomItem->save();
            }

            // 🔹 5. Person (Karta ma’lumotlari) bo‘lsa, saqlaymiz
            $cardData = $request->input('card_data');
            if ($cardData) {
                $person = new Person();
                $person->code_id = $code->id; // Genom bilan bog‘lanadi
                $person->surname = $cardData['surname'] ?? null;
                $person->name = $cardData['name'] ?? null;
                $person->ful_name = $cardData['ful_name'] ?? null;
                $person->work_type = $cardData['work_type'] ?? null;
                $person->birth_date = $cardData['birth_date'] ?? null;
                $person->province_id = $cardData['province_id'] ?? null;
                $person->district_id = $cardData['district_id'] ?? null;
                $person->sex = $cardData['sex'] ?? null;
                $person->citizenship = $cardData['citizenship'] ?? null;
                $person->nationality = $cardData['nationality'] ?? null;
                $person->address = $cardData['address'] ?? null;
                $person->p_number = $cardData['p_number'] ?? null;
                $person->document = $cardData['document'] ?? null;
                $person->category = $cardData['category'] ?? null;
                $person->name_object = $cardData['name_object'] ?? null;
                $person->active = false;
                $person->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Genom va karta maʼlumotlari muvaffaqiyatli saqlandi.',
                'code_id' => $code->id,
                'genom_id' => $genom->id,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Saqlashda xatolik yuz berdi.',
                'error' => $e->getMessage(),
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
    public function index()
    {
        return GenomItemResource::collection(GenomItem::paginate(env('PG')));
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'locus_group_id' => 'required|integer',
                'items' => 'required|array',
                'items.*.locus_id' => 'required|integer',
                'items.*.a1' => 'nullable|string',
                'items.*.a2' => 'nullable|string',
                'items.*.a3' => 'nullable|string',
                'items.*.a4' => 'nullable|string',
                'items.*.a5' => 'nullable|string',
                'items.*.a6' => 'nullable|string',
                'items.*.a7' => 'nullable|string',
                'items.*.a8' => 'nullable|string',
                'items.*.a9' => 'nullable|string'
            ]);

            $genom = Genom::findOrFail($id);
            $genom->locus_group_id = $request->input('locus_group_id');
            $genom->save();

            $items = $request->input('items', []);
            foreach ($items as $item) {
                // Try to find existing record by genom_id + locus_id, otherwise create new
                $genomItem = GenomItem::where('genom_id', $genom->id)
                    ->where('locus_id', $item['locus_id'])
                    ->first();

                if (! $genomItem) {
                    $genomItem = new GenomItem();
                    $genomItem->genom_id = $genom->id;
                    $genomItem->locus_id = $item['locus_id'];
                }

                // Update allele columns a1..a9
                for ($i = 1; $i <= 9; $i++) {
                    $key = 'a' . $i;
                    $genomItem->{$key} = array_key_exists($key, $item) ? $item[$key] : $genomItem->{$key};
                }

                // allow optional status override, default keep or set to 1
                $genomItem->status = $item['status'] ?? ($genomItem->status ?? 1);
                $genomItem->save();
            }

            return response()->json([
                'message' => 'Genom maʼlumotlari yangilandi',
                'genom_id' => $genom->id
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validatsiya xatosi',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Xatolik yuz berdi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
