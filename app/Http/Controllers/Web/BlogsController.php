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

class BlogsController extends Controller
{
    public function list()
    {
        return view('blogs.list_blogs');
       
    }

    public function fetch_blogs(Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_blogs')
            ->select('*')
            ->where('is_deleted', '!=', 9);

        // Apply filters
        if ($request->filled('active')) {
            $query->where('is_active', $request->active);
        }

        // if ($request->filled('trainer')) {
        //     // Convert 1 => 'yes', 0 => 'no'
        //     $trainerValue = $request->trainer == 1 ? 'yes' : 'no';
        //     $query->where('trainer_included', $trainerValue);
        // }

        if ($request->filled('blogname')) {
            $query->where('blog_title', '=', $request->blogname);
        }

        if ($request->filled('joiningDate')) {
            $query->where('joining_date', '=', $request->joiningDate);
        }

        // Sorting
        $allowedSorts = [
            'id',
            'blog_title',
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
                <a href="'.route('edit_blogs', $encryptedId).'" class="btn btn-sm" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-sm" onclick="deleteMembershipById('.$row->id.')">
                    <i class="bi bi-trash"></i>
                </button>';
            return $row;
        });

        return response()->json($trainer);
    }
    public function add()
    { 
        return view('blogs.add_form');
       
    }
    

    public function submit(Request $request)
    {
        // Validation rules
        $arr_rules = [
            'blog_title'   => 'required|string|max:150',
            'description'  => 'required|string|max:1000',
            'publish_date' => 'required|date',
            'is_active'    => 'required|boolean',
            'blog_image'   => 'required|string'
        ];
    
        // Validate the inputs
        $validator = Validator::make($request->all(), $arr_rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }
    
        DB::beginTransaction();
    
        try {
            $blog_data = $request->only(['blog_title', 'description', 'publish_date', 'is_active']);
            $blog_data['blog_image'] = $request->input('blog_image');
            $inserted_id = DB::table('tbl_blogs')->insertGetId($blog_data);
    
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Blog added successfully',
                'blog_id' => $inserted_id
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
    
    
    
    public function edit($id)
    {
        
        // dd($id);
        // dd('This is edit page');

        // dd($id);

        $decryptedId = Crypt::decryptString($id);
        // dd($decryptedId);
        $member = DB::table('tbl_blogs')->where('id', $decryptedId)->first();

        if (!$member) {
            abort(404, 'Blog not found');
        }

        // Pass existing member data into the form
        return view('blogs.edit_form', compact('member'));
       
       
    }

    // Handle update
    public function update(Request $request, $id)
    {
        // dd('update');
        // dd($request->all());
        try 
        {
            // $request->validate([
            //     'trainer_name' => 'required|string|min:3|max:5',
            //     'joining_date'     => 'required|date',
            //     'is_active'       => 'required',
            // ]);

    
            DB::table('tbl_blogs')
                ->where('id', $id)
                ->update([
                    'blog_title'     => $request->blog_title,
                    'is_active'           => $request->is_active,
                    'description'         => $request->description,
                    'publish_date'    => $request->publish_date,
                    'blog_image'    => $request->blog_image,
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
    
    public function delete_blogs($id)
    {
        // dd(1);
        $trainer = DB::table('tbl_blogs')->where('id', $id)->first();
        // dd($trainer);
        if (!$trainer) 
        {
            return response()->json(['status' => false, 'message' => 'Trainer not found'], 404);
        }

        DB::table('tbl_blogs')
        ->where('id', $id)
        ->update([
            'is_deleted' => 9,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Blog deleted successfully'
        ]);
    }

    public function list_deleted_blogs()
    {
        return view('blogs.list_deleted_blogs');
       
    }

    public function fetch_deleted_blogs(Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_blogs')
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

        if ($request->filled('blogname')) {
            $query->where('blog_title', '=', $request->blogname);
        }

        if ($request->filled('joiningDate')) {
            $query->where('joining_date', '=', $request->joiningDate);
        }

        // Sorting
        $allowedSorts = [
            'id',
            'blog_title',
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

    public function activate_blogs($id)
    {
        // dd(1);
        $trainer = DB::table('tbl_blogs')->where('id', $id)->first();
        // dd($trainer);
        if (!$trainer) 
        {
            return response()->json(['status' => false, 'message' => 'Blog not found'], 404);
        }

        DB::table('tbl_blogs')
        ->where('id', $id)
        ->update([
            'is_deleted' => 1,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Blog activated successfully'
        ]);
    }
    public function home()
    {
        $blogs = DB::table('tbl_blogs')
        ->where('is_deleted', '!=', 9)
            ->where('is_active', 1)
            ->orderBy('publish_date', 'desc')
            ->get();
    
        if ($blogs->isEmpty()) {
            abort(404, 'Blogs not found');
        }
    
        $latest_blogs = $blogs->take(3);
     // dd($latest_blogs );
        // Pass as string keys
        return view('front.index', [
            'blogs' => $blogs,
            'latest_blogs' => $latest_blogs,
        ]);
    }
    
    public function blogs()
    {
        // dd(1);
        $blogs = DB::table('tbl_blogs')
        ->where('is_deleted', '!=', 9)
        ->where('is_active', 1)
        ->orderBy('publish_date', 'desc')
        ->get();
  
        if (!$blogs ) {
            abort(404, 'Blogs not found');
        }

        $recent_blogs = $blogs->take(4); // Latest 4 blogs
        return view('front.blogs', compact('blogs','recent_blogs'));

    }
    public function blogs_read_more($id)
    {
        try {
            $decryptedId = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid blog ID');
        }
    
        // dd($decryptedId);
        $blog = DB::table('tbl_blogs')
            ->where('id', $decryptedId)           
            ->where('is_active', 1)
            ->first();
    
        if (!$blog) {
            abort(404, 'Blog not found');
        }
    
        return view('front.blogs_read_more', compact('blog'));
    }

}
