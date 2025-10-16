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
        $query = Gallery::query()
        ->select('*')
        ->where('is_deleted',1);
    
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
                <a href="' . route('edit_gallery', $row->id) . '" class="btn btn-sm" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-sm" onclick="deleteMembershipById(' . $row->id . ')">
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
    
        $arr_rules = [
            'gallery_name'    => 'required|string|max:150',
            'is_active'       => 'required|boolean',
            'gallary_image'   => 'required|string', // comes as path from hidden input
            'gallery_images'  => 'nullable|string', // ✅ because it's comma-separated paths
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
            $gallery_data = [
                'gallery_name' => $request->gallery_name,
                'is_active'    => $request->is_active,
            ];
    
            // ✅ Save main thumbnail
            $gallery_data['main_thumbnail'] = $request->gallary_image;
    
            // ✅ Save gallery_images as JSON (from hidden input)
            if ($request->filled('gallery_images')) {
                $paths = explode(',', $request->gallery_images);
                $gallery_data['gallery_images'] = json_encode($paths);
            } else {
                $gallery_data['gallery_images'] = null;
            }
    
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
    
            // ✅ Insert
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
        // Find the gallery by ID using Eloquent
        $gallery = Gallery::find($id);

        if (!$gallery) {
            abort(404, 'Gallery not found');
        }

        return view('gallary.edit_form', compact('gallery'));
    }

    // Handle update
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validation rules
        $rules = [
            'gallery_name'    => 'required|string|max:150',
            'is_active'       => 'required|in:0,1',
            'gallary_image_path'   => 'nullable|string', // hidden input for main thumbnail
            'gallery_images'  => 'nullable|string',     // comma-separated paths
            'youtube_links.*' => 'nullable|url',        // each link should be valid URL
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }
    
        DB::beginTransaction();
    
        try {
            $gallery = Gallery::findOrFail($id);
    
            // Update basic fields
            $gallery->gallery_name = $request->gallery_name;
            $gallery->is_active = $request->is_active;
    
            // ✅ Main thumbnail: use hidden input
            $gallery->main_thumbnail = $request->filled('gallary_image_path') 
                                       ? $request->gallary_image_path 
                                       : $gallery->main_thumbnail;
    
            // ✅ Multiple gallery images
           // Multiple gallery images
if ($request->has('gallery_images')) {
    $paths = $request->gallery_images ? explode(',', $request->gallery_images) : [];
    $gallery->gallery_images = !empty($paths) ? json_encode($paths) : null;
}

    
            // ✅ YouTube links
            $links = $request->youtube_links ?? [];
            $links = array_filter($links, fn($link) => !empty($link));
            $gallery->youtube_links = !empty($links) ? json_encode(array_values($links)) : null;

    
            $gallery->save();
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Gallery updated successfully',
                'gallery_id' => $gallery->id
            ]);
    
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gallery Update Error: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong while updating the gallery.'
            ], 500);
        }
    }
    
    
    
    public function delete_gallery($id)
    {
        // dd(1);
        // Find the gallery
        $gallery = Gallery::find($id);

        // dd($gallery);
    
        // If not found, return error response
        if (!$gallery) {
            return response()->json([
                'status' => false,
                'message' => 'Gallery not found'
            ], 404);
        }
    
        // Soft delete by setting is_deleted flag
        $gallery->is_deleted = 0;

        $gallery->save();

        // dd($gallery);
    
        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Gallery deleted successfully'
        ]);
    }
    

    public function list_deleted_gallery()
    {
        return view('gallary.list_deleted_gallery');

    }

    public function fetch_list_deleted_gallery(Request $request)
    {
        // Start Eloquent query
        $query = Gallery::query()
        ->select('*')
        ->where('is_deleted', 0);
    
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
            <button type="button" class="btn btn-sm" onclick="activateMembershipID('.$row->id.')">
                <i class="bi bi-check-circle"></i>
            </button>';
    
            return $row;
        });
    
        return response()->json($galleries);
    }

    public function activate_gallary($id)
    {
        // dd(1);
        // Find the gallery
        $gallery = Gallery::find($id);

        // dd($gallery);
    
        // If not found, return error response
        if (!$gallery) {
            return response()->json([
                'status' => false,
                'message' => 'Gallery not found'
            ], 404);
        }
    
        // Soft delete by setting is_deleted flag
        $gallery->is_deleted = 1;

        $gallery->save();

        // dd($gallery);
    
        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Gallery Saved successfully'
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
