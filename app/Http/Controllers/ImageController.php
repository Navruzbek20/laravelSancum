<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function createImage(Request $request){
        
        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // Model orqali ma'lumotlar bazasiga yozish
        $image = new Image();
        $image->name = $fileName;
        $image->path = '/storage/' . $filePath;
        $image->save();

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully!',
            'data' => $image,
        ]);
    }
}
