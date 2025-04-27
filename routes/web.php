<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
Route::get('/checkpayment', [App\Http\Controllers\WebsiteController::class, 'checkpayment'])->name('checkpayment');

Route::get('/cooperative/signup', [App\Http\Controllers\Auth\RegisterController::class, 'coop_reg'])->name('coop_reg');
Route::post('/cooperative/save_coop_reg', [App\Http\Controllers\Auth\RegisterController::class, 'save_coop_reg'])->name('save_coop_reg');
Route::get('/signup', [App\Http\Controllers\Auth\RegisterController::class, 'signup'])->name('signup');
Route::get('/signup/{slug}', [App\Http\Controllers\Auth\RegisterController::class, 'signup'])->name('signup');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'signup'])->name('signup');
Route::post('/register_user', [App\Http\Controllers\Auth\RegisterController::class, 'register_user'])->name('save_coop_reg');
Route::any('/signup_user', [App\Http\Controllers\Auth\RegisterController::class, 'signup_user'])->name('signup_user');

Route::get('/payaza/transaction-successful', [App\Http\Controllers\TransactionController::class, 'payazaVerifyPayment'])->name('payazaVerifyPayment');
Route::get('/paystack/transaction-successful', [App\Http\Controllers\TransactionController::class, 'verifyPayment'])->name('verify-payment');
Route::get('/get-plan-details/{id}', [App\Http\Controllers\PlanController::class, 'planDetails'])->name('get_plan_details_by_id');
Route::get('/test', function () {
    return view('test');
})->name('test');
Route::get('/search', [App\Http\Controllers\WebsiteController::class, 'search'])->name('index-search');
Route::get('/our-plans', [App\Http\Controllers\WebsiteController::class, 'plan'])->name('plan-page');
Route::get('/', [App\Http\Controllers\WebsiteController::class, 'index'])->name('index-page');
Route::get('/blog', [App\Http\Controllers\WebsiteController::class, 'blog'])->name('blog-page');
Route::get('/about-us', [App\Http\Controllers\WebsiteController::class, 'about'])->name('about-page');
Route::get('/contact-us', [App\Http\Controllers\WebsiteController::class, 'contact'])->name('contact-page');
Route::any('/pay-for-plan', [App\Http\Controllers\TransactionController::class, 'planPayment'])->name('pay-for-plan');
Route::post('/pay-for-dues', [App\Http\Controllers\TransactionController::class, 'duesPayment'])->name('pay-dues');
Route::post('/pay-for-anytime', [App\Http\Controllers\TransactionController::class, 'anytimePayment'])->name('pay-anytime');
Route::post('/pay-for-form', [App\Http\Controllers\TransactionController::class, 'formPayment'])->name('pay-form');
// routes/web.php
Route::get('/cooperatives-list', [App\Http\Controllers\WebsiteController::class, 'list'])->name('cooperatives.list');
Route::get('//cooperatives/{id}', [App\Http\Controllers\WebsiteController::class, 'show'])->name('cooperatives.details');
Route::get('/join/contribution/{id}', [App\Http\Controllers\WebsiteController::class, 'joinCont']);

Route::get('/home', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('home');
Auth::routes();
//Payment route 

Route::post('/checkout', [App\Http\Controllers\FundingController::class, 'checkout'])->name('checkout');
Route::any('/generateBankDetails', [App\Http\Controllers\FundingController::class, 'generateBankDetails'])->name('generateBankDetails');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/my-profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update');


    Route::get('/user/two-factor-authentication', [App\Http\Controllers\ProfileController::class, 'otp'])->name('t2fa');
    Route::get('/dashboard', [App\Http\Controllers\ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/banks', [App\Http\Controllers\ProfileController::class, 'paystackBanks'])->name('get-paystack-banks');
    Route::post('/change-file', [App\Http\Controllers\ProfileController::class, 'saveFile'])->name('save-file');
    Route::post('/verify-account', [App\Http\Controllers\ProfileController::class, 'verifyAccount'])->name('verify-account');
    Route::post('/user/verify-two-factor-authentication', [App\Http\Controllers\ProfileController::class, 'verify'])->name('verify-otp');
    Route::group(['middleware' => ['2fa']], function () {
        Route::post('/toggle-2fa', [App\Http\Controllers\ProfileController::class, 'toggleTwo'])->name('enable-2fa');
        Route::get('/join-contribution', [App\Http\Controllers\GroupController::class, 'approve'])->name('join-contribution');
        Route::get('/my-contribution', [App\Http\Controllers\GroupController::class, 'contribution'])->name('my-contribution');
        Route::get('circle-members-{uuid}', [App\Http\Controllers\GroupController::class, 'circleMembers'])->name('circle-members');

        Route::group(['middleware' => 'admin'], function () {
            Route::group(['prefix' => 'admin'], function () {
                Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('admin-home');
                Route::get('/all-transactions', [App\Http\Controllers\HomeController::class, 'alltransactions'])->name('all-transactions');
                Route::get('/my-transactions', [App\Http\Controllers\HomeController::class, 'mytransactions'])->name('my-transactions');
                Route::get('/download_member_template', [App\Http\Controllers\UserController::class, 'download_member_template'])->name('download_member_template');

                Route::group(['prefix' => 'group'], function () {
                    Route::get('/', [App\Http\Controllers\GroupController::class, 'index'])->name('admin_group_home');
                    Route::post('/create', [App\Http\Controllers\GroupController::class, 'create'])->name('admin_create_group');
                    Route::get('/members/{uuid}', [App\Http\Controllers\GroupController::class, 'view'])->name('admin_group_members');
                    Route::get('/dues/{uuid}', [App\Http\Controllers\GroupController::class, 'cDues'])->name('contribution-dues');
                    Route::get('/start-contribution', [App\Http\Controllers\GroupController::class, 'start'])->name('start-contribution');
                    Route::get('/contribution-dues', [App\Http\Controllers\GroupController::class, 'contributionPayment'])->name('admin-contribution-payment');
                    Route::get('/disburse-contribution', [App\Http\Controllers\GroupController::class, 'disburseContribution'])->name('admin-disburse-contribution');
                });


                Route::group(['prefix' => 'user'], function () {
                    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user_home');
                    Route::get('/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('delete_users');
                    Route::get('/remove_user', [App\Http\Controllers\UserController::class, 'remove_user'])->name('remove_user');
                    Route::post('/update', [App\Http\Controllers\UserController::class, 'updateUser'])->name('update_user');
                    Route::get('/details', [App\Http\Controllers\UserController::class, 'details'])->name('user_details');
                    Route::post('/create_user', [App\Http\Controllers\UserController::class, 'add'])->name('create_user');
                    Route::post('/make_admin', [App\Http\Controllers\UserController::class, 'make_admin'])->name('make_admin');
                    Route::post('/edit_user', [App\Http\Controllers\UserController::class, 'edit'])->name('edit_user');
                });

                Route::group(['prefix' => 'member'], function () {
                    Route::get('/', [App\Http\Controllers\Admin\MemberController::class, 'index'])->name('admin_member_home');
                    Route::get('/pending', [App\Http\Controllers\Admin\MemberController::class, 'pending'])->name('admin_pending_members');
                    Route::get('/details/{id}', [App\Http\Controllers\Admin\MemberController::class, 'details'])->name('admin-member-details');
                    Route::get('/transactions/{id}', [App\Http\Controllers\Admin\MemberController::class, 'transactions'])->name('admin-member-transactions');
                    Route::post('/import', [App\Http\Controllers\Admin\MemberController::class, 'import'])->name('import_member_data');
                });
                Route::group(['prefix' => 'transaction'], function () {
                    Route::get('/registration', [App\Http\Controllers\Admin\TransactionController::class, 'registration'])->name('admin.registration.transactions');
                    Route::get('/monthly_dues', [App\Http\Controllers\Admin\TransactionController::class, 'dues'])->name('admin.dues.transactions');
                    Route::get('/all', [App\Http\Controllers\Admin\TransactionController::class, 'all'])->name('admin.all.transactions');
                    Route::get('/form', [App\Http\Controllers\Admin\TransactionController::class, 'form'])->name('admin.form.transactions');
                    Route::get('/repayment', [App\Http\Controllers\Admin\TransactionController::class, 'repayment'])->name('admin.repayment.transactions');
                });

                Route::group(['prefix' => 'plan'], function () {
                    Route::get('/', [App\Http\Controllers\Admin\PlanController::class, 'index'])->name('admin.plan');
                    Route::post('/create', [App\Http\Controllers\Admin\PlanController::class, 'create'])->name('admin.create.plan');
                    Route::get('/edit', [App\Http\Controllers\Admin\PlanController::class, 'edit'])->name('admin.plan.details');
                });

                Route::group(['prefix' => 'application'], function () {
                    Route::get('/', [App\Http\Controllers\Admin\LoanController::class, 'index'])->name('admin.loan.applications');
                    Route::get('/awaiting-disbursement', [App\Http\Controllers\Admin\LoanController::class, 'awaiting'])->name('admin.awaiting.applications');
                    Route::get('/ongoing', [App\Http\Controllers\Admin\LoanController::class, 'ongoing'])->name('admin.loan.ongoing');
                    Route::get('/completed', [App\Http\Controllers\Admin\LoanController::class, 'completed'])->name('admin.loan.completed');
                    Route::get('/approve', [App\Http\Controllers\Admin\LoanController::class, 'approve'])->name('admin.approve.loan.application');
                    Route::get('/disburse', [App\Http\Controllers\Admin\LoanController::class, 'disburse'])->name('admin.disburse.loan.application');
                });

                Route::group(['prefix' => 'error'], function () {
                    Route::get('/', [App\Http\Controllers\ErrorController::class, 'index'])->name('error.log');
                });
                Route::group(['prefix' => 'activity'], function () {
                    Route::get('/', [App\Http\Controllers\ActivityController::class, 'index'])->name('activity_home');
                    Route::get('/delete', [App\Http\Controllers\ActivityController::class, 'delete'])->name('delete_activities');
                    Route::post('/update', [App\Http\Controllers\ActivityController::class, 'updateActivity'])->name('update_activities');
                    Route::get('/details', [App\Http\Controllers\ActivityController::class, 'details'])->name('activity_details');
                    Route::post('/create_activities', [App\Http\Controllers\ActivityController::class, 'add'])->name('create_activities');
                });
            });
        });
        Route::get('member/reg_fee', [App\Http\Controllers\MemberController::class, 'reg_fee'])->name('registration.fee');
        Route::group(['middleware' => 'member'], function () {
            Route::group(['prefix' => 'member', 'middleware' => 'reg_fee'], function () {
                Route::get('/', [App\Http\Controllers\MemberController::class, 'index'])->name('member_home');
                Route::get('/transactions', [App\Http\Controllers\MemberController::class, 'transactions'])->name('transactions');
                Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'profile'])->name('member-profile');
                Route::post('/update-profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('member-profile-update');

                Route::get('/automatic-payment', [App\Http\Controllers\MemberController::class, 'automaticPayment'])->name('member-automatic-payment');
                Route::get('/manual-payment', [App\Http\Controllers\MemberController::class, 'manualPayment'])->name('member-manual-payment');
                Route::get('/contribution-dues', [App\Http\Controllers\MemberController::class, 'contributionPayment'])->name('member-contribution-payment');
                Route::get('/loan-repayment', [App\Http\Controllers\MemberController::class, 'loanPayment'])->name('member-loan-payment');

                Route::group(['prefix' => 'loan'], function () {
                    Route::get('/', [App\Http\Controllers\MemberLoanController::class, 'index'])->name('loan.home');
                    Route::get('/ongoing', [App\Http\Controllers\MemberLoanController::class, 'ongoing'])->name('loan.ongoing');
                    Route::get('/completed', [App\Http\Controllers\MemberLoanController::class, 'completed'])->name('loan.completed');
                    Route::post('/apply', [App\Http\Controllers\MemberLoanController::class, 'apply'])->name('apply-loan');
                });
              
            });

        });
        Route::post('/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('user-change-password');
    });
    Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});
