<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyBrochure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CompanyBrochureController extends Controller
{
    /**
     * Add / Edit page
     */
    public function add()
    {
        $brochure = CompanyBrochure::first();
        return view('company_brochure.add', compact('brochure'));
    }


    /**
     * Store / Update brochure
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brochure_file' => 'required|mimes:pdf|max:20480', // 20MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $now = Carbon::now();

            $brochure = CompanyBrochure::first();

            // upload new file
            $file = $request->file('brochure_file');
            $path = $file->store('brochures', 'public');
            $newPath = 'storage/' . $path;

            if ($brochure) {

                // delete old file
                if ($brochure->file_path && Storage::disk('public')->exists(str_replace('storage/', '', $brochure->file_path))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $brochure->file_path));
                }

                $brochure->update([
                    'file_path' => $newPath,
                    'updated_at' => $now
                ]);

                $message = "Company brochure updated successfully";

            } else {

                CompanyBrochure::create([
                    'file_path' => $newPath,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                $message = "Company brochure added successfully";
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save brochure'
            ], 500);
        }
    }


    /**
     * Front View
     */
    public function view()
    {
        $brochure = CompanyBrochure::first();

        if (!$brochure) {
            abort(404, 'Brochure not found');
        }

        return view('front.company_brochure', compact('brochure'));
    }
}
