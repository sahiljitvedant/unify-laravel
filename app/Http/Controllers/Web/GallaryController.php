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
use App\Models\Gallery;


class GallaryController extends Controller
{
    public function list()
    {
        return view('gallary.list_gallery');

    }

   
    
    public function fetch_gallery(Request $request)
    {
        // Start Eloquent query
        $query = Gallery::query()->select('*');
    
        // Apply filters
        if ($request->filled('active')) {
            $query->where('is_active', $request->active);
        }
    
        if ($request->filled('galleryName')) {
            $query->where('gallery_name', 'like', '%' . $request->galleryName . '%');
        }
    
        // Sorting
        $allowedSorts = [
            'id',
            'gallery_name',
            'is_active',
            'created_at',
        ];
    
        $sort = $request->get('sort', 'id');
        $direction = $request->get('order', 'desc');
    
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'desc';
        }
    
        $query->orderBy($sort, $direction);
    
        // Pagination
        $galleries = $query->paginate(10);
    
        // Add action + encrypted_id
        $galleries->getCollection()->transform(function ($row) {
            $encryptedId = Crypt::encryptString($row->id);
            $row->encrypted_id = $encryptedId;
    
            $row->action = '
                <a href="' . route('edit_gallery', $encryptedId) . '" class="btn btn-sm" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-sm" onclick="deleteGalleryById(' . $row->id . ')">
                    <i class="bi bi-trash"></i>
                </button>';
    
            return $row;
        });
    
        return response()->json($galleries);
    }
    
    public function add()
    { 
        return view('gallary.add_form');
    }
    

    public function submit(Request $request)
    {
        // dd($request->all());
    
        // ✅ Validation rules
        $arr_rules = [
            'gallery_name'    => 'required|string|max:150',
            'is_active'       => 'required|boolean',
            'gallary_image'   => 'required|string', // comes as path from hidden input
            'gallery_images.*'=> 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'youtube_links.*' => 'nullable|url',
        ];
    
        $validator = Validator::make($request->all(), $arr_rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }
    
        DB::beginTransaction();
    
        try {
            // ✅ Assign basic details
            $gallery_data = [
                'gallery_name' => $request->gallery_name,
                'is_active'    => $request->is_active,
            ];
    
            // ✅ Store the cropped image path into main_thumbnail column
            if ($request->filled('gallary_image')) {
                $gallery_data['main_thumbnail'] = $request->gallary_image;
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Main thumbnail is required'
                ], 422);
            }
    
            // ✅ Handle additional gallery images (optional)
            $image_paths = [];
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/gallery'), $imageName);
                    $image_paths[] = 'uploads/gallery/' . $imageName;
                }
            }
            $gallery_data['gallery_images'] = !empty($image_paths) ? json_encode($image_paths) : null;
    
            // ✅ Handle YouTube links
            $links = [];
            if ($request->has('youtube_links')) {
                foreach ($request->youtube_links as $link) {
                    if (!empty($link)) {
                        $links[] = $link;
                    }
                }
            }
            $gallery_data['youtube_links'] = !empty($links) ? json_encode($links) : null;
    
            // ✅ Insert into DB
            $inserted_id = DB::table('tbl_gallery')->insertGetId($gallery_data);
    
            DB::commit();
    
            return response()->json([
                'status'     => 'success',
                'message'    => 'Gallery added successfully',
                'gallery_id' => $inserted_id
            ]);
    
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
    
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    

    
    public function edit($id)
    {
        
        // dd($id);
        // dd('This is edit page');

        // dd($id);

        // $decryptedId = Crypt::decryptString($id);
        // dd($decryptedId);
        $member = DB::table('tbl_gallery')->where('id', $id)->first();

        if (!$member) {
            dd(1);
            abort(404, 'Member not found');
        }
        dd(2);

        // Pass existing member data into the form
        return view('trainer.edit_trainer', compact('member'));
       
    }

    // Handle update
    public function update(Request $request, $id)
    {
        // dd('update');
        // dd($request->all());
        try 
        {
            $request->validate([
                'trainer_name' => 'required|string|min:3|max:5',
                'joining_date'     => 'required|date',
                'is_active'       => 'required',
            ]);

    
            DB::table('tbl_trainer')
                ->where('id', $id)
                ->update([
                    'trainer_name'     => $request->trainer_name,
                    'is_active'           => $request->is_active,
                    'joining_date'         => $request->joining_date,
                    'expiry_date'    => $request->expiry_date,
                ]);
    
            return response()->json(['success' => true, 'message' => 'Trainer updated successfully!']);
        } 
        catch (\Illuminate\Validation\ValidationException $e) 
        {
            // Return validation errors as JSON
            return response()->json([
                'success' => false, 
                'errors'  => $e->errors()
            ], 422);
        }
        catch (\Exception $e) 
        {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

    }
    
    public function deleteTrainer($id)
    {
        // dd(1);
        $trainer = DB::table('tbl_trainer')->where('id', $id)->first();
        // dd($trainer);
        if (!$trainer) 
        {
            return response()->json(['status' => false, 'message' => 'Trainer not found'], 404);
        }

        DB::table('tbl_trainer')
        ->where('id', $id)
        ->update([
            'is_deleted' => 9,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Trainer deleted successfully'
        ]);
    }

    public function list_deleted_trainer()
    {
        return view('trainer.list_deleted_trainer');
    }

    public function fetch_deleted_trainer(Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_trainer')
            ->select('*')
            ->where('is_deleted', '=', 9);

        // Apply filters
        if ($request->filled('active')) {
            $query->where('is_active', $request->active);
        }

        // if ($request->filled('trainer')) {
        //     // Convert 1 => 'yes', 0 => 'no'
        //     $trainerValue = $request->trainer == 1 ? 'yes' : 'no';
        //     $query->where('trainer_included', $trainerValue);
        // }

        if ($request->filled('trainerName')) {
            $query->where('trainer_name', '=', $request->trainerName);
        }

        if ($request->filled('joiningDate')) {
            $query->where('joining_date', '=', $request->joiningDate);
        }

        // Sorting
        $allowedSorts = [
            'id',
            'trainer_name',
            'joining_date',
            'expiry_date',
            'is_active',
            'created_at'
        ];

        $sort = $request->get('sort', 'id');
        $direction = $request->get('order', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        // Pagination
        $trainer = $query->paginate(10);

        // Add action + encrypted_id
        $trainer->getCollection()->transform(function ($row) {
            $encryptedId = Crypt::encryptString($row->id);
            $row->encrypted_id = $encryptedId;
            $row->action = '
            <button type="button" class="btn btn-sm" onclick="activateTrainerID('.$row->id.')">
                <i class="bi bi-check-circle"></i>
            </button>';
            return $row;
        });

        return response()->json($trainer);
    }

    public function activate_trainer($id)
    {
        // dd(1);
        $trainer = DB::table('tbl_trainer')->where('id', $id)->first();
        // dd($trainer);
        if (!$trainer) 
        {
            return response()->json(['status' => false, 'message' => 'Trainer not found'], 404);
        }

        DB::table('tbl_trainer')
        ->where('id', $id)
        ->update([
            'is_deleted' => 1,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Trainer activated successfully'
        ]);
    }

    public function show_front()
    {
        $galleries2025 = DB::table('tbl_gallery')
        // ->whereYear('created_at', 2025)
        ->get()
        ->map(function($item) {
            // If DB already has "uploads/gallery/filename.png", keep as is
            $item->main_thumbnail = $item->main_thumbnail ?: null;
            return $item;
        });

        return view('front.gallary', compact('galleries2025'));
    }
    public function gallary_details($id)
    {
        $gallery = DB::table('tbl_gallery')->where('id', $id)->first();

        if (!$gallery) {
            abort(404, 'Gallery not found');
        }
        $gallery->gallery_images = $gallery->gallery_images ? json_decode($gallery->gallery_images, true) : [];
        $gallery->youtube_links  = $gallery->youtube_links ? json_decode($gallery->youtube_links, true) : [];
    
        return view('front.gallary_details', compact('gallery'));
    }

}
