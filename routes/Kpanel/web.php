<?php

use App\Http\Controllers\authentication\AuthenticationController;
use App\Http\Controllers\buildings\ApartmentController;
use App\Http\Controllers\buildings\BuildingsController;
use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\collective\CollectiveNotificationController;
use App\Http\Controllers\crons_jobs\CronsJobsController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\mail_template\MailTemplateController;
use App\Http\Controllers\notifications\NotificationsController;
use App\Http\Controllers\permission\PermissionController;
use App\Http\Controllers\PotentialCustomerRecordController;
use App\Http\Controllers\smstemplate\SmsTemplateController;
use App\Http\Controllers\Users\UsersController;
use App\Models\Orders;
use App\Models\permission;
use App\Models\PotentialCustomer;
use App\Models\roleslist;
use App\Models\userroles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/sign-in',[AuthenticationController::class, 'sign_in'])->name('sign_in')->middleware('guest');
Route::get('/register',[AuthenticationController::class, 'register'])->name('register')->middleware('guest');
Route::POST('/register-post',[AuthenticationController::class, 'register_post'])->name('register_post')->middleware('guest');
Route::POST('/register-post-sms',[AuthenticationController::class, 'register_post_sms'])->name('register_post_sms')->middleware('guest');
Route::post('/sign-in-post',[AuthenticationController::class, 'sign_in_post'])->name('sign_in_post')->middleware('guest');
Route::post('/sign-in-post-sms',[AuthenticationController::class, 'sign_in_post_sms'])->name('sign_in_post_sms')->middleware('guest');
Route::post('/getCustomerRegister',[AuthenticationController::class,'getCustomerRegister'])->name('getCustomerRegister');
Route::post('/register_after_login',[AuthenticationController::class,'registerAfterLogin'])->name('registerAfterLogin');
Route::POST('/getContractsCustomer',[\App\Http\Controllers\ApiController::class,'getContractsCustomer'])->name('getContractsCustomer');
Route::POST('/getCounties',[\App\Http\Controllers\ApiController::class,'getCounties'])->name('getCounties');


Route::get('/payment_success',function(Request $request){
    return view('Kpanel.credit-card-page.success');
})->name('payment_success_no_session');
Route::post('/payment_error',function(Request $request){
    if(!empty($_GET['order_number'])){
        $order = Orders::where('merchant_oid',$_GET['order_number'])->first();
        if(!empty($order)){
            $order->payment_error = $request->fail_message;
            $order->status = 3;
            $order->save();
        }
    }
    $data['fail_message'] = $request->fail_message;
    return view('Kpanel.credit-card-page.error')->with($data);
})->name('payment_error_no_session');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::middleware(['auth'])->prefix('/')->group(function () { // bunun içerisine yazdığımız bütün linkler giriş linki isteyecektir.
    Route::get('/logout',[AuthenticationController::class, 'logout'])->name('logout')->middleware('auth');
    Route::get('/', function () {
        return redirect(route('dashboard'));
    })->name('kpanel');

    Route::get('/dashboard', function () {

        return view("Kpanel.welcome");
    })->name('dashboard');

    Route::get('credit-card-list',[\App\Http\Controllers\CreditCartController::class,'CreditCardList'])->name('CreditCardList');
    Route::post('credit-card-list',[\App\Http\Controllers\CreditCartController::class,'CreditCardList'])->name('CreditCardList');

    Route::get('membership_information',[\App\Http\Controllers\MembershipInformationsController::class,'MembershipInformation'])->name('MembershipInformation');
    Route::post('membership_check',[\App\Http\Controllers\MembershipInformationsController::class,'MembershipCheck'])->name('MembershipCheck');
    Route::POST('membership_information',[\App\Http\Controllers\MembershipInformationsController::class,'MembershipInformation'])->name('MembershipInformation');
    Route::POST('membership_cancelled',[\App\Http\Controllers\MembershipInformationsController::class,'MembershipCancelled'])->name('MembershipCancelled');

    Route::get('orders',[\App\Http\Controllers\MembershipInformationsController::class,'Orders'])->name('Orders');
    Route::get('order-detail/{id}',[\App\Http\Controllers\MembershipInformationsController::class,'OrderDetail'])->name('OrderDetail');
    Route::get('personel-information',[\App\Http\Controllers\MembershipInformationsController::class,'PersonelInformation'])->name('PersonelInformation');
    Route::POST('personel_information_update',[\App\Http\Controllers\MembershipInformationsController::class,'PersonelInformationUpdate'])->name('PersonelInformationUpdate');

    Route::get('measurements',[\App\Http\Controllers\MembershipInformationsController::class,'Measurements'])->name('Measurements');
    Route::get('measurements/{id}',[\App\Http\Controllers\MembershipInformationsController::class,'MeasurementsEdit'])->name('MeasurementsEdit');


    Route::post('/save_card',[\App\Http\Controllers\PaytrController::class,'CardSave'])->name('CardSave');
    Route::post('/start_payment_package',[\App\Http\Controllers\PaytrController::class,'StartPaymentPackage'])->name('StartPaymentPackage');
    Route::post('/start_payment_cancelled_package',[\App\Http\Controllers\PaytrController::class,'StartPaymentCancelledPackage'])->name('StartPaymentCancelledPackage');
    Route::post('/card_delete',[\App\Http\Controllers\PaytrController::class,'CardDelete'])->name('CardDelete');

    Route::get('/product-list',[\App\Http\Controllers\ProductsController::class,'index'])->name('ProductsList');
    Route::get('/basket',[\App\Http\Controllers\ProductsController::class,'basket_list'])->name('BasketList');
    Route::POST('/basket-pay',[\App\Http\Controllers\PaytrController::class,'StartPaymentBasket'])->name('StartPaymentBasket');
    Route::POST('/product-basket-add',[\App\Http\Controllers\ProductsController::class,'add_basket'])->name('ProductsAdd');
    Route::POST('/product-basket-delete',[\App\Http\Controllers\ProductsController::class,'delete_basket'])->name('ProductsDelete');
    Route::POST('/product-basket-update',[\App\Http\Controllers\ProductsController::class,'update_basket'])->name('ProductsUpdate');



});


