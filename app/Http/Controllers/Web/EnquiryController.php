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
use App\Mail\EnquiryReplyMail;

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
                    ->subject('Enquiry Confirmation - Brainstar Support');
        });
        return redirect()->route('home')
        ->with('success', 'Enquiry submitted successfully. A confirmation email has been sent. Your Request ID is: ' . $requestId);
    
    }

    public function list_enquiry()
    {
        return view('Enquiry.list_enquiry');
    }
    public function list_replied_enquiry()
    {
        return view('Enquiry.list_replied_enquiry');
    }
    public function fetch_enquiry(Request $request)
    {
        $query = Enquiry::where('status', "0"); 

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', $request->name . '%');
        }
    
        if ($request->filled('email')) {
            $query->where('email', 'LIKE', $request->email . '%');
        }
    
        if ($request->filled('request_id')) {
            $query->where('request_id', 'LIKE', $request->request_id . '%');
        }
    
       
        $allowedSorts = ['id', 'name', 'email', 'created_at'];
        $sort = $request->get('sort', 'id');
        $direction = $request->get('order', 'desc');
    
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'desc';
        }
    
        $query->orderBy($sort, $direction);
    
      
        $enquiries = $query->paginate(10);
    
     
        $enquiries->getCollection()->transform(function ($row) {
            $encryptedId = Crypt::encryptString($row->id);
            $row->encrypted_id = $encryptedId;
            $row->action = '
                <button type="button" class="btn btn-sm" onclick="replyEnquiryById(' . $row->id . ')">
                    <i class=" bi-reply"></i>
                </button>';
            return $row;
        });
    
        return response()->json($enquiries);
    }
    public function fetch_replied_enquiry(Request $request)
    {
       
        $query = Enquiry::where('status', "1"); 
        
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', $request->name . '%');
        }
    
        if ($request->filled('email')) {
            $query->where('email', 'LIKE', $request->email . '%');
        }
    
        if ($request->filled('request_id')) {
            $query->where('request_id', 'LIKE', $request->request_id . '%');
        }
    
       
        $allowedSorts = ['id', 'name', 'email', 'created_at'];
        $sort = $request->get('sort', 'id');
        $direction = $request->get('order', 'desc');
    
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'desc';
        }
    
        $query->orderBy($sort, $direction);
    
      
        $enquiries = $query->paginate(10);
    
     
        $enquiries->getCollection()->transform(function ($row) {
            $encryptedId = Crypt::encryptString($row->id);
            $row->encrypted_id = $encryptedId;
            $row->action = '
                <button type="button" class="btn btn-sm" onclick="replyEnquiryById(' . $row->id . ')">
                    <i class=" bi-reply"></i>
                </button>';
            return $row;
        });
    
        return response()->json($enquiries);
    }
    public function send_enquiry_reply(Request $request, $id)
    {
        // dd($id);
        // dd($request->all());
        $request->validate([
            'message' => 'required|string',
        ]);

        $enquiry = Enquiry::find($id);

        if (!$enquiry) {
            return response()->json([
                'success' => false,
                'message' => 'Enquiry not found'
            ], 404);
        }

        $enquiry->reply = $request->message;
        $enquiry->status = '1';
        $enquiry->save();

        // Send email
        Mail::to($enquiry->email)->send(new EnquiryReplyMail($enquiry));


        return response()->json([
            'success' => true,
            'message' => 'Reply sent successfully'
        ]);
    }
}
