<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\GymPackageController;
use App\Http\Controllers\Web\GymMembershipController;
use App\Http\Controllers\Web\FAQController;
use App\Http\Controllers\Web\CompanyController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\TrainerController;
use App\Http\Controllers\Web\PolicyController;
use App\Http\Controllers\Web\EnquiryController;
use App\Http\Controllers\Web\BlogsController;
use App\Http\Controllers\Web\GallaryController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\LoginController;
Route::get('', function () {
    return view('front.index');
})->name('home');
Route::get('/about_us', function () {
    return view('front.about_us');
})->name('about_us');
// Route::get('/blogs', function () {
//     return view('front.blogs');
// })->name('blogs');
Route::get('/', [BlogsController::class, 'home'])->name('home');
Route::get('/blogs', [BlogsController::class, 'blogs'])->name('blogs');
Route::get('/blogs_read_more/{id}', [BlogsController::class, 'blogs_read_more'])->name('blogs_read_more');

Route::get('/faqs', [FAQController::class, 'faq'])->name('faqs');

Route::get('/privacy_policy', [PolicyController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/gallary', [GallaryController::class, 'show_front'])->name('gallary');
Route::get('/gallary_details/{id}', [GallaryController::class, 'gallary_details'])->name('gallary_details');
// Route::get('/blogs_read_more', function () 
// {
//     return view('front.blogs_read_more');
// })->name('blogs_read_more');
Route::get('/register', [AuthController::class, 'register'])->name('register_get');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register_post');
Route::get('/login', [AuthController::class, 'index'])->name('login_get');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login_post');
Route::post('/enquiry', [EnquiryController::class, 'storeEnquiry'])->name('enquiry.store');

Route::get('/logout', function ()
{
    Auth::logout();
    return redirect()->route('login_get')->with('success', 'Logged out successfully.');
})->name('logout');


Route::get('/access-denied', function () {
    return view('access_denied');
})->name('access_denied');

Route::get('/view_invoice/{encryptedId}', [LoginController::class, 'view_invoice'])
    ->name('view_invoice');
Route::get('/no_internet', function() {
    return view('no_network');
})->name('no_internet');

// web.php
Route::post('/profile/crop-upload', [ProfileController::class, 'cropUpload'])->name('profile.cropUpload');
Route::middleware(['auth.custom', 'session.timeout','auth.admin'])->group(function () 
{
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'list'])->name('list_dashboard');
    // Edit Admin:-
    Route::get('/edit_admin/{id}', [ProfileController::class, 'edit_admin'])->name('edit_admin');
    // Members Route:-
    Route::get('/list_member', [GymPackageController::class, 'list'])->name('list_member');

    
    Route::get('/list_deleted_member', [GymPackageController::class, 'list_deleted_member'])->name('list_deleted_member');
    Route::get('/list_payment', [GymPackageController::class, 'list_payment'])->name('list_payment');
    Route::get('/member_payment/{id}', [GymPackageController::class, 'member_payment'])->name('member_payment');
    Route::get('/add_member', [GymPackageController::class, 'add'])->name('add_member');
    Route::get('/edit_members/{id}', [GymPackageController::class, 'edit_admin'])->name('edit_admin_member');
    Route::get('/add_member_payment/{id}', [GymPackageController::class, 'add_member_payment'])->name('add_member_payment');
    Route::get('/view_admin_invoice/{encryptedId}', [GymPackageController::class, 'view_admin_invoice'])
    ->name('view_admin_invoice');

    Route::get('/change_member_password/{id}', [GymPackageController::class, 'change_member_password'])->name('change_member_password');

    //Enquiry
    Route::get('/list_enquiry', [EnquiryController::class, 'list_enquiry'])->name('list_enquiry'); 
    Route::get('/list_replied_enquiry', [EnquiryController::class, 'list_replied_enquiry'])->name('list_replied_enquiry'); 



    // Membersip Route:-
    Route::get('/list_membership', [GymMembershipController::class, 'list'])->name('list_membership');
    Route::get('/add_membership', [GymMembershipController::class, 'add'])->name('add_membership');
    Route::get('/edit_membership/{id}', [GymMembershipController::class, 'edit'])->name('edit_membership');
    Route::get('/list_deleted_membership', [GymMembershipController::class, 'list_deleted_membership'])->name('list_deleted_membership');
    
    // Trainer Route:-
    Route::get('/list_trainer', [TrainerController::class, 'list'])->name('list_trainer');
    Route::get('/add_trainer', [TrainerController::class, 'add'])->name('add_trainer');
    Route::get('/edit_trainer/{id}', [TrainerController::class, 'edit'])->name('edit_trainer');
    Route::get('/list_deleted_trainer', [TrainerController::class, 'list_deleted_trainer'])->name('list_deleted_trainer');
    
    // FAQ Route:-

    Route::get('/list_faqs', [FAQController::class, 'list'])->name('list_faqs');
    Route::get('/add_faq', [FAQController::class, 'add'])->name('add_faq');
    Route::get('/edit_faq/{id}', [FAQController::class, 'edit'])->name('edit_faq');
    Route::get('/list_deleted_faqs', [FAQController::class, 'list_deleted_faqs'])->name('list_deleted_faqs');
        
    // Policy route:-
    Route::get('/add_policy', [PolicyController::class, 'add'])->name('add_policy');

    // Blogs route:-
    Route::get('/list_blogs', [BlogsController::class, 'list'])->name('list_blogs');
    Route::get('/add_blogs', [BlogsController::class, 'add'])->name('add_blogs');
    Route::get('/edit_blogs/{id}', [BlogsController::class, 'edit'])->name('edit_blogs');
    Route::get('/list_deleted_blogs', [BlogsController::class, 'list_deleted_blogs'])->name('list_deleted_blogs');
        
    // Blogs route:-
    // Route::get('/list_faqs', [FAQController::class, 'list'])->name('list_faqs');
    // Route::get('/add_faqs', [BlogsController::class, 'add'])->name('add_faqs');
    // Route::get('/edit_faqs/{id}', [BlogsController::class, 'edit'])->name('edit_faqs');
    // Route::get('/list_deleted_faqs', [BlogsController::class, 'list_deleted_faqs'])->name('list_deleted_faqs');

    // Gallary Route:-
    Route::get('/list_gallery', [GallaryController::class, 'list'])->name('list_gallery');
    Route::get('/add_gallery', [GallaryController::class, 'add'])->name('add_gallery');
    Route::get('/edit_gallery/{id}', [GallaryController::class, 'edit'])->name('edit_gallery');
    Route::get('/add_company', [CompanyController::class, 'add'])->name('add_company');
    Route::get('/list_company', [CompanyController::class, 'list'])->name('list_company');
    Route::get('/edit_company/{id}', [CompanyController::class, 'edit'])->name('edit_company');
    Route::get('/list_deleted_gallery', [GallaryController::class, 'list_deleted_gallery'])->name('list_deleted_gallery');

    Route::get('/get_membership_name', [GymMembershipController::class, 'get_membership_name'])
    ->name('get_membership_name');
   
    Route::middleware(['web'])->group(function () 
    {
        Route::post('/update_member_password/{id}', [GymPackageController::class, 'update_member_password'])->name('update_member_password');
        Route::post('/stepper-submit', [GymPackageController::class, 'submit'])->name('stepper.submit');
        Route::post('/stepper_update_setings/{id}', [GymPackageController::class, 'update_setings'])->name('stepper.update_setings');
        Route::post('/stepper-update/{id}', [GymPackageController::class, 'update'])->name('stepper.update');
        Route::get('/members/deleted/fetch', [GymPackageController::class, 'fetchDeletedMemberList'])
        ->name('fetch_deleted_member_list');
        Route::post('/activate_member/{id}', [GymPackageController::class, 'activate_member'])->name('activate_member');
        Route::get('/members/fetch', [GymPackageController::class, 'fetchMemberList'])
        ->name('fetch_member_list');
        Route::get('/fetch_member_list_pending_payment', [GymPackageController::class, 'fetch_member_list_pending_payment'])
        ->name('fetch_member_list_pending_payment');
        Route::post('/delete_members/{id}', [GymPackageController::class, 'delete_members'])->name('delete_members');
        Route::get('/fetch_member_payment/{id}', [GymPackageController::class, 'fetch_member_payment'])
        ->name('fetch_member_payment');
        Route::post('/submit_member_payment/{id}', [GymPackageController::class, 'submit_member_payment'])->name('submit_member_payment');
        Route::get('/get_remaining_balance', [GymPackageController::class, 'getRemainingBalance'])
        ->name('get_remaining_balance');

        Route::post('/import_members', [GymPackageController::class, 'import_members'])->name('import_members');
        
        // Edit Admin:-
        Route::post('/update_admin_profile/{id}', [ProfileController::class, 'update_admin_profile'])->name('update_admin_profile');
        // Enquiry Route:-
        Route::get('/fetch_enquiry', [EnquiryController::class, 'fetch_enquiry'])
        ->name('fetch_enquiry');
        Route::get('/fetch_replied_enquiry', [EnquiryController::class, 'fetch_replied_enquiry'])
        ->name('fetch_replied_enquiry');
        Route::post('/send_enquiry_reply/{id}', [EnquiryController::class, 'send_enquiry_reply'])->name('send_enquiry_reply');


        // Memebrship Routes:-
        Route::post('/add_membership', [GymMembershipController::class, 'submit'])->name('add_membership');
        Route::get('/fetch_membership', [GymMembershipController::class, 'fetchMembership'])
        ->name('fetch_membership');
        Route::post('/delete_membership/{id}', [GymMembershipController::class, 'deleteMembership'])->name('delete_membership');
        Route::post('/update_membership/{id}', [GymMembershipController::class, 'update'])->name('update_membership');
        Route::get('/fetch_deleted_membership', [GymMembershipController::class, 'fetch_deleted_membership'])
        ->name('fetch_deleted_membership');
        Route::post('/activate_membership/{id}', [GymMembershipController::class, 'activate_membership'])->name('activate_membership');

        Route::post('/add_trainer', [TrainerController::class, 'submit'])->name('add_trainer');
        Route::get('/fetch_trainer', [TrainerController::class, 'fetch_trainer_list'])
        ->name('fetch_trainer_list');
        Route::post('/delete_trainer/{id}', [TrainerController::class, 'deleteTrainer'])->name('delete_trainer');
        Route::get('/fetch_deleted_trainer', [TrainerController::class, 'fetch_deleted_trainer'])
        ->name('fetch_deleted_trainer');
        Route::post('/activate_trainer/{id}', [TrainerController::class, 'activate_trainer'])->name('activate_trainer');
        Route::post('/update_trainer/{id}', [TrainerController::class, 'update'])->name('update_trainer');
       
        // Policy
        Route::post('/add_policy', [PolicyController::class, 'submit'])->name('add_policy');
        // Blogs
        
        Route::post('/add_blogs', [BlogsController::class, 'submit'])->name('add_blogs');
        Route::get('/fetch_blogs', [BlogsController::class, 'fetch_blogs'])
        ->name('fetch_blogs');
        Route::post('/update_blogs/{id}', [BlogsController::class, 'update'])->name('update_blogs');
        Route::post('/delete_blogs/{id}', [BlogsController::class, 'delete_blogs'])->name('delete_blogs');
        Route::get('/fetch_deleted_blogs', [BlogsController::class, 'fetch_deleted_blogs'])
        ->name('fetch_deleted_blogs');
        Route::post('/activate_blogs/{id}', [BlogsController::class, 'activate_blogs'])->name('activate_blogs');
        // FAQ
        Route::get('/fetch_faqs', [FAQController::class, 'fetch_faqs'])->name('fetch_faqs');
        Route::post('/add_faq', [FAQController::class, 'submit'])->name('add_faq');
        Route::post('/delete_faqs/{id}', [FAQController::class, 'delete_faqs'])->name('delete_faqs');
        Route::post('/update_faqs/{id}', [FAQController::class, 'update_faqs'])->name('update_faqs');
        Route::get('/fetch_deleted_faqs', [FAQController::class, 'fetch_deleted_faqs'])->name('fetch_deleted_faqs');
        Route::post('/activate_faqs/{id}', [FAQController::class, 'activate_faqs'])->name('activate_faqs');
        // Gallary:-
        Route::get('/fetch_gallery', [GallaryController::class, 'fetch_gallery'])->name('fetch_gallery');
        Route::post('/add_gallery', [GallaryController::class, 'submit'])->name('add_gallery');
        Route::post('/add_gallery', [GallaryController::class, 'submit'])->name('add_gallery');
        Route::post('/gallery_update/{id}', [GallaryController::class, 'update'])->name('update_gallery');
        Route::post('/delete_gallery/{id}', [GallaryController::class, 'delete_gallery'])->name('delete_gallery');
        Route::get('/fetch_list_deleted_gallery', [GallaryController::class, 'fetch_list_deleted_gallery'])->name('fetch_list_deleted_gallery');
        Route::post('/activate_gallary/{id}', [GallaryController::class, 'activate_gallary'])->name('activate_gallary');

        Route::post('/create_company', [CompanyController::class, 'create_company'])->name('create_company');
        Route::get('/fetch_comapny_list', [CompanyController::class, 'fetch_comapny_list'])
        ->name('fetch_comapny_list');
        Route::post('/delete_company/{id}', [CompanyController::class, 'delete_comapny'])->name('delete_company');
        Route::post('/update_home_profile/{id}', [CompanyController::class, 'update_home_profile'])->name('update_home_profile');
        Route::post('/update_company_profile/{id}', [CompanyController::class, 'update_company_profile'])->name('update_company_profile');
    });
});
Route::middleware(['auth.custom', 'session.timeout','auth.member'])->group(function () 
{

    Route::get('/edit_member/{id}', [GymPackageController::class, 'edit'])->name('edit_member');
    // Dashboard
    Route::get('/member_dashboard', [DashboardController::class, 'list_member'])->name('member_dashboard');
    //Member Login functionality:-   
    Route::get('/member_login', [LoginController::class, 'list'])->name('member_login');
    Route::get('/member_working_history', [LoginController::class, 'member_team'])->name('member_working_history');
    Route::get('/member_subscription', [LoginController::class, 'member_subscription'])->name('member_subscription');
    Route::post('/create-order', [LoginController::class, 'createOrder'])->name('razorpay.create.order');
    Route::post('/payment/order', [LoginController::class, 'createOrder'])->name('payment.create');
    Route::post('/payment/verify', [LoginController::class, 'verifyPayment'])->name('payment.verify');
    Route::get('/member_my_team', [LoginController::class, 'member_my_team'])->name('member_my_team');
    Route::get('/my_team/{id}', [LoginController::class, 'my_profile'])->name('my_profile');
    Route::get('/member_payments', [LoginController::class, 'member_payments'])->name('member_payments');

    Route::get('/member_blogs', [LoginController::class, 'member_blogs'])->name('member_blogs');
    Route::get('/member_blogs_details/{id}', [LoginController::class, 'member_blogs_details'])->name('member_blogs_details');
    Route::get('/member_gallary', [LoginController::class, 'member_gallary'])->name('member_gallary');
    Route::get('/member_gallary/{id}', [LoginController::class, 'member_gallary_namewise'])->name('member_gallary_namewise');
    // API Routes:-
    Route::get('/fetch_member_my_team', [LoginController::class, 'fetch_member_my_team'])->name('fetch_member_my_team');
    Route::get('/fetch_member_login', [LoginController::class, 'fetchLogin'])->name('fetch_member_login');
    Route::get('/fetch_member_login_detail', [LoginController::class, 'fetch_member_login_detail'])->name('fetch_member_login_detail');
    Route::get('/user_login_histroy', [LoginController::class, 'user_login_histroy'])->name('user_login_histroy');

    Route::post('/member_login_action', [LoginController::class, 'loginLogoutAction'])->name('member_login_action');
    Route::get('/fetch_member_payments', [LoginController::class, 'fetch_member_payments'])->name('fetch_member_payments');



    Route::post('/stepper_update_profile/{id}', [GymPackageController::class, 'update_profile'])->name('stepper.update_profile');
   
    Route::post('/save-user-preference', [LoginController::class, 'saveUserPreference'])->name('save_user_preference');
    Route::get('/fetch_member_blogs', [LoginController::class, 'fetch_member_blogs'])->name('fetch_member_blogs');
    Route::get('/fetch_member_gallary', [LoginController::class, 'fetch_member_gallary'])->name('fetch_member_gallary');
});

Route::get('/debug-log', function () {
    return nl2br(file_get_contents(storage_path('logs/laravel.log')));
});
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'DB connection OK';
    } catch (\Exception $e) {
        return 'DB connection failed: ' . $e->getMessage();
    }
});

use Illuminate\Support\Facades\Log;
Route::get('/test-log', function () {
    Log::info('Daily log test working!');
    return 'Log written';
});
