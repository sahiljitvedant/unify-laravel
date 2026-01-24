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
use Illuminate\Validation\Rule;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Cache;
use App\Events\JobCreated;


class JobController extends Controller
{
    public function create()
    {
        return view('jobs.apply');
    }

   
    // public function store(Request $request)
    // {
    //     // dd(1);
    //     $request->validate([
    //         'job_title' => 'required|string|min:2|max:50',
    //         'experience_needed' => 'required|string|min:1|max:20',
    //         'city' => 'required|string|min:2|max:30',
    //     ]);
    
    //     JobApplication::create([
    //         'job_title' => $request->job_title,
    //         'experience_needed' => $request->experience_needed,
    //         'city' => $request->city,
    //     ]);
    
    //     return response()->json(['success' => true]);
    // }
    public function store(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string|min:2|max:50',
            'experience_needed' => 'required|string|min:1|max:20',
            'city' => 'required|string|min:2|max:30',
        ]);

        $job = JobApplication::create([
            'job_title' => $request->job_title,
            'experience_needed' => $request->experience_needed,
            'city' => $request->city,
        ]);

        // Fire event
        event(new JobCreated($job));

        return response()->json(['success' => true]);
    }

    public function index()
    {
        return view('jobs.list'); 
    }

    public function fetchJobList(Request $request)
    {
        // Unique cache key for different filters
        $cacheKey = 'job_list_' . md5(json_encode([
            'city' => $request->input('city'),
            'job_title' => $request->input('job_title'),
        ]));
    
        // Cache for 60 seconds
        $jobs = Cache::remember($cacheKey, 60, function () {
            return JobApplication::all(); // Fetch all once
        });
    
        // Filter in memory
        if ($request->filled('city')) {
            $jobs = $jobs->where('city', 'LIKE', "%{$request->city}%");
        }
    
        if ($request->filled('job_title')) {
            $jobs = $jobs->where('job_title', 'LIKE', "%{$request->job_title}%");
        }
    
        // Sort (latest first)
        $jobs = $jobs->sortByDesc('id')->values();
    
        // Optional pagination-like slicing (6 per batch)
        $page = $request->input('page', 1);
        $perPage = 6;
        $pagedJobs = $jobs->slice(($page - 1) * $perPage, $perPage)->values();
    
        return response()->json([
            'data' => $pagedJobs,
            'total' => $jobs->count(),
            'page' => (int) $page,
            'per_page' => $perPage
        ]);
    }

    public function deleteJob($id)
    {
        JobApplication::findOrFail($id)->delete();

        return response()->json(['message' => 'Job deleted successfully.']);
    }

}
