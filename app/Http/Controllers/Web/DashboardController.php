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

        $membership = DB::table('tbl_gym_membership')
        ->select('*')
        ->where('is_deleted', '!=', 9)
        ->count();

        $trainer = DB::table('tbl_trainer')
        ->select('*')
        ->where('is_deleted', '!=', 9)
        ->count();
        // Controller
        $years = DB::table('tbl_gym_members')
        ->select(DB::raw("YEAR(joining_date) as year"))
        ->where('is_deleted', '!=', 9)
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

        // Selected year (default = current year if not passed)
        $selectedYear = request()->get('year', now()->year);

        $members_data = DB::table('tbl_gym_members')
        ->select(
            DB::raw("DATE_FORMAT(joining_date, '%b') as month"), // only month
            DB::raw("COUNT(*) as total")
        )
        ->where('is_deleted', '!=', 9)
        ->whereYear('joining_date', $selectedYear)
        ->groupBy('month')
        ->orderByRaw("MIN(joining_date)")
        ->get();

        // Convert to arrays for Chart.js
        $labels = $members_data->pluck('month'); // ["Jan","Feb","Mar"]
        $values = $members_data->pluck('total');

        $memebrs_query=DB::table('tbl_gym_members')
        ->select('*')
        ->where('is_deleted', '!=', 9)
        ->get();
        // Membership type distribution
        $membership_distribution = DB::table('tbl_gym_members as gm')
        ->join('tbl_gym_membership as ms', 'gm.membership_type', '=', 'ms.id')
        ->select('ms.membership_name', DB::raw('COUNT(gm.id) as total'))
        ->where('gm.is_deleted', '!=', 9)
        ->groupBy('ms.membership_name')
        ->get();
    
            // dd($membership_distribution);
        // Labels & values for Chart.js
        $membershipLabels = $membership_distribution->pluck('membership_name'); 
        $membershipValues = $membership_distribution->pluck('total');


        return view('dashboard.list_dashboard',compact('members','membership_distribution','membershipLabels','membershipValues','memebrs_query','membership','trainer','labels','values','years','selectedYear'));
       
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
