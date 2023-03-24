<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MercadoController;
use App\Http\Controllers\StripeController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SystemAddonsController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\TermsController;
use App\Http\Controllers\Admin\TimeController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\WhatsappController;
use App\Http\Controllers\Admin\VariantsController;

use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\LandingController;
use App\Http\Controllers\front\ShopOrderController;
use App\Http\Controllers\front\DocumentsController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PaymentController;


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

//Admin Route
Route::group(['prefix' => 'admin'], function () {

    Route::get('/', [LoginController::class, 'index'])->name('home');
    Route::get('/forgot-password', [LoginController::class, 'forgotpassword'])->name('admin.auth.forgotpassword');

    Route::post('/newpassword', [LoginController::class, 'new_password'])->name('admin.newpassword');

    Route::get('/register', [RegisterController::class, 'index'])->name('admin.auth.register');
    Route::get('/register/verify/email/{id}/{token}', [RegisterController::class, 'notify_email'])->name('admin.notify.email');
    Route::post('/create', [RegisterController::class, 'create'])->name('admin.create');

    Route::post('/check-admin', [LoginController::class, 'check_admin'])->name('check-admin');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/verification', function () {
        return view('admin.auth.verification');
    });

    Route::post('systemverification', [LoginController::class, 'systemverification'])->name('admin.systemverification');

    Route::group(['middleware' => 'AuthMiddleware'], function () {

        Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');
        Route::post('/changepassword', [AdminController::class, 'changepassword'])->name('changepassword');
        Route::post('/profile/edit/{id}', [AdminController::class, 'updateprofile']);

        Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
        Route::get('/transaction/add', [TransactionController::class, 'add']);
        Route::post('/transaction/store', [TransactionController::class, 'store']);
        Route::post('/transaction/edit/status', [TransactionController::class, 'status']);
        Route::get('/transaction/edit-{slug}', [TransactionController::class, 'show']);
        Route::post('/transaction/update-{slug}', [TransactionController::class, 'update']);

        Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants');
        Route::get('/restaurants/add', [RestaurantController::class, 'add']);
        Route::post('/restaurants/store', [RestaurantController::class, 'store']);
        Route::post('/restaurants/edit/status', [RestaurantController::class, 'status']);
        Route::post('/restaurants/edit/status_whatsapp', [RestaurantController::class, 'status_whatsapp']);
        Route::get('/restaurants/edit-{slug}', [RestaurantController::class, 'show']);
        Route::post('/restaurants/update-{slug}', [RestaurantController::class, 'update']);

        Route::get('/coupons', [CouponsController::class, 'index'])->name('coupons');
        Route::get('/coupons/add', [CouponsController::class, 'add']);
        Route::post('/coupons/store', [CouponsController::class, 'store']);
        Route::get('/coupons/edit-{token}', [CouponsController::class, 'show']);
        Route::post('/coupons/update-{token}', [CouponsController::class, 'update']);
        Route::post('/coupons/status/edit-{token}', [CouponsController::class, 'status']);
        
        Route::get('/payments', [PaymentsController::class, 'index'])->name('payments');
        Route::get('/payments/edit-{id}', [PaymentsController::class, 'show']);
        Route::post('/payments/update-{id}', [PaymentsController::class, 'update']);
        Route::post('/payments/edit/status', [PaymentsController::class, 'status']);
        
        Route::get('/whatsapp', [WhatsappController::class, 'index'])->name('whatsapp');
        Route::post('/whatsapp/edit/status', [WhatsappController::class, 'status']);
        Route::post('/whatsapp/delete/', [WhatsappController::class, 'delete']);

        Route::get('/plans', [PlansController::class, 'index'])->name('plans');
        Route::get('/plans', [PlansController::class, 'index'])->name('plans_admin');
        Route::get('/plans/add', [PlansController::class, 'add']);
        Route::post('/plans/store', [PlansController::class, 'store']);
        Route::post('/plans/edit/status', [PlansController::class, 'status']);
        Route::get('/plans/edit-{id}', [PlansController::class, 'show']);
        Route::post('/plans/update-{id}', [PlansController::class, 'update']);
        Route::post('/plans/del', [PlansController::class, 'del']);

        Route::get('/settings', [SettingController::class, 'show'])->name('settings');
        Route::post('/settings/update', [SettingController::class, 'update']);

        Route::get('/apps', [SystemAddonsController::class, 'index'])->name('systemaddons');
        Route::get('/createsystem-addons', [SystemAddonsController::class, 'createsystemaddons']);
        Route::post('systemaddons/store', [SystemAddonsController::class, 'store']);
        Route::post('systemaddons/list', [SystemAddonsController::class, 'list']);
        Route::post('systemaddons/update', [SystemAddonsController::class, 'update']);
        Route::post('systemaddons/order', [SystemAddonsController::class, 'order']);

        // clear-cache
        Route::get('clear-cache', function () {
            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            return redirect()->back()->with('success', trans('messages.success'));
        });

        Route::get('/notifications', [ShopOrderController::class, 'notifications'])->name('notifications');
    });
});

//Vendor Route
Route::group(['middleware' => 'VendorMiddleware', 'prefix' => 'vendor'], function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/add', [CategoryController::class, 'add']);
    Route::post('/categories/store', [CategoryController::class, 'store']);
    Route::get('/categories/edit-{slug}', [CategoryController::class, 'show']);
    Route::post('/categories/update-{slug}', [CategoryController::class, 'update']);
    Route::post('/categories/edit/featured', [CategoryController::class, 'featured']);
    Route::post('/categories/edit/status', [CategoryController::class, 'status']);
    Route::post('/categories/del', [CategoryController::class, 'del']);

    Route::get('/menus', [ItemController::class, 'index'])->name('menus');
    Route::get('/item/add', [ItemController::class, 'add']);
    Route::post('/item/store', [ItemController::class, 'store']);
    Route::get('/item/edit/{id}', [ItemController::class, 'show']);
    Route::post('/item/update-{slug}', [ItemController::class, 'update']);
    Route::post('/item/del', [ItemController::class, 'del']);

    Route::post('/extra/store', [ExtraController::class, 'store']);
    Route::post('/extra/del', [ExtraController::class, 'del']);
    Route::post('/extra/update', [ExtraController::class, 'update']);

    Route::post('/variants/store', [VariantsController::class, 'store']);
    Route::post('/variants/del', [VariantsController::class, 'del']);
    Route::post('/variants/update', [VariantsController::class, 'update']);

    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
    Route::get('/transaction/add', [TransactionController::class, 'add']);
    Route::post('/transaction/store', [TransactionController::class, 'store']);
    Route::post('/transaction/edit/status', [TransactionController::class, 'status']);
    Route::get('/transaction/edit-{slug}', [TransactionController::class, 'show']);
    Route::post('/transaction/update-{slug}', [TransactionController::class, 'update']);

    Route::get('/delivery-area', [DeliveryAreaController::class, 'index'])->name('delivery-area');
    Route::get('/delivery-area/add', [DeliveryAreaController::class, 'add']);
    Route::post('/delivery-area/store', [DeliveryAreaController::class, 'store']);
    Route::post('/delivery-area/del', [DeliveryAreaController::class, 'del']);
    Route::get('/delivery-area/edit-{slug}', [DeliveryAreaController::class, 'show']);
    Route::post('/delivery-area/update-{slug}', [DeliveryAreaController::class, 'update']);

    Route::get('/working-hours', [TimeController::class, 'index'])->name('working-hours');
    Route::post('/working-hours/edit', [TimeController::class, 'edit']);

    Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
    Route::get('/orders/invoice/{id}', [OrdersController::class, 'show']);
    Route::get('/orders/{id}/{status}', [OrdersController::class, 'update']);
    Route::get('/print/{id}', [OrdersController::class,'print']);

    Route::get('/settings', [SettingController::class, 'show'])->name('settings');
    Route::post('/settings/update', [SettingController::class, 'update']);

    Route::get('/share', [SettingController::class, 'share'])->name('share');

    Route::get('/payments', [PaymentsController::class, 'index'])->name('payments');
    Route::get('/payments/edit-{id}', [PaymentsController::class, 'show']);
    Route::post('/payments/update-{id}', [PaymentsController::class, 'update']);
    Route::post('/payments/edit/status', [PaymentsController::class, 'status']);

    Route::get('/plans', [PlansController::class, 'index'])->name('plans');
    Route::get('/plans/{id}', [PlansController::class, 'purchase'])->name('purchase');
    Route::post('/plans/order', [PlansController::class, 'order'])->name('order');
    Route::post('/plans/notify', [PlansController::class, 'notify'])->name('notify');
    Route::post('/plans/notify/reset', [PlansController::class, 'reset'])->name('reset');
    Route::get('/plans/notify/success/{token}', [PlansController::class, 'success'])->name('success');
    Route::get('/plans/cancel', [PlansController::class, 'cancel'])->name('cancel');

    Route::get('/privacypolicy', [PrivacyPolicyController::class, 'privacypolicy'])->name('privacypolicy');
    Route::post('/privacypolicy/update', [PrivacyPolicyController::class, 'update'])->name('update');

    Route::get('/terms', [TermsController::class, 'terms'])->name('terms');
    Route::post('/terms/update', [TermsController::class, 'update'])->name('update');

    Route::get('/table', [TableController::class, 'table'])->name('table');

    Route::get('/notifications', [ShopOrderController::class, 'notifications'])->name('notifications');
});

Route::group(['namespace' => "front"], function () {
    Route::get('/', [HomeController::class, 'first'])->name('front.landing.first');
    Route::get('/lojas', [HomeController::class, 'restaurants'])->name('front.restaurants');
    Route::post('/lojas/search', [HomeController::class, 'restaurants_search'])->name('front.restaurants.search');
    Route::get('/menudigital', [HomeController::class, 'landing'])->name('front.landing.index');

    Route::get('/{restaurant}', [HomeController::class, 'index'])->name('front.home');
    Route::get('/{restaurant}/product/{id}', [HomeController::class, 'show'])->name('front.home');
    Route::post('/product-details/{id}', [HomeController::class, 'details'])->name('front.details');
    Route::post('add-to-cart', [HomeController::class, 'addtocart'])->name('front.addtocart');  
    Route::get('/{restaurant}/cart', [HomeController::class, 'cart'])->name('front.cart');
    Route::post('/cart/qtyupdate', [HomeController::class, 'qtyupdate'])->name('front.qtyupdate');
    Route::post('/cart/deletecartitem', [HomeController::class, 'deletecartitem'])->name('front.deletecartitem');
    Route::post('/orders/whatsapporder', [HomeController::class, 'whatsapporder'])->name('front.whatsapporder');
    Route::post('/orders/mercado', [MercadoController::class, 'mercadoorder']);
    Route::post('/orders/mercado_save', [MercadoController::class, 'mercado_save']);

    Route::post('/orders/whatsapporder_paypal', [HomeController::class, 'whatsapporder_paypal'])->name('front.whatsapporder_paypal');
    Route::post('/orders/notify', [HomeController::class, 'notify'])->name('front.notify');
    Route::post('/orders/reset', [HomeController::class, 'reset'])->name('front.reset');
    Route::get('/orders/success/{token}', [HomeController::class, 'success'])->name('front.success');
    Route::get('/orders/cancel', [HomeController::class, 'cancel'])->name('front.cancel');

    Route::post('/orders/checkplan', [HomeController::class, 'checkplan'])->name('front.checkplan');
    Route::post('/orders/checkdata', [HomeController::class, 'checkdata'])->name('front.checkdata');
    Route::post('/orders/checkphone', [HomeController::class, 'checkphone']);
    
    Route::get('/{restaurant}/terms', [HomeController::class, 'terms'])->name('front.terms');
    Route::get('/{restaurant}/privacy-policy', [HomeController::class, 'privacy'])->name('front.privacy');
    Route::get('/{restaurant}/book', [HomeController::class, 'book'])->name('front.book');
    Route::post('/{restaurant}/tablebook', [HomeController::class, 'tablebook'])->name('front.tablebook');
    Route::get('/{restaurant}/track-order/{ordernumber}', [HomeController::class, 'trackorder'])->name('front.trackorder');
    Route::get('/{restaurant}/success', [HomeController::class, 'trackorder'])->name('front.trackorder');

    Route::get('/{restaurant}/success/{order_number}', [HomeController::class, 'ordersuccess']);

    Route::post('/order/send-whatsapp', [ShopOrderController::class, 'sendMsg'])->name('front.order.send');
    Route::post('/contact/sendMsg', [LandingController::class, 'sendMsg'])->name('front.landing.send.message');
});

Route::group(['prefix' => 'documents'], function() {
    Route::get('/index', [DocumentsController::class, 'index']);
});

Route::group(['middleware' => 'UserMiddleware', 'prefix' => "user"], function () {
    Route::get('/home', [UserController::class, 'index'])->name('user.landing.index');
    Route::post('/payment/app/notify/reset', [UserController::class, 'reset'])->name('user.notify.reset');
    Route::post('/payment/app/notify', [UserController::class, 'notify'])->name('user.notify');
    Route::get('/payment/app/notify/success/{token}', [UserController::class, 'success'])->name('user.notify.success');
    Route::post('/payment/free-plan', [UserController::class, 'purchase_free_plan'])->name('user.purchase.free');

    Route::post('/payment/create_preference', [PaymentsController::class, 'purchase_plan']);

    Route::post('/notify/monitor', [ShopOrderController::class, 'notifyMonitoring'])->name('front.notify.monitor');
    Route::post('/notify/control', [ShopOrderController::class, 'notifyControl'])->name('front.notify.control');
});