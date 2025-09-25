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
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogin;
use Carbon\Carbon;
class LoginController extends Controller
{
    public function list()
    {
        $user = Auth::user(); 
        // dd($user);
        $loginRecord = UserLogin::where('user_id', $user->id)
        ->whereDate('date', Carbon::now()->toDateString())
        ->latest()
        ->first();
        // dd($loginRecord);
        $loginDisabled = $loginRecord && $loginRecord->status == 1; 
        $logoutDisabled = !$loginDisabled; 
    
        return view('members.Login.list', compact('loginRecord','loginDisabled', 'logoutDisabled'));
    }
 
    public function loginLogoutAction(Request $request)
    {
        $userId = $request->user_id; 
        $action = $request->action; 
        $currentTime = Carbon::now();
    
        if ($action === 'login') 
        {
            // Check today's login count
            $loginCountToday = UserLogin::where('user_id', $userId)
                ->whereDate('date', $currentTime->toDateString())
                ->count();
    
            if ($loginCountToday >= 3) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'You cannot check-in more than 3 times per day',
                    'login_count' => $loginCountToday
                ]);
            }
    
            // Fetch last cumulative time for this user
            $lastRecord = UserLogin::where('user_id', $userId)
                            ->latest()
                            ->first();
    
            $previousCumulative = $lastRecord ? $lastRecord->cumulative_time : 0;
    
            // Create a new login record
            $loginRecord = UserLogin::create([
                'user_id' => $userId,
                'date' => $currentTime->toDateString(),
                'log_in_time' => $currentTime,
                'log_out_time' => null,
                'status' => 1,
                'location' => 'Pune',
                'login_count' => $loginCountToday + 1,
                'total_time' => 0,
                'cumulative_time' => $previousCumulative, 
                'created_at_by' => $userId,
                'updated_at_by' => $userId,
            ]);
    
            return response()->json([
                'status' => 'success', 
                'message' => 'Login recorded',
                'login_count' => $loginCountToday + 1
            ]);
        } 
        else if ($action === 'logout') 
        {
            // Fetch the last active login for today
            $loginRecord = UserLogin::where('user_id', $userId)
                            ->whereDate('date', $currentTime->toDateString())
                            ->whereNotNull('log_in_time')
                            ->whereNull('log_out_time')
                            ->latest()
                            ->first();
    
            if ($loginRecord)  
            {
                // Calculate total time for this session
                $sessionMinutes = Carbon::parse($loginRecord->log_in_time)
                                    ->diffInMinutes($currentTime);
    
                // Update total_time and cumulative_time
                $loginRecord->update([
                    'log_out_time' => $currentTime,
                    'total_time' => $sessionMinutes,
                    'cumulative_time' => $loginRecord->cumulative_time + $sessionMinutes,
                    'status' => 0, 
                    'updated_at_by' => $userId,
                ]);
    
                return response()->json([
                    'status' => 'success', 
                    'message' => 'Logout recorded',
                    'total_time' => $sessionMinutes,
                    'cumulative_time' => $loginRecord->cumulative_time
                ]);
            }
    
            return response()->json([
                'status' => 'error', 
                'message' => 'No active login found'
            ]);
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid action'
            ]);
        }
    }

    public function fetchLogin(Request $request)
    {
        $user = Auth::user();

        $query = DB::table('tbl_user_login')
            ->where('user_id', $user->id)  // only current user
            ->orderBy('id', 'desc');

        // Sorting
        $allowedSorts = ['id', 'log_in_time', 'log_out_time'];
        $sort = $request->get('sort', 'id');
        $direction = $request->get('order', 'asc');

        if (!in_array($sort, $allowedSorts)) $sort = 'id';
        if (!in_array(strtolower($direction), ['asc', 'desc'])) $direction = 'asc';

        $query->orderBy($sort, $direction);

        // Pagination
        $records = $query->paginate(6);

        // Format times
        $records->getCollection()->transform(function ($row) {
            $row->log_in_time = $row->log_in_time ? \Carbon\Carbon::parse($row->log_in_time)->format('h:i A') : '-';
            $row->log_out_time = $row->log_out_time ? \Carbon\Carbon::parse($row->log_out_time)->format('h:i A') : '-';
            $row->total_time = $row->total_time ?? null;
            return $row;
        });

        return response()->json($records);
    }

    public function fetch_member_login_detail(Request $request)
    {
        $user = Auth::user();

        // Last 7 days (descending: latest date first)
        $days = 7;
        $dates = collect(range(0, $days - 1))
            ->map(fn($i) => \Carbon\Carbon::today()->subDays($i)->toDateString())
            ->values(); // today first, yesterday next, etc.

        // Subquery: get latest entry id for each date
        $latestEntries = DB::table('tbl_user_login')
            ->select(DB::raw('MAX(id) as id'))
            ->where('user_id', $user->id)
            ->whereIn('date', $dates)
            ->groupBy('date');

        // Fetch those rows
        $records = DB::table('tbl_user_login')
            ->whereIn('id', $latestEntries)
            ->get()
            ->keyBy('date');

        // Build final result
        $result = $dates->map(function ($d) use ($records) {
            $entry = $records->get($d);

            return [
                'date' => $d,
                'day'  => \Carbon\Carbon::parse($d)->format('l'),
                'cumulative_time' => $entry->cumulative_time ?? null,
            ];
        });

        return response()->json([
            'data' => $result
        ]);
    }

    public function user_login_histroy(Request $request)
    {
        $user = Auth::user();

        // Get all saved entries for this user, latest date first
        // For each date, only take the latest entry
        $records = DB::table('tbl_user_login')
            ->where('user_id', $user->id)
            ->orderBy('date', 'desc')   // latest date first
            ->orderBy('id', 'desc')     // latest entry for that date on top
            ->get()
            ->groupBy('date')           // group by date
            ->map(function ($entries) {
                // Take only the first (latest) entry for that date
                return $entries->first();
            });

        // Build final result
        $result = $records->map(function ($row) {
            return [
                'id' => $row->id,
                'date' => $row->date,
                'day' => \Carbon\Carbon::parse($row->date)->format('l'),
                'cumulative_time' => $row->cumulative_time ?? null,
            ];
        })->values(); // reset keys

        return response()->json([
            'data' => $result,
            'current_page' => 1,
            'last_page' => 1
        ]);
    }

    

    public function member_team (Request $request)
    {
        $user = Auth::user(); 
        // dd($user);
        $loginRecord = UserLogin::where('user_id', $user->id)
        ->whereDate('date', Carbon::now()->toDateString())
        ->latest()
        ->first();
        $loginDisabled = $loginRecord && $loginRecord->status == 1; 
        $logoutDisabled = !$loginDisabled; 
    
        return view('members.Team.my_team', compact('loginDisabled', 'logoutDisabled'));

    }
}
