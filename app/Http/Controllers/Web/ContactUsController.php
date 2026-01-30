<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ContactUsController extends Controller
{
    public function contactus()
    {
        $contact = DB::table('tbl_admin_contact')->first();
        return view('admincontact.contactus', compact('contact'));
    }

    public function submit(Request $request)
    {
        $now = Carbon::now();

        // Get all fields (all optional)
        $contact_data = $request->only([
            'youtube_url',
            'facebook_url',
            'linkedin_url',
            'instagram_url',
            'mobile_number1',
            'mobile_number2',
            'email_address1',
            'email_address2',
            'business_hours',
            'business_day',
        ]);

        // No required validation (everything optional)
        $validator = Validator::make($contact_data, []);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Check if record already exists
            $existing = DB::table('tbl_admin_contact')->first();

            if ($existing) {
                DB::table('tbl_admin_contact')
                    ->where('id', $existing->id)
                    ->update(array_merge($contact_data, [
                        'updated_at' => $now
                    ]));

                $message = 'Contact details updated successfully';
                $id = $existing->id;

            } else {
                $id = DB::table('tbl_admin_contact')->insertGetId(array_merge($contact_data, [
                    'created_at' => $now,
                    'updated_at' => $now
                ]));

                $message = 'Contact details added successfully';
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'contact_id' => $id
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
