<?php


namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


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
        // dd($request);


        $request->validate
        ([
            'name' => 'required|string|max:255',
            'email' => 'required',
            'password' => 'required',
        ]);


        $user = User::create
        ([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return response()->json(['message' => 'User registered successfully!', 'user' => $user]);
    }

    public function loginPost(Request $request)
    {
        // dd($request);
        // Validate the input fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
   
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => 'success',
                'redirect' => route('add_member'),
            ]);
        }
   
        // Return JSON error response instead of redirecting
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials. Please try again.',
        ], 422);
    }
   
}
