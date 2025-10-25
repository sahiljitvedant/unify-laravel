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
use Illuminate\Support\Facades\Auth;
use App\Models\GymMember;
use App\Models\User;

class ProfileController extends Controller
{

    public function cropUpload(Request $request)
    {
        $type = $request->input('type');

        // ✅ CASE 1: Multiple gallery uploads
        if ($type === 'gallery_multiple') {
            if ($request->hasFile('gallery_images')) {
                $image = $request->file('gallery_images')[0]; // take first uploaded file

                $dateFolder = now()->format('Y-m-d');
                $destinationPath = public_path("assets/img/gallery_images/{$dateFolder}");

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);

                $relativePath = "assets/img/gallery_images/{$dateFolder}/{$filename}";
                $url = asset($relativePath);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'path' => $relativePath
                ]);
            }

            return response()->json(['success' => false]);
        }

        // ✅ CASE 2: Single uploads (profile, blog, faq, main thumbnail)
        $fileField = $type;

        if ($request->hasFile($fileField)) {
            $image = $request->file($fileField);

            $dateFolder = now()->format('Y-m-d');
            $destinationPath = public_path("assets/img/{$type}/{$dateFolder}");

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $filename);

            $relativePath = "assets/img/{$type}/{$dateFolder}/{$filename}";
            $url = asset($relativePath);

            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $relativePath
            ]);
        }

        return response()->json(['success' => false]);
    }


    public function edit_admin($id)
    {
        // dd($id);
        $user = Auth::user();

        if ($user->is_admin != 1) {
            // dd(1);
            return view('access_denied');
        }
    
        // Prevent editing another admin's profile
        if ($user->id != $id) {
            // dd(2);
            return view('access_denied');
        }
        return view('admin.edit_profile', compact('user'));
    }
    
    
    
    public function update_admin_profile(Request $request, $id)
    {
        try {
            // Validate inputs
            $request->validate([
                'name'  => 'required|string|min:2|max:50',
                'email' => 'required|email|unique:tbl_users,email,' . $id,
            ]);
    
            // Ensure logged-in admin can only edit their own record
            $user = Auth::user();
            // dd($user);
    
            if (!$user || $user->id != $id || $user->is_admin != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access Denied.'
                ], 403);
            }
    
            // Update user record
            $user = User::findOrFail($id);
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);
    
            // Update matching gym member record (if exists)
            $gymMember = GymMember::find($id);
            if ($gymMember) {
                $gymMember->update([
                    'first_name' => $request->name,
                    'email'      => $request->email,
                ]);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
}
