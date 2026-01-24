<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TrainerStoreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrainerApiController extends Controller
{
    public function store(TrainerStoreRequest $request)
    {
        // Validated data
        $data = $request->validated();
        // dd($data);
        $data['is_deleted'] = 0;

        $id = DB::table('tbl_trainer')->insertGetId($data);
    
        return response()->json([
            'status' => true,
            'message' => 'Trainer added successfully',
            'id' => $id
        ], 201);
    }
}
