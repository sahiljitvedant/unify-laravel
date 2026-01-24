<?php


namespace App\Http\Controllers;
use App\Models\User;
use App\Models\GymMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
   
    public function index()
    {
       return view('auth.login');
    }


    public function register()
    {
       return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        // dd(1);
        try {
           
            $validator = Validator::make($request->all(), [
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:tbl_users,email',
                'password' => 'required|min:6',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }
    
            // 2️⃣ Split name into first and last
            $fullName = trim($request->name);
            $nameParts = explode(' ', $fullName, 2);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
    
            // 3️⃣ Create user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password, // automatically hashed via 'hashed' cast in User model
                'is_admin'=>1
            ]);
    
            // 4️⃣ Create GymMember
            $gymMember = GymMember::create([
                'user_id'    => $user->id,
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'email'    => $request->email,
               
            ]);
    

            return response()->json([
                'status'     => 'success',
                'message'    => 'User registered successfully!',
                'user'       => $user,
                'gym_member' => $gymMember
            ]);
    
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Register Error: '.$e->getMessage());
            \Log::error($e->getTraceAsString());
    
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong. Please try again later.',
                'error'   => $e->getMessage() // optional: remove in production
            ], 500);
        }
    }
    

    public function loginPost(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) 
        {
            $user = Auth::user();

            // Get gym member record for the user
            $member = DB::table('tbl_gym_members')
                ->where('user_id', $user->id)
                ->first();

            // Check if membership is deactivated
            if ($member && $member->is_deleted == 9) 
            {
                Auth::logout();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your gym membership has been deactivated. Please contact the administrator.',
                ], 422);
            }

            // Check if admin_approved is 0 (not approved yet)
            if ($member && $member->admin_approved == 0) {
                Auth::logout(); // clear session
                return response()->json([
                    'status' => 'pending_approval',
                    'redirect' => route('account_pending_approval'),
                ]);
            }
            

            // Admin redirect
            if ($user->is_admin == 1) 
            {
                return response()->json([
                    'status' => 'success',
                    'redirect' => route('list_dashboard'), 
                ]);
            } 
            else 
            {
                // Normal user redirect
                return response()->json([
                    'status' => 'success',
                    'redirect' => route('member_dashboard'), 
                ]);
            }
        }

        // Invalid credentials
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials. Please try again.',
        ], 422);
    }


   
}
