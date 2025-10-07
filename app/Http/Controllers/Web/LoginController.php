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
use Razorpay\Api\Api;
use App\Models\Payment; 
use App\Models\GymMember; 
use App\Models\UserPreference;
use App\Models\Preference;
use App\Models\Blog;
use App\Models\Gallery;

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
    
            // Get today's cumulative time (not all-time)
            $todayCumulative = UserLogin::where('user_id', $userId)
                ->whereDate('date', $currentTime->toDateString())
                ->max('cumulative_time') ?? 0;
    
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
                'cumulative_time' => $todayCumulative, // start from today's cumulative only
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
    
                // Calculate today's cumulative before update
                $todayCumulative = UserLogin::where('user_id', $userId)
                    ->whereDate('date', $currentTime->toDateString())
                    ->max('cumulative_time') ?? 0;
    
                // Update total_time and today's cumulative_time
                $loginRecord->update([
                    'log_out_time' => $currentTime,
                    'total_time' => $sessionMinutes,
                    'cumulative_time' => $todayCumulative + $sessionMinutes, // today's only
                    'status' => 0, 
                    'updated_at_by' => $userId,
                ]);
    
                return response()->json([
                    'status' => 'success', 
                    'message' => 'Logout recorded',
                    'total_time' => $sessionMinutes,
                    'cumulative_time' => $todayCumulative + $sessionMinutes
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
        $today = \Carbon\Carbon::today()->toDateString();

        $query = DB::table('tbl_user_login')
            ->where('user_id', $user->id)
            ->whereDate('date', $today) // only today's entries
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


    public function member_subscription()
    {
        $memberships = DB::table('tbl_gym_membership')
        ->where('is_active', 1)
        ->where('is_deleted', 1)
        ->orderBy('price', 'asc')
        ->get();

        // dd($memberships);

        $currentSubscription = DB::table('tbl_payments')
        ->where('user_id', Auth::id())
        ->where('status', 'success')
        ->orderBy('amount', 'desc')
        ->first();
        // dd( $currentSubscription);

        // Map facility IDs to names
        $facilityNames = [
            1 => 'Cardio',
            2 => 'Yoga',
            3 => 'Zumba',
            4 => 'Steam Bath',
            5 => 'Swimming Pool',
            6 => 'Sauna',
            // add more as needed
        ];

        return view('members.Subscriptions.member_subscription', compact('memberships','currentSubscription','facilityNames'));
 
    }
    public function createOrder(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
        $order = $api->order->create([
            'receipt'         => 'rcptid_' . time(),
            'amount'          => $request->amount * 100, // amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1
        ]);

        // Generate invoice number
        $invoiceNumber = 'MEM' . auth()->id() . '-' . rand(100, 999) . '-' . now()->format('dMMy');
    
        // Membership dates
        $membershipStart = now();
        $membershipEnd   = now()->addDays(30);
    
        
        $payment = Payment::create([
            'user_id'               => auth()->id(),
            'plan_id'               => $request->plan_id,
            'plan_name'             => $request->plan_name,
            'amount'                => $request->amount,
            'currency'              => 'INR',
            'order_id'              => $order['id'],
            'payment_status'        => 1,           // 1 = Pending
            'status'                => 'pending',   // enum tracking
            'membership_start_date' => $membershipStart,
            'membership_end_date'   => $membershipEnd,
            'invoice_number'        => $invoiceNumber,
        ]);
    
    
        return response()->json([
            'order_id' => $order['id'],
            'amount'   => $request->amount,
            'currency' => $order['currency'],
            'razorpay_key' => env('RAZORPAY_KEY'),
            'plan_name' => $request->plan_name
        ]);
    }
    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            // 1️⃣ Verify Razorpay signature
            $attributes = [
                'razorpay_order_id'   => $request->order_id,
                'razorpay_payment_id' => $request->payment_id,
                'razorpay_signature'  => $request->signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // 2️⃣ Fetch payment details from Razorpay
            $razorpayPayment = $api->payment->fetch($request->payment_id);
            $gatewayMethod   = $razorpayPayment->method ?? 'unknown';

            // 3️⃣ Update existing payment record
            $payment = Payment::where('order_id', $request->order_id)->first();

            if (!$payment) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Payment record not found'
                ]);
            }

            $payment->update([
                'payment_id'     => $request->payment_id,
                'signature'      => $request->signature,
                'gateway'        => $gatewayMethod,
                'payment_status' => 2,           // 2 = Completed
                'status'         => 'success',   // enum tracking
            ]);

            return response()->json([
                'status'  => 'success',
                'payment' => $payment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function member_my_team (Request $request)
    {
        $user = Auth::user(); 
        // dd($user);
        $loginRecord = UserLogin::where('user_id', $user->id)
        ->whereDate('date', Carbon::now()->toDateString())
        ->latest()
        ->first();
        $loginDisabled = $loginRecord && $loginRecord->status == 1; 
        $logoutDisabled = !$loginDisabled; 

        $members = GymMember::where('is_deleted', '!=', 9)->get();
        // dd($members);
    
        return view('members.Team.member_my_team', compact('loginDisabled', 'logoutDisabled','members'));

    }
    public function my_profile (Request $request, $id)
    {
        // dd(1);
        // dd($id); 
        // dd($request->all());
        $member = GymMember::where('id', $id)->first();

        // Check if member exists
        if (!$member) {
            abort(404, "Member not found");
        }
        // dd($member);
    
        return view('members.Team.my_profile', compact('member'));

    }
    // public function fetch_member_my_team(Request $request)
    // {
    //     $query = GymMember::query()->where('is_deleted', '!=', 9);

    //     // Search filter
    //     if($request->filled('search')){
    //         $search = $request->search;
    //         $query->where(function($q) use ($search){
    //             $q->where('first_name', 'like', "%$search%")
    //             ->orWhere('last_name', 'like', "%$search%");
    //         });
    //     }

    //     $perPage = $request->get('per_page', 10);
    //     $page = $request->get('page', 1);

    //     $members = $query->skip(($page-1)*$perPage)
    //                     ->take($perPage)
    //                     ->get();

    //     return response()->json([
    //         'data' => $members
    //     ]);
    // }
    public function fetch_member_my_team(Request $request)
{
    $query = GymMember::query()->where('is_deleted', '!=', 9);

    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search){
            $q->where('first_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%");
        });
    }

    $perPage = $request->get('per_page', 12);

    $members = $query->orderBy('id', 'desc')->paginate($perPage);

    return response()->json($members); // now contains all pagination info
}

    public function saveUserPreference(Request $request)
    {
        // dd(2);
        $user = Auth::user();
        $preference = Preference::where('name', $request->preference_name)->first();

        if (!$preference) {
            return response()->json(['message' => 'Preference not found'], 404);
        }

        // Save or update the user preference
        UserPreference::updateOrCreate(
            [
                'user_id' => $user->id,
                'preference_id' => $preference->id
            ],
            [
                'is_active' => $request->is_active,
                'status' => 1
            ]
        );

        return response()->json(['message' => 'Preference saved successfully']);
    }

    public function member_payments()
    {
        $memberships = DB::table('tbl_gym_membership')->pluck('membership_name', 'id');
        return view('members.Payments.payment_list', compact('memberships'));
        

    }

    public function fetch_member_payments(Request $request)
    {
        $user = Auth::user();
        $query = DB::table('tbl_payments')
        ->leftJoin('tbl_gym_membership', 'tbl_payments.plan_id', '=', 'tbl_gym_membership.id')
        ->select(
            'tbl_payments.*',
            'tbl_gym_membership.membership_name as plan_name'
        )
        ->where('tbl_payments.user_id', $user->id)
        ->orderBy('tbl_payments.created_at', 'desc');

        // Filters
        if ($request->plan_name) {
            $query->where('tbl_gym_membership.membership_name', 'like', '%' . $request->plan_name . '%');
        }
    
        if ($request->invoice_number) {
            $query->where('tbl_payments.invoice_number', 'like', '%' . $request->invoice_number . '%');
        }
    
        if ($request->amount) {
            $query->where('tbl_payments.amount', 'like', '%' . $request->amount . '%');
        }
        
    
        if($request->status){
            $query->where('status', $request->status);
        }
    
        if($request->payment_status){
            $query->where('payment_status', $request->payment_status);
        }
    
        $payments = $query->paginate(10); // pagination
    
        return response()->json($payments);
    }

    public function view_invoice(Request $request,$id)
    {
          // Fetch payment entry by ID
        $payment = DB::table('tbl_payments')
        ->leftJoin('tbl_gym_membership', 'tbl_payments.plan_id', '=', 'tbl_gym_membership.id')
        ->select(
            'tbl_payments.*',
            'tbl_gym_membership.membership_name as plan_name'
        )
        ->where('tbl_payments.id', $id)
        ->first(); 

        // dd($payment);
        if (!$payment) 
        {
            abort(404, 'Payment not found');
        }

        // Optionally, if you need all memberships
        $memberships = DB::table('tbl_gym_membership')->pluck('membership_name', 'id');

        return view('members.Payments.view_invoice', compact('payment', 'memberships'));
      
    }

    public function member_blogs()
    {
        $blogs = Blog::where('is_active', '1')
                     ->orderBy('publish_date', 'desc')
                     ->get();
        // dd($blogs);
        return view('members.blogs.blogs', compact('blogs'));
    }
    public function fetch_member_blogs(Request $request)
    {
        $blogs = Blog::where('is_active', 1)
            // ->where('is_deleted', 0)
            ->orderBy('publish_date', 'desc')
            ->paginate(6); // 6 blogs per page
    
        return response()->json($blogs);
    }
    

    public function member_gallary()
    {
        $galleries = Gallery::where('is_active', 1)
                        ->orderBy('created_at', 'desc')
                        ->get();
        // dd($galleries);

        return view('members.gallary.gallary', compact('galleries'));

    }

    public function fetch_member_gallary(Request $request)
    {
        $galleries = Gallery::where('is_active', 1)         
        ->orderBy('created_at', 'desc')
        ->paginate(6);
    
        return response()->json($galleries);
    }
    
}
