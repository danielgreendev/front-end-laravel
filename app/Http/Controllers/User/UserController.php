<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\Coupons;
use App\Models\Plans;
use App\Models\Timing;
use App\Models\Payment;
use App\Models\Settings;
use App\Models\Currency;
use App\Models\AdminTemp;
use App\Models\Transaction;
use App\Models\SystemAddons;
use Helper;

class UserPayPalData{
    public $status; 
    public $url; 
    public $user_id;
    public $name;
    public $is_free;
    public $is_plus;
    public $is_premium;
    public $is_coupon;
}

class UserController extends Controller
{

    public function index()
    {
    //     $paypal = Payment::where('restaurant', null)->where('payment_name', 'PayPal')->first();
    //     if ($paypal->environment == 0)
    //         $paypal->ifsc = "https://www.PayPal.com/cgi-bin/webscr";
    //     else
    //         $paypal->ifsc = "https://www.sandbox.PayPal.com/cgi-bin/webscr";

    //     $user = new UserPayPalData;
    //     $user->is_free = 2;
    //     $user->is_plus = 1;
    //     $user->is_premium = 1;
    //     $user->user_id = $paypal->public_key;
    //     $user->name = $paypal->secret_key;
    //     $user->is_coupon = 1;

    //     if (Auth::user()->is_approved == 1 && Auth::user()->app_payment_id == null && Auth::user()->app_purchase_date == null) {
    //         $user->is_free = 1;
    //         $user->is_plus = 1;
    //         $user->is_premium = 1;
    //     }

    //     if (Auth::user()->type != 3) {
    //         $user->status = 1;
    //         $user->is_plus = 2;
    //         if (Auth::user()->is_approved == 1) {
    //             $user->is_plus = 1;
    //         }
    //     }
    //     else {
    //         $user->status = 2;
    //         $user->is_plus = 1;
    //         $user->is_free = 2;
    //     }

    //     if (Auth::user()->plan_app == "PREMIUM" && Auth::user()->is_approved == 2) {
    //         $user->is_plus = 2;
    //         $user->is_premium = 2;
    //         $paypal->ifsc = '#';
    //     }

    //     if (Auth::user()->plan_app == "PLUS" && Auth::user()->is_approved == 2) {
    //         $user->is_free = 2;
    //         $user->is_plus = 2;
    //         $paypal->ifsc = '#';
    //     }

    //     if (Auth::user()->plan == "EXPERT" && Auth::user()->is_approved == 2)
    //     {
    //         $user->is_plus = 2;
    //         $user->is_premium = 2;
    //         $paypal->ifsc = '#';   
    //     }

    //     if (Auth::user()->is_approved == 1)
    //     {
    //         $user->is_plus = 1;
    //         $user->is_premium = 1;
    //     }

    //     if (Auth::user()->type == 1) {
    //         $user->is_plus = 2;
    //         $user->is_premium = 2;
    //     }

    //     $user->url = $paypal->ifsc;

    //     $date = date("Y-m-d");

    //     $transaction = Transaction::select('coupon_id', DB::raw('count(*) as sold'))->where('coupon_id', '!=', null)->groupBy('coupon_id');

    //     $coupons = Coupons::where('restaurant', 1)->where('status', 2)->whereDate('active_from', '<=', $date)->whereDate('active_to', '>=', $date)->joinSub($transaction, 'transaction', function($join) {
    //       $join->on('id', '=', 'transaction.coupon_id');
    //       $join->on('limit', '>', 'transaction.sold');
    //     })->get();

    //     if ($coupons != null) {
    //         $user->is_coupon = 2;
    //     }

    //     return view('user.landing.index', compact('user'));
    }

    public function purchase_free_plan(Request $request)
    {
        if ($request->plan != 'free') {
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);
        }

        User::where('email', Auth::user()->email)
            ->update([
                'is_approved'=> 2,
                'app_payment_id'=> hash('ripemd160', rand().'free'.date("Y-m-d h:i:sa")),
                'app_purchase_date'=> date("Y-m-d h:i:sa"),
            ]);

        return response()->json(['status' => 1, 'message' => 'success'], 200);
    }

    public function reset(Request $request)
    {
        $plan = Plans::where('is_deleted', 2)->where('type', 2)->where('name', $request->plan)->first();

        if ($plan == null)
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

        $payment = Payment::where('restaurant', null)->where('payment_name', 'PayPal')->where('public_key', $request->business)->first();

        if ($payment == null) {
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);
        }

        $user = User::where('name', $request->payer_name)->where('email', $request->payer_email)->first();

        if ($user == null || $request->no_shopping != 1) {
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);
        }

        $currency = Currency::where('name', $request->currency_code)->first();

        if ($currency == null) {
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);
        }

        if ($request->cmd != '_xclick-subscriptions' || $request->t3 != 'M' || $request->p3 != 1 || $request->src != 1) {
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);
        }

        $amount = $plan->price;

        $payment_id = 0;
        $date = date("Y-m-d h:i:sa");

        $coupons = Coupons::where('type', 1)->where('status', 2)->whereDate('active_from', '<=', date("Y-m-d"))->whereDate('active_to', '>=', date("Y-m-d"))->where('code', $request->couponcode)->first();

        if ($coupons != null) {
            $count = Transaction::select('coupon_id', DB::raw('count(*) as sold'))->where('coupon_id', $coupons->id)->count();

            if ($coupons->limit > $count)
                $amount = $coupons->price;
        } 

        $temp = new AdminTemp;
        $temp->payment_id = hash('sha1', rand().$date.$request->email.rand());
        $temp->business = $request->business;
        $temp->payer_id = $user->id;
        $temp->amount = $amount;
        if ($coupons != null)
            $temp->coupon_id = $coupons->id;
        $temp->currency_id = $currency->id;
        $temp->plan_id = $plan->id;
        $temp->timestamp = hash('ripemd320', rand().$temp->amount.rand().$temp->payment_id);
        $temp->is_deleted = 2;
        $temp->save();

        $token = base64_encode(hash('crc32', $date).$temp->timestamp.hash('md5', $date.$temp->amount));

        $notify_url = URL::to('/user/payment/app/notify');
        $cancel_return = URL::to('/user/home');
        $return_pay = URL::to('/user/payment/app/notify/success/');

        $return_pay .= '/'.$token;
        $payment_id = $temp->payment_id;

        $message = array(
            'url' => $return_pay,
            'id' => $payment_id,
            'notify' => $notify_url,
            'cancel' => $cancel_return,
            'amount' => $amount
        );

        return response()->json(['status' => 1, 'message' => json_encode($message)], 200);
    }

    public function notify() {

    }

    public function success($token) {

        $token = base64_decode($token);

        $token = substr($token, 8, -32);

        $temp = AdminTemp::where('timestamp', $token)->where('is_deleted', 2)->first();

        if ($temp == null) {
            return redirect(route('user.landing.index'))->with('error', trans('messages.payment_error'));
        }

        AdminTemp::where('id', $temp->id)
            ->update([
                'is_deleted' => 1
            ]);

        $plan = Plans::where('type', 2)->where('id', $temp->plan_id)->first();

        $transaction = new Transaction;

        $date = date("Y-m-d h:i:sa");

        $transaction->restaurant = Auth::user()->id;
        $transaction->plan = $plan->name;
        $transaction->coupon_id = @$temp->coupon_id;
        $transaction->amount = $plan->price;
        $transaction->payment_type = 'PayPal';
        $transaction->payment_id = @$temp->payment_id;
        $transaction->date = $date;
        $transaction->status = 2;
        $transaction->plan_period = $plan->plan_period;
        $transaction->save();

        AdminTemp::where('is_deleted', 2)->whereDate('created_at', '<=', now()->subDays(1))
            ->update([
                'is_deleted' => 1,
            ]);

        User::where('id', Auth::user()->id)
            ->update([
                'app_payment_id' => @$temp->payment_id,
                'plan_app' => $plan->name,
                'is_approved' => 2,
                'app_purchase_date' => $date
            ]);

        $user = User::where('id', Auth::user()->id)->first();

        if ($user->type == 2) {
            return redirect(route('user.landing.index'))->with('success', trans('messages.success_premium'));
        }

        // if ($plan->name != "PREMIUM") {
        //     return redirect(route('user.landing.index'))->with('success', trans('messages.success'));
        // }

        $restaurant = Auth::user()->id;

        $days = [ "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" ];

        foreach ($days as $day) {
            $timedata = new Timing;
            $timedata->restaurant =$restaurant;
            $timedata->day =$day;
            $timedata->open_time ='12:00am';
            $timedata->close_time ='11:59pm';
            $timedata->is_always_close ='2';
            $timedata->save();
        }

        $check = SystemAddons::where('unique_identifier', 'payment')->first();

        $paymentlist = Payment::where('restaurant', null)->where('account_number', null)->get();

        foreach ($paymentlist as $payment) {
            $gateway = new Payment;
            $gateway->restaurant = $restaurant;
            $gateway->payment_name = $payment->payment_name;
            $gateway->public_key = NULL;
            $gateway->secret_key = NULL;
            $gateway->encryption_key = NULL;
            $gateway->environment = '1';
            $gateway->status = $payment->status;
            $gateway->_id = hash('sha512', $restaurant.rand().$date);
            $gateway->save();
        }

            $rec = Settings::where('restaurant','1')->first();

            date_default_timezone_set($rec->timezone);

            $data = new Settings;
            $data->restaurant = $restaurant;
            $data->currency = $rec->currency;
            $data->currency_position = $rec->currency_position;
            $data->timezone = $rec->timezone;
            $data->address = "Endereço completo";
            $data->country_code = '+55';
            $data->contact = "Prefixo + nº";
            $data->email = "Informe seu email";
            $data->description = "Faça uma descrição do negócio";
            $data->copyright = $rec->copyright;
            $data->website_title = "Insira o nome da loja";
            $data->meta_title = "Insira o nome da loja";
            $data->meta_description = "Faça uma descrição do negócio";
            $data->facebook_link = "Insira o link da sua pagina do face";
            $data->linkedin_link = "Insira o link da sua pagina do twitter";
            $data->instagram_link = "Insira o link da sua pagina do insta";
            $data->twitter_link = "Insira o link da sua pagina do linkedin";
            $data->delivery_type = "both";
            $data->item_message = "🔵 {qty} X {item_name} {variantsdata} - {item_price}";
            $data->whatsapp_message = "Olá, 

Eu gostaria de confirmar meu pedido 👇

*{delivery_type}* Nº do Pedido: {order_no}
---------------------------
{item_variable}
---------------------------

👉Taxa de Entrega : {delivery_charge}

👉Desconto : - {discount_amount}
---------------------------

📃 Total : {grand_total}
---------------------------

📄 Observação : {notes}

✅ Informação do Cliente



Nome do cliente : {customer_name}

Celular do cliente : {customer_mobile}

📍 Detalhes da Entrega



Endereço : {address}, {building}, {landmark}
---------------------------

💳 Forma de pagamento :
{payment_type}
{store_name} Agradece a preferência.

Acompanhe seu pedido por aqui 👇

{track_order_url}

Clique aqui fazer um novo pedido 👇

{store_url}";

            $data->save();

        if ($user->type == 3)
            User::where('id', Auth::user()->id)
                ->update([
                    'type' => 2,
                ]);

        return redirect(route('user.landing.index'))->with('success', trans('messages.success_premium'));
    }
    
    public function logout() {
        Auth::logout();
        session()->flush();
        return redirect()->route('home');
    }

    public function new_password(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ],  [
            'email.required' => trans('messages.email_required'),
            'email.email' => trans('messages.valid_email'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $checkadmin = User::where('email', $request->email)->where('type', 2)->first();
            if (!empty($checkadmin)) {
                $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
                $pass = Helper::send_pass($checkadmin->email, $checkadmin->name, $password, $checkadmin->id);
                if ($pass == 1) {
                    $checkadmin->password = Hash::make($password);
                    $checkadmin->save();
                    return redirect('admin')->with('success', trans('messages.password_sent'));
                } else {
                    return redirect()->back()->with('error', trans('messages.email_error'));
                }
            } else {
                return redirect()->back()->with('error', trans('messages.invalid_email'));
            }
        }
    }
}
