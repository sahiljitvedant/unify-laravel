<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables; 
use Illuminate\Support\Facades\Crypt;
class ProfileController extends Controller
{
    // ProfileController.php
//     public function cropUpload(Request $request)
// {
//     $type = $request->input('type'); // profile_image or blog_image
//     $fileField = $type === 'blog_image' ? 'blog_image' : 'profile_image';

//     if ($request->hasFile($fileField)) {
//         $image = $request->file($fileField);

//         // Create folder based on type and date
//         $dateFolder = now()->format('Y-m-d');
//         $destinationPath = public_path("assets/img/{$type}/{$dateFolder}");

//         if (!file_exists($destinationPath)) {
//             mkdir($destinationPath, 0777, true);
//         }

//         // Unique filename
//         $filename = time() . '.' . $image->getClientOriginalExtension();

//         // Move file
//         $image->move($destinationPath, $filename);

//         // Relative path (store this in DB)
//         $relativePath = "assets/img/{$type}/{$dateFolder}/{$filename}";

//         // Full URL for preview
//         $url = asset($relativePath);

//         return response()->json([
//             'success' => true,
//             'url' => $url,          // for preview
//             'path' => $relativePath // for storing in DB
//         ]);
//     }

//     return response()->json(['success' => false]);
// }
public function cropUpload(Request $request)
{
    $type = $request->input('type'); // blog_image, profile_image, faq_image
    $fileField = $type; // directly use the type as field name

    if ($request->hasFile($fileField)) {
        $image = $request->file($fileField);

        // Create folder based on type and date
        $dateFolder = now()->format('Y-m-d');
        $destinationPath = public_path("assets/img/{$type}/{$dateFolder}");

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Unique filename
        $filename = time() . '.' . $image->getClientOriginalExtension();

        // Move file
        $image->move($destinationPath, $filename);

        // Relative path (store this in DB)
        $relativePath = "assets/img/{$type}/{$dateFolder}/{$filename}";

        // Full URL for preview
        $url = asset($relativePath);

        return response()->json([
            'success' => true,
            'url' => $url,
            'path' => $relativePath
        ]);
    }

    return response()->json(['success' => false]);
}

    
    

}
