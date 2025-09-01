<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables; 

class DashboardController extends Controller
{
    public function list()
    {
        $members = DB::table('tbl_gym_members')
        ->select('*')
        ->where('is_deleted', '!=', 9)
        ->count();

        $memebership = DB::table('tbl_gym_membership')
        ->select('*')
        ->where('is_deleted', '!=', 9)
        ->count();

        $trainer = DB::table('tbl_trainer')
        ->select('*')
        ->where('is_deleted', '!=', 9)
        ->count();

        return view('dashboard.list_dashboard',compact('members','memebership','trainer'));
       
    }

    public function fetchMemberList(Request $request)
    {
        // ONE variable that fetches everything you need
        $fetch_data = DB::table('tbl_gym_members')
            ->select('id','membership_type','joining_date','expiry_date','amount_paid','payment_method','trainer_assigned');

        // Send to DataTables (server-side)
        return DataTables::of($fetch_data)
            ->addColumn('action', function ($row) {
                return '<a href="/members/edit/'.$row->id.'" class="btn btn-sm btn-primary">Edit</a>
                        <a href="/members/delete/'.$row->id.'" class="btn btn-sm btn-danger">Delete</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
