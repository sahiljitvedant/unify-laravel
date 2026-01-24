<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\Models\AboutPage;
use App\Models\Header;
use App\Models\SubHeader;

class AboutPageController  extends Controller
{
    public function list()
    {
        return view('about_page.list_page');
    }

    public function fetch_about_pages(Request $request)
    {
        $query = DB::table('about_pages')
            ->select('*')
            ->where('is_deleted', '!=', 9);

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
        $allowedSorts = ['id', 'title'];

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
        $pages = $query->paginate(10);

        // ===============================
        // Action Buttons
        // ===============================
        $pages->getCollection()->transform(function ($row) {

            $row->action = '
            <a href="' . route('about_page_edit', $row->id) . '" class="btn btn-sm" title="Edit">
                <i class="bi bi-pencil-square"></i>
            </a>
        
            <button type="button" class="btn btn-sm" onclick="deleteAboutPageById(' . $row->id . ')">
                <i class="bi bi-trash"></i>
            </button>';

            return $row;
        });

        return response()->json($pages);
    }

    public function list_deleted_about_page()
    {
        return view('about_page.delete_page');
    }

    public function fetch_deleted_about_page(Request $request)
    {
        $query = DB::table('about_pages')
            ->select('*')
            ->where('is_deleted', '=', 9);

        if ($request->filled('active')) {
            $query->where('status', $request->active);
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $allowedSorts = ['id', 'title'];

        $sort = $request->get('sort', 'id');
        $direction = $request->get('order', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        $pages = $query->paginate(10);

        $pages->getCollection()->transform(function ($row) {

            $row->action = '
            <button type="button" class="btn btn-sm" onclick="activateAboutPageID(' . $row->id . ')">
                <i class="bi bi-check-circle"></i>
            </button>';

            return $row;
        });

        return response()->json($pages);
    }

    public function add()
    {
        $headers = Header::where('is_deleted', 0)->get();
        return view('about_page.add_form', compact('headers'));
    }
    

    public function add_about_page(Request $request)
    {
        // dd(1);
        try {
            $validated = $request->validate([
                'title'        => 'required|string|max:255',
                'slug'         => 'required|string|max:255|unique:about_pages,slug',
                'header_id'    => 'required|exists:headers,id',   // ✅ mandatory
                'subheader_id' => 'nullable|exists:subheaders,id',
                'description'  => 'required|string',              // ✅ CKEditor
                'page_image'   => 'required|string',              // ✅ now mandatory
                'is_active'    => 'required|in:0,1',
            ]);
    
            DB::beginTransaction();
    
            // Handle image path
            $imagePath = null;
            if ($request->filled('page_image')) {
                $imagePath = ltrim(parse_url($request->page_image, PHP_URL_PATH), '/');
            }
    
            $page = AboutPage::create([
                'title'        => $validated['title'],
                'slug'         => $validated['slug'],
                'header_id'    => $validated['header_id'],
                'subheader_id' => $validated['subheader_id'] ?? null,
                'description'  => $validated['description'],
                'image'        => $imagePath,
                'status'       => $validated['is_active'],
                'is_deleted'   => 0,
            ]);
    
            DB::commit();
    
            return response()->json([
                'status'  => 'success',
                'message' => 'About Page added successfully!',
                'id'      => $page->id
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
            Log::error('About Page Submit Error: ' . $e->getMessage());
    
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }
    
    public function edit($id)
    {
        $page = AboutPage::where('id', $id)
            ->where('is_deleted', 0)
            ->first();
    
        if (!$page) {
            abort(404, 'Page not found');
        }
    
        $headers = Header::where('is_deleted', 0)->get();
        $subheaders = SubHeader::where('is_deleted', 0)
            ->where('header_id', $page->header_id)
            ->get();
    
        return view('about_page.edit_form', compact(
            'page',
            'headers',
            'subheaders'
        ));
    }
    
    public function update_about_page(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title'        => 'required|string|max:255|unique:about_pages,title,' . $id,
                'slug'         => 'required|string|max:255|unique:about_pages,slug,' . $id,
                'header_id'    => 'required|exists:headers,id',
                'subheader_id' => 'nullable|exists:subheaders,id',
                'description'  => 'required|string',
                'page_image'   => 'nullable|string', // image optional on edit
                'is_active'    => 'required|in:0,1',
            ]);

            DB::beginTransaction();

            $page = AboutPage::findOrFail($id);

            // Handle image (keep old if not changed)
            $imagePath = $page->image;
            if ($request->filled('page_image')) {
                $imagePath = ltrim(
                    parse_url($request->page_image, PHP_URL_PATH),
                    '/'
                );
            }

            $page->update([
                'title'        => $validated['title'],
                'slug'         => $validated['slug'],
                'header_id'    => $validated['header_id'],
                'subheader_id' => $validated['subheader_id'] ?? null,
                'description'  => $validated['description'],
                'image'        => $imagePath,
                'status'       => $validated['is_active'],
            ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'About Page updated successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('About Page Update Error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    
    public function delete_about_page($id)
    {
        $page = AboutPage::find($id);

        if (!$page) {
            return response()->json([
                'status'  => false,
                'message' => 'Page not found'
            ], 404);
        }

        $page->is_deleted = 9;
        $page->save();

        return response()->json([
            'status'  => true,
            'message' => 'About Page deleted successfully'
        ]);
    }

    public function activate_about_page($id)
    {
        $page = AboutPage::where('id', $id)
            ->where('is_deleted', 9)
            ->first();

        if (!$page) {
            return response()->json([
                'status'  => false,
                'message' => 'Page not found'
            ], 404);
        }

        $page->is_deleted = 0;
        $page->save();

        return response()->json([
            'status'  => true,
            'message' => 'About Page activated successfully'
        ]);
    }

    public function getSubheadersByHeader($headerId)
    {
        $subheaders = SubHeader::where('header_id', $headerId)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->select('id', 'name')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $subheaders
        ]);
    }
}
