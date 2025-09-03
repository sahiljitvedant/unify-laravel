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
use App\Models\Enquiry;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{
    public function storeEnquiry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'nullable|string|max:100',
        ]);

        // Generate request_id: Name + 6 digit random
        $randomNumber = rand(100000, 999999);
        $requestId = strtolower(str_replace(' ', '', $request->name)) . $randomNumber;

        // Save enquiry
        $enquiry = Enquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'request_id' => $requestId,
        ]);

        // Send email
        Mail::send('template.enquiry', [
            'name'        => $request->name,
            'requestId'   => $requestId,
            'messageText' => $request->message, // avoid using variable name "message"
        ], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Enquiry Confirmation - Sachii Support');
        });
        return redirect()->route('home')
        ->with('success', 'Enquiry submitted successfully. A confirmation email has been sent. Your Request ID is: ' . $requestId);
    
    }
}
