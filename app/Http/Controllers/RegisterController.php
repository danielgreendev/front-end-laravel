<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

use App\Models\Info;
use App\Models\User;
use App\Models\Settings;
use App\Models\Timing;
use App\Models\Payment;
use App\Models\TempRegister;
use App\Models\SystemAddons;

use App\Rules\PhoneNumber;

use App\Service\Twilio\PhoneNumberLookupService;

use Str;

class RegisterController extends Controller
{
    public function show(Request $request)
    {
        $info = Info::where('type', 'twilio')->first();

        $lookupService = new PhoneNumberLookupService(
            $info->t_auth_sid,
            $info->t_auth_token
        );

        $validated = $request->validate([
            'mobile' => [
                'required', 
                'string', 
                new PhoneNumber($lookupService)
            ],
        ]);
    }

    public function index()
    {
        return view('admin.auth.register_');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:10',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,mobile',
            'password' => 'required|min:8',
        ],[ 
            "name.required"=>trans('messages.user_name_required'),
            "name.min" => trans("messages.user_name_min"),
            "email.required"=>trans('messages.email_required'),
            "email.email"=>trans('messages.valid_email'),
            "email.unique"=>trans('messages.email_exist'),
            "mobile.required"=>trans('messages.mobile_required'),
            "mobile.unique"=>trans('messages.mobile_exist'),
            'password.required' => trans('messages.password_required'),
            'password.min' => trans('messages.password_min'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {
                $this->show($request);
            }
            catch(Exception $ex) {
                $validator['mobile'] = 1;
                return redirect()->back()->withErrors($validator)->withInput();
            }

            //$date = date("Y-m-d h:i:sa");

            // $temp_user = new TempRegister;
            // $temp_user->name = $request->name;
            // $temp_user->email = $request->email;
            // $temp_user->mobile = $request->mobile;
            // $temp_user->is_verified = 1;
            // $temp_user->is_deleted = 2;
            // $temp_user->timestamp = hash('sha384', rand().$date.$request->mobile);
            // $temp_user->save();

            // $token = base64_encode(hash('md5', $date.$temp_user->name).$temp_user->timestamp.rand());
            // $token_id = hash('sha256', $temp_user->created_at).rand();
            // $emailTo = 'businessxfreeman@gamil.com';
            // $subject = 'Oneoutlet.site';
            // $message = URL::to('/admin/register/verify/email/').'/'.$token_id.'/'.$token;
            //mail($emailTo, $subject, $message);

            $check = User::where('slug',Str::slug($request->name, '-'))->first();
            if($check != ""){
                $last = User::select('id')->orderByDesc('id')->first();
                $slug = Str::slug($request->name." ".($last->id+1),'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }

            $rec = Settings::where('restaurant','1')->first();

            date_default_timezone_set($rec->timezone);

            $date = date("Y-m-d h:i:sa");
            
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = hash::make($request->password);
            $user->country_code = '+55';
            $user->mobile = $request->phone;
            $user->token = hash('sha512', $request->name.$date.$request->email).hash('md5', $slug);
            $user->avatar = "1.png";
            $user->image = "default-logo.png";
            $user->slug = $slug;
            $user->login_type = "email";
            $user->type = 3;
            $user->is_verified = 2;
            $user->is_available = 1;
            $user->is_approved = 2;
            $user->app_payment_id = hash('ripemd160', rand().'free'.date("Y-m-d h:i:sa"));
            $user->app_purchase_date = date("Y-m-d h:i:sa");
            $user->app_token = rand().hash('sha384', $request->name.$date.$request->email.rand()).rand();
            $user->save();

            /*$restaurant = \DB::getPdo()->lastInsertId();

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

            $paymentlist = Payment::select('payment_name')->where('restaurant', null)->where('account_number', null)->get();

            foreach ($paymentlist as $payment) {
                $gateway = new Payment;
                $gateway->restaurant = $restaurant;
                $gateway->payment_name = $payment->payment_name;
                $gateway->public_key = NULL;
                $gateway->secret_key = NULL;
                $gateway->encryption_key = NULL;
                $gateway->environment = '1';
                $gateway->status = '1';
                $gateway->_id = hash('sha512', $restaurant.$user->email.rand());
                $gateway->save();
            }

            $data = new Settings;
            $data->restaurant = $restaurant;
            $data->currency = $rec->currency;
            $data->currency_position = $rec->currency_position;
            $data->timezone = $rec->timezone;
            $data->address = "Your address";
            $data->contact = "Your contact";
            $data->email = "youremail@gmail.com";
            $data->description = "Your description";
            $data->copyright = $rec->copyright;
            $data->website_title = "Your restaurant name";
            $data->meta_title = "Your restaurant name";
            $data->meta_description = "Description";
            $data->facebook_link = "Your facebook page link";
            $data->linkedin_link = "Your linkedin page link";
            $data->instagram_link = "Your instagram page link";
            $data->twitter_link = "Your twitter page link";
            $data->delivery_type = "both";
            $data->item_message = "🔵 {qty} X {item_name} {variantsdata} - {item_price}";
            $data->whatsapp_message = "Hi, 
I would like to place an order 👇
*{delivery_type}* Order No: {order_no}
---------------------------
{item_variable}
---------------------------
👉Subtotal : {sub_total}
👉Tax : {total_tax}
👉Delivery charge : {delivery_charge}
👉Discount : - {discount_amount}
---------------------------
📃 Total : {grand_total}
---------------------------
📄 Comment : {notes}

✅ Customer Info

Customer name : {customer_name}
Customer phone : {customer_mobile}

📍 Delivery Details

Address : {address}, {building}, {landmark}, {postal_code}

---------------------------
Date : {date}
Time : {time}
---------------------------
💳 Payment type :
{payment_type}

{store_name} will confirm your order upon receiving the message.

Track your order 👇
{track_order_url}

Click here for next order 👇
{store_url}";

            $data->save();*/

            Auth::attempt($request->only('email', 'password'));

            return redirect()->route('home');
        }
    }

    public function notify_email($token) {
        dd($token);
    }
}
