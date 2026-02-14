<?php
namespace App\Services;

use DB;
use App\Models\GymMember;
use App\Models\Header;
use App\Models\Enquiry;
class DashboardService
{
    public function getDashboardData($selectedYear)
    {
        // 1. Total members
        $members = GymMember::with(['membership', 'user'])
            ->where('is_deleted', '!=', 9)
            ->whereHas('user', fn($q) => $q->where('is_admin', '!=', 1))
            ->count();
        // Header Count
        $activeHeaders = Header::where('is_deleted', 0)
        ->where('status', 1)
        ->count();
        // 2. Membership count
        $membership = DB::table('tbl_gym_membership')
            ->where('is_deleted', "0")
            ->count();

        // 3. Trainers
        $trainer = DB::table('tbl_trainer')
            ->where('is_deleted', '!=', 9)
            ->where('is_active', 1)
            ->count();

        // 4. Years list
        $years = DB::table('tbl_gym_members')
            ->select(DB::raw("YEAR(joining_date) as year"))
            ->where('is_deleted', '!=', 9)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // 5. Monthly data
        $members_data = DB::table('tbl_gym_members')
            ->select(DB::raw("DATE_FORMAT(joining_date, '%b') as month"), DB::raw("COUNT(*) as total"))
            ->where('is_deleted', '!=', 9)
            ->whereYear('joining_date', $selectedYear)
            ->groupBy('month')
            ->orderByRaw("MIN(joining_date)")
            ->get();

        $labels = $members_data->pluck('month');
        $values = $members_data->pluck('total');

        // 6. Members list
        $members_query = DB::table('tbl_gym_members')
            ->where('is_deleted', '!=', 9)
            ->get();

        // 7. Membership distribution
        $membership_distribution = DB::table('tbl_gym_members as gm')
            ->join('tbl_gym_membership as ms', 'gm.membership_type', '=', 'ms.id')
            ->select('ms.membership_name', DB::raw('COUNT(gm.id) as total'))
            ->where('gm.is_deleted', '!=', 9)
            ->groupBy('ms.membership_name')
            ->get();

        $membershipLabels = $membership_distribution->pluck('membership_name');
        $membershipValues = $membership_distribution->pluck('total');

        // Pending enquiries (no reply yet)
        $pendingEnquiriesCount = Enquiry::where('status', '0')->count();

        // Resolved / replied enquiries
        $repliedEnquiriesCount = Enquiry::where('status', '1')->count();

        return compact(
            'members',
            'membership',
            'trainer',
            'years',
            'labels',
            'values',
            'members_query',
            'membership_distribution',
            'membershipLabels',
            'membershipValues',
            'activeHeaders',
            'repliedEnquiriesCount',
            'pendingEnquiriesCount'
        );
    }
}