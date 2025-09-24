<?php


namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        try {
            // Custom validation rules
            $validator = Validator::make($request->all(), [
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);
    
            if ($validator->fails()) {
                // Validation error or duplicate email → 422
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }
    
            // Create user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully!',
                'user' => $user
            ]);
    
        } catch (\Exception $e) {
            // Something went wrong → 500
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.'
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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user(); // get logged-in user

            if ($user->is_admin == 1) {
                // dd(1);
                return response()->json([
                    'status' => 'success',
                    'redirect' => route('list_dashboard'), 
                ]);
            } else {
                // dd(2);
                // redirect normal user
                return response()->json([
                    'status' => 'success',
                    'redirect' => route('member_dashboard'), 
                ]);
            }
        }

        // Return JSON error response instead of redirecting
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials. Please try again.',
        ], 422);
    }

   
}
