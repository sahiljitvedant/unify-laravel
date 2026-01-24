<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TermsConditionController extends Controller
{
    /* =========================
     * ADD TERMS & CONDITIONS
     * ========================= */
    public function add()
    {
        $terms_description = DB::table('tbl_terms_conditions')->value('description');

        return view('terms_conditions.add_terms_conditions', compact('terms_description'));
    }

    /* =========================
     * SUBMIT / UPDATE TERMS
     * ========================= */
    public function submit(Request $request)
    {
        $now = Carbon::now();

        // Only fetch description
        $terms_data = $request->only(['terms_description']);

        // Validation
        $validator = Validator::make($terms_data, [
            'terms_description' => 'required|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Check if record exists
            $existingTerms = DB::table('tbl_terms_conditions')->first();

            if ($existingTerms) {
                // Update existing
                DB::table('tbl_terms_conditions')
                    ->where('id', $existingTerms->id)
                    ->update([
                        'description' => $terms_data['terms_description'],
                        'updated_at'  => $now,
                    ]);

                $message = 'Terms & Conditions updated successfully';
                $terms_id = $existingTerms->id;
            } else {
                // Insert new
                $terms_id = DB::table('tbl_terms_conditions')->insertGetId([
                    'description' => $terms_data['terms_description'],
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);

                $message = 'Terms & Conditions added successfully';
            }

            DB::commit();

            return response()->json([
                'status'   => 'success',
                'message'  => $message,
                'terms_id' => $terms_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /* =========================
     * FRONT TERMS PAGE
     * ========================= */
    public function terms_conditions()
    {
        $terms = DB::table('tbl_terms_conditions')->first();

        if (!$terms) {
            abort(404, 'Terms & Conditions not found');
        }

        return view('front.terms_conditions', compact('terms'));
    }
}
