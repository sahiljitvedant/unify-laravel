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
use App\Models\HomeBanner;


class HomeBannerController extends Controller
{
    public function list()
    {
        return view('home_banner.list_banner');

    }

    
    public function fetch_home_banners(Request $request)
    {
        $query = DB::table('home_banners')
            ->select('*')
            ->where('is_deleted', '!=', 9);
        ;
    
        // ===============================
        // Filters
        // ===============================
        if ($request->filled('active')) {
            $query->where('status', $request->active);
        }
    
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
    
        // ===============================
        // Sorting
        // ===============================
        $allowedSorts = [
            'id',
            'title',
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
    
        // ===============================
        // Pagination
        // ===============================
        $banners = $query->paginate(10);
    
        // ===============================
        // Action Buttons + Encrypted ID
        // ===============================
        $banners->getCollection()->transform(function ($row) 
        {
           
    
            $row->action = '
            <a href="' . route('home_banner_edit', $row->id) . '" 
               class="btn btn-sm" title="Edit">
                <i class="bi bi-pencil-square"></i>
            </a>
        
                <button type="button" class="btn btn-sm" 
                    onclick="deleteMembershipById(' . $row->id . ')">
                    <i class="bi bi-trash"></i>
                </button>';
    
            return $row;
        });
    
        return response()->json($banners);
    }
    

    public function list_deleted_banner()
    {
        return view('home_banner.delete_banner');
    }

    
    public function fetch_deleted_home_banner(Request $request)
    {
        $query = DB::table('home_banners')
            ->select('*')
            ->where('is_deleted', '=', 9);
        ;
    
        // ===============================
        // Filters
        // ===============================
        if ($request->filled('active')) {
            $query->where('status', $request->active);
        }
    
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
    
        // ===============================
        // Sorting
        // ===============================
        $allowedSorts = [
            'id',
            'title',
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
    
        // ===============================
        // Pagination
        // ===============================
        $banners = $query->paginate(10);
    
        // ===============================
        // Action Buttons + Encrypted ID
        // ===============================
        $banners->getCollection()->transform(function ($row) 
        {
           
    
            $row->action = '
            <button type="button" class="btn btn-sm" onclick="activateMembershipID('.$row->id.')">
                <i class="bi bi-check-circle"></i>
            </button>';
    
            return $row;
        });
    
        return response()->json($banners);
    }

    public function add()
    {
        // dd(1);
     
        return view('home_banner.add_form');
    }

    
    public function add_home_banner(Request $request)
    {
        try {
            // ✅ Validation
            $validated = $request->validate([
                'title'      => 'required|string|max:255',
                'sub_title'  => 'nullable|string|max:255',
                'faq_image'  => 'nullable|string', // coming from crop upload
                'is_active'  => 'required|boolean',
            ]);
    
            DB::beginTransaction();
    
            // ✅ Handle Banner Image
            $bannerImagePath = null;
            if ($request->filled('faq_image')) {
                $bannerImagePath = parse_url($request->faq_image, PHP_URL_PATH);
                $bannerImagePath = ltrim($bannerImagePath, '/');
            }
    
            // ✅ Insert Home Banner
            $banner = HomeBanner::create([
                'title'        => $validated['title'],
                'sub_title'    => $validated['sub_title'] ?? null,
                'banner_image' => $bannerImagePath,
                'status'       => $validated['is_active'],
            ]);
    
            DB::commit();
    
            return response()->json([
                'status'  => 'success',
                'message' => 'Home Banner added successfully!',
                'id'      => $banner->id
            ]);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Home Banner Submit Error: ' . $e->getMessage());
    
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }
    
    public function edit($id)
    {
        // dd($id);
        // $decryptedId = Crypt::decryptString($id);

        $banner = DB::table('home_banners')
            ->where('id', $id)
            ->first();

        if (!$banner) {
            abort(404, 'Banner not found');
        }

        return view('home_banner.edit_form', compact('banner'));
    }
    
    public function update_home_banner(Request $request, $id)
    {
        $rules = [
            'title'      => 'required|string|max:255|unique:home_banners,title,' . $id,
            'sub_title'  => 'nullable|string|max:255',
            'faq_image'  => 'nullable|string',
            'is_active'  => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        try {
            $bannerImagePath = null;
            if ($request->filled('faq_image')) {
                $bannerImagePath = ltrim(
                    parse_url($request->faq_image, PHP_URL_PATH),
                    '/'
                );
            }

            DB::table('home_banners')
                ->where('id', $id)
                ->update([
                    'title'        => $request->title,
                    'sub_title'    => $request->sub_title,
                    'banner_image' => $bannerImagePath,
                    'status'       => $request->is_active,
                    'updated_at'   => now(),
                ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Home Banner updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }


    public function delete_home_banner($id)
    {
        $homeBanner = HomeBanner::find($id);
    
        if (!$homeBanner) 
        {
            return response()->json([
                'status'  => false,
                'message' => 'Home Banner not found'
            ], 404);
        }
    
        // Soft delete logic (inactive)
        $homeBanner->is_deleted  = 9;
        $homeBanner->save();
    
        return response()->json([
            'status'  => true,
            'message' => 'Home Banner deleted successfully'
        ]);
    }
    

  

    // Handle update

    public function activate_home_banner($id)
    {
        $homeBanner = HomeBanner::where('id', $id)
            ->where('is_deleted', 9)
            ->first();
    
        if (!$homeBanner) {
            return response()->json([
                'status'  => false,
                'message' => 'Home Banner not found'
            ], 404);
        }
    
        $homeBanner->is_deleted = 0;
        $homeBanner->save();
    
        return response()->json([
            'status'  => true,
            'message' => 'Home Banner activated successfully'
        ]);
    }
    
    public function get_membership_name(Request $request)
    {
        $query = trim($request->get('q'));

        if (empty($query)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Search cannot be empty.'
            ], 422);
        }

        $membership = DB::table('tbl_gym_membership')
            ->where('membership_name', 'LIKE', "%{$query}%")
            ->select('id', 'membership_name')
            ->first();

        if (!$membership) {
            return response()->json([
                'status' => 'error',
                'message' => 'No Membership found by this Name'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'id' => Crypt::encryptString($membership->id), // ENCRYPT ID
            'name' => $membership->membership_name
        ]);
    }

    public function frontend_home()
    {
        // dd(2);
        $banners = HomeBanner::where('status', 1)
            ->where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->get();

        $blogs = DB::table('tbl_blogs')
        ->where('is_deleted', '!=', 9)
        ->where('is_active', 1)
        ->orderBy('publish_date', 'desc')
        ->get();
    
        if (!$blogs ) {
            abort(404, 'Blogs not found');
        }

        $recent_blogs = $blogs->take(4); // Latest 4 blogs
    
        return view('front.index', compact('blogs','banners','recent_blogs'));
    }
    
}
