<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogApiController extends Controller
{
    public function show($id)
    {
        // dd($id);
        $blog = DB::table('tbl_blogs')
            ->where('id', $id)
            ->select('blog_title', 'publish_date')  
            // ->where('is_deleted', '0')
            ->first();

        if (!$blog) 
        {
            return response()->json
            ([
                'status' => false,
                'message' => 'Blog not found'
            ], 404);
        }

        return response()->json
        ([
            'status' => true,
            'data' => $blog
        ]);
    }
}
