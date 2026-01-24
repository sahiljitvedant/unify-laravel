<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; // ← Don't forget this
use App\Http\Resources\FaqResource;

class FaqApiController extends Controller
{
    public function index()
    {
        $faqs = DB::table('tbl_faqs')
        ->where('is_deleted', '!=', 9)
        ->get(); 

        return FaqResource::collection($faqs);
    }
}
