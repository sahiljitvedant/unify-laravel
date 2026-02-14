<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /* =======================
     * LIST PAGE
     * ======================= */
    public function list()
    {
        return view('testimonial.list_testimonials');
    }

    /* =======================
     * FETCH TESTIMONIALS
     * ======================= */
    public function fetch_testimonials(Request $request)
    {
        $query = DB::table('tbl_testimonials')
            ->where('is_deleted', '!=', 9);
    
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }
    
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->filled('position')) {
            $query->where('position', 'like', '%' . $request->position . '%');
        }
    
        $allowedSorts = ['id', 'name', 'position', 'created_at'];
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
    
        if (!in_array($sort, $allowedSorts)) $sort = 'id';
        if (!in_array(strtolower($order), ['asc', 'desc'])) $order = 'desc';
    
        $query->orderBy($sort, $order);
    
        $testimonials = $query->paginate(10);
    
        $testimonials->getCollection()->transform(function ($row) {
            $row->action = '
            <a href="' . route('edit_testimonial', $row->id) . '" class="btn btn-sm">
                <i class="bi bi-pencil-square"></i>
            </a>
            <button class="btn btn-sm" onclick="deleteTestimonialRecord(' . $row->id . ')">
                <i class="bi bi-trash"></i>
            </button>';
        
            return $row;
        });
    
        return response()->json($testimonials);
    }
    
    
    /* =======================
     * ADD PAGE
     * ======================= */
    public function add()
    {
        return view('testimonial.add_testimonial');
    }

    /* =======================
     * STORE TESTIMONIAL
     * ======================= */
    public function store(Request $request)
    {
        // dd($request);
        $rules = [
            'name' => 'required|string|max:150',
            'position' => 'nullable|string|max:150',
            'testimonial_text' => 'required|string|max:500',
            'profile_pic' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        try {
            $imagePath = $request->profile_pic ?? null;


            Testimonial::create([
                'profile_pic' => $imagePath,
                'name' => $request->name,
                'position' => $request->position,
                'testimonial_text' => $request->testimonial_text,
                'is_active' => $request->is_active,
                'is_deleted' => 0,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Testimonial added successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Testimonial Store Error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /* =======================
     * EDIT PAGE
     * ======================= */
    public function edit($id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            abort(404, 'Testimonial not found');
        }

        return view('testimonial.edit_testimonial', compact('testimonial'));
    }

    /* =======================
     * UPDATE TESTIMONIAL
     * ======================= */
    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:150',
            'position' => 'nullable|string|max:150',
            'testimonial_text' => 'required|string|max:500',
            'profile_pic' => 'nullable|string', // path from crop upload
            'is_active' => 'required|boolean',
        ]);
    
        $testimonial = Testimonial::findOrFail($id);
    
        $testimonial->update([
            'name' => $request->name,
            'position' => $request->position,
            'testimonial_text' => $request->testimonial_text,
            'profile_pic' => $request->profile_pic,
            'is_active' => $request->is_active,
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial updated successfully'
        ]);
    }
    
    
    

    /* =======================
     * DELETE TESTIMONIAL
     * ======================= */
    public function delete($id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return response()->json([
                'status'  => false,
                'message' => 'Testimonial not found'
            ], 404);
        }

        $testimonial->is_deleted = 9;
        $testimonial->save();

        return response()->json([
            'status'  => true,
            'message' => 'Testimonial deleted successfully'
        ]);
    }

    /* =======================
     * ACTIVATE TESTIMONIAL
     * ======================= */
    public function activate($id)
    {
        $testimonial = Testimonial::where('id', $id)
            ->where('is_deleted', 9)
            ->first();

        if (!$testimonial) {
            return response()->json([
                'status'  => false,
                'message' => 'Testimonial not found'
            ], 404);
        }

        $testimonial->is_deleted = 0;
        $testimonial->save();

        return response()->json([
            'status'  => true,
            'message' => 'Testimonial activated successfully'
        ]);
    }

    /* =======================
     * LIST DELETED TESTIMONIALS
     * ======================= */
    public function list_deleted_testimonials()
    {
        return view('testimonial.list_deleted_testimonials');
    }

    /* =======================
     * FETCH DELETED TESTIMONIALS
     * ======================= */
    public function fetch_deleted_testimonials(Request $request)
    {
        $query = DB::table('tbl_testimonials')
            ->where('is_deleted', 9);
    
        // Filters
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
    
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        // Sorting
        $allowedSorts = ['id', 'name', 'position', 'created_at'];
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
    
        if (!in_array($sort, $allowedSorts)) $sort = 'id';
        if (!in_array(strtolower($order), ['asc', 'desc'])) $order = 'desc';
    
        $query->orderBy($sort, $order);
    
        $testimonials = $query->paginate(10);
    
        $testimonials->getCollection()->transform(function ($row) {
            $row->action = '
                <button type="button" class="btn btn-sm"
                    onclick="activateTestimonialById('.$row->id.')">
                    <i class="bi bi-check-circle"></i>
                </button>';
            return $row;
        });
    
        return response()->json($testimonials);
    }
    
}
