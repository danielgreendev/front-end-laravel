<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plans;
use App\Models\Payment;
use App\Models\Currency;
use App\Models\AdminTemp;
use App\Models\Transaction;
use App\Models\SystemAddons;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Paystack;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Helper;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plans::where('type', 1)->where('is_deleted', 2)->orderBy('id', 'ASC')->get();
        return view('admin.plans.index', compact('plans'));
    }
    public function add()
    {
        return view('admin.plans.add');
    }
    public function store(Request $request)
    {
        $checkfreeplan = Plans::where('type', 1)->where('price', (float)$request->price)->first();

        if (!empty($checkfreeplan)) {       
            $plans = Plans::where('type', 1)->where('is_deleted', 2)->where('price', 0)->get();

            if ($request->price == "0" && count($plans) != 0) {
                return Redirect()->back()->with('error', trans('messages.free_plan_exist'));
            } else {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'description' => 'required',
                        'features' => 'required',
                        'price' => 'required',
                        'item_unit' => 'required',
                        'plan_period' => 'required',
                        'order_limit' => 'required'
                    ],
                    [
                        "name.required" => trans('messages.plan_name_required'),
                        "description.required" => trans('messages.description_required'),
                        "features.required" => trans('messages.features_required'),
                        "price.required" => trans('messages.price_required'),
                        "item_unit.required" => trans('messages.item_limit_required'),
                        "plan_period.required" => trans('messages.plan_period_required'),
                        "order_limit.required" => trans('messages.order_limit_required'),
                    ]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                    $plans = new Plans;
                    $plans->name = $request->name;
                    $plans->description = $request->description;
                    $plans->features = $request->features;
                    $plans->price = $request->price;
                    $plans->item_unit = $request->item_unit;
                    $plans->plan_period = $request->plan_period;
                    $plans->order_limit = $request->order_limit;
                    $plans->save();

                    return redirect(route('plans_admin'))->with('success', trans('messages.success'));
                }
            }
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'description' => 'required',
                    'features' => 'required',
                    'price' => 'required',
                    'item_unit' => 'required',
                    'plan_period' => 'required',
                    'order_limit' => 'required'
                ],
                [
                    "name.required" => trans('messages.plan_name_required'),
                    "description.required" => trans('messages.description_required'),
                    "features.required" => trans('messages.features_required'),
                    "price.required" => trans('messages.price_required'),
                    "item_unit.required" => trans('messages.item_limit_required'),
                    "plan_period.required" => trans('messages.plan_period_required'),
                    "order_limit.required" => trans('messages.order_limit_required'),
                ]
            );
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $plans = new Plans;
                $plans->name = $request->name;
                $plans->description = $request->description;
                $plans->features = $request->features;
                $plans->price = $request->price;
                $plans->item_unit = $request->item_unit;
                $plans->plan_period = $request->plan_period;
                $plans->order_limit = $request->order_limit;
                $plans->type = 1;
                $plans->save();

                return redirect(route('plans_admin'))->with('success', trans('messages.success'));
            }
        }
    }

    public function del(Request $request)
    {
        $del = Plans::where('type', 1)->where('id', $request->id)->update(['is_deleted' => 1]);
        if ($del) {
            return 1;
        } else {
            return 0;
        }
    }

    public function show($id)
    {
        $pdata = Plans::where('type', 1)->where('is_deleted', 2)->where('id', $id)->first();
        return view('admin.plans.show', compact('pdata'));
    }

    public function update(Request $request, $id)
    {
        $checkfreeplan = Plans::where('type', 1)->where('price', (float)$request->price)->first();

        if (!empty($checkfreeplan)) {
            $plans = Plans::where('type', 1)->where('id', $request->id)->where('price', 0)->get();

            if ($request->price == "0" && count($plans) == 0) {
                return Redirect()->back()->with('error', trans('messages.free_plan_exist'));
            } else {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'description' => 'required',
                        'features' => 'required',
                        'price' => 'required',
                        'item_unit' => 'required',
                        'plan_period' => 'required',
                        'order_limit' => 'required'
                    ],
                    [
                        "name.required" => trans('messages.plan_name_required'),
                        "description.required" => trans('messages.description_required'),
                        "features.required" => trans('messages.features_required'),
                        "price.required" => trans('messages.price_required'),
                        "item_unit.required" => trans('messages.item_limit_required'),
                        "plan_period.required" => trans('messages.plan_period_required'),
                        "order_limit.required" => trans('messages.order_limit_required'),
                    ]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
        
                    Plans::where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                            'description' => $request->description,
                            'features' => $request->features,
                            'price' => $request->price,
                            'item_unit' => $request->item_unit,
                            'plan_period' => $request->plan_period,
                            'order_limit' => $request->order_limit
                        ]);
                    return redirect(route('plans_admin'))->with('success', trans('messages.success'));
                }
            }
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'description' => 'required',
                    'features' => 'required',
                    'price' => 'required',
                    'item_unit' => 'required',
                    'plan_period' => 'required',
                    'order_limit' => 'required'
                ],
                [
                    "name.required" => trans('messages.plan_name_required'),
                    "description.required" => trans('messages.description_required'),
                    "features.required" => trans('messages.features_required'),
                    "price.required" => trans('messages.price_required'),
                    "item_unit.required" => trans('messages.item_limit_required'),
                    "plan_period.required" => trans('messages.plan_period_required'),
                    "order_limit.required" => trans('messages.order_limit_required'),
                ]
            );
            if ($validator->fails()) {
    
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
    
                Plans::where('id', $request->id)
                    ->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'features' => $request->features,
                        'price' => $request->price,
                        'item_unit' => $request->item_unit,
                        'plan_period' => $request->plan_period,
                        'order_limit' => $request->order_limit
                    ]);
                return redirect(route('plans_admin'))->with('success', trans('messages.success'));
            }
        }
    }

    public function plans()
    {
        $plans = Plans::where('type', 1)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.plans.plans', compact('plans'));
    }

    public function purchase(Request $request)
    {
        $check = SystemAddons::where('unique_identifier', 'payment')->first();
        if (@$check->activated == 0 && @$check == "") {
            return Redirect()->back()->with('danger', 'Purchase Extended license for payment gateway');
        } else {
            $plans = Plans::where('type', 1)->where('_id', $request->id)->first();
            $paymentlist = Payment::where('status', '1')->where('payment_name', '!=', 'COD')->where('restaurant', null)->get();
            $bankdetails = Payment::where('payment_name', 'Bank transfer')->where('restaurant', null)->first();
            $paypal = Payment::where('payment_name', 'PayPal')->where('restaurant', null)->first();
            if ($paypal->environment == 1)
                $paypal->ifsc = "https://www.sandbox.PayPal.com/cgi-bin/webscr";
            else
                $paypal->ifsc = "https://www.PayPal.com/cgi-bin/webscr";

            return view('admin.plans.purchase', compact('plans', 'paymentlist', 'bankdetails', 'paypal'));
        }
    }

    public function order(Request $request)
    {
        date_default_timezone_set(Helper::webinfo(Auth::user()->id)->timezone);
        if ($request->payment_type == "COD") {
            $payment_id = 'COD';
        } else if ($request->payment_type == "RazorPay") {
            $payment_id = $request->payment_id;

            $getrazorPay = Payment::where('restaurant', null)->where("payment_name", "RazorPay")->first();
            $api = new Api($getrazorPay->public_key, $getrazorPay->secret_key);
            $razor_payment = $api->payment->fetch($input['razorpay_payment_id']);

            if(count($input)  && !empty($input['razorpay_payment_id'])) {
                try {
                    $razor_response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                } catch (Exception $e) {
                    //return  $e->getMessage();
                    Session::put('error',$e->getMessage());
                    return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);
                }
            }
        } else if ($request->payment_type == "Stripe") {
            $getstripe = Payment::select('environment', 'secret_key')->where('restaurant', null)->where('payment_name', 'Stripe')->first();

            $skey = $getstripe->secret_key;

            Stripe::setApiKey($skey);

            $customer = Customer::create(array(
                'email' => $request->email,
                'source' => $request->stripeToken,
                'name' => $request->name,
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'description' => 'Subscription payment',
            ));

            if ($charge['status'] != 'succeeded') {
                return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);
            }

            $payment_id = $charge['id'];
        } else {
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);
        }

        $transaction = new Transaction;

        User::where('id', Auth::user()->id)
            ->update([
                'payment_id' => @$payment_id,
                'plan' => $request->plan,
                'purchase_amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'free_plan' => 1,
                'purchase_date' => date("Y-m-d h:i:sa"),
            ]);

        $date = date("Y-m-d h:i:sa");
        $status = "2";
        $amount = $request->amount;

        $transaction->restaurant = Auth::user()->id;
        $transaction->plan = $request->plan;
        $transaction->amount = $amount;
        $transaction->payment_type = $request->payment_type;
        $transaction->payment_id = @$payment_id;
        $transaction->date = $date;
        $transaction->status = $status;
        $transaction->plan_period = $request->plan_period;
        $transaction->save();

       // $admininfo = User::where('type', 1)->first();

        $msg = trans('labels.new_vendor_subscription');
        $vmsg = trans('labels.subscribed_package');

        if ($request->payment_type == "COD") {
            $payment_type =  "FREE";
        }

        if ($request->payment_type == "RazorPay") {
            $payment_type =  "Razorpay : " . @$payment_id;
        }

        if ($request->payment_type == "Stripe") {
            $payment_type = "Stripe : " . @$payment_id;
        }

        if ($request->payment_type == "COD") {
            return redirect()->route('plans')->with('success', trans('messages.success'));
        } else {
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        }
    }

    public function notify(Request $request)
    {
        $data = [
            'item_name' => $_POST['item_name'],
            'item_number' => $_POST['item_number'],
            'payment_status' => $_POST['payment_status'],
            'payment_amount' => $_POST['mc_gross'],
            'payment_currency' => $_POST['mc_currency'],
            'txn_id' => $_POST['txn_id'],
            'receiver_email' => $_POST['receiver_email'],
            'payer_email' => $_POST['payer_email'],
            'custom' => $_POST['custom'],
        ];

        $transaction = new Transaction;
        //$transaction->restaurant = Auth::user()->id;
        //$transaction->plan = $request->plan;
        $transaction->amount = $data['payment_amount'];
        $transaction->payment_type = $_POST;
        //$transaction->payment_id = @$payment_id;
        //$transaction->date = $date;
        //$transaction->status = $status;
        //$transaction->plan_period = $request->plan_period;
        $transaction->save();
    }

    public function reset(Request $request)
    {
        $plan = Plans::where('type', 1)->where("is_deleted", 2)->where("price", '>', 0)->orderBy('price', 'asc')->first();

        if ($plan == null)
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

        $amount = $request->amount;
        if ($amount < $plan->price)
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

        $business = $request->business;
        $payment = Payment::where('public_key', $business)->where('payment_name', 'PayPal')->where('restaurant', null)->first();
        if ($payment == null)
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);
        
        $payer_email = $request->payer_email;
        $payer_name = $request->payer_name;
        $user = User::where('type', 2)->where('email', $payer_email)->where('name', $payer_name)->first();

        if ($user == null || $request->no_shopping != 1)
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

        $currency_code = $request->currency_code;
        $currency = Currency::where('name', $currency_code)->first();
        if ($currency == null || $request->payment_type != "PayPal")
            return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

        $plan = Plans::where('type', 1)->where("is_deleted", 2)->where("price", '>', 0)->where('name', $request->plan)->where('plan_period', $request->plan_period)->first();
        if ($plan == null)
            return response()->json(['status' => 1, 'message' => "$plans->price"], 500);

        $notify_url = $request->notify_url;
        $cancel_return = $request->cancel_return;
        $return_pay = $request->return_pay;

        $date = date("Y-m-d h:i:sa");

        $temp = new AdminTemp;
        $temp->payment_id = hash('md5', rand().$date);
        $temp->business = $business;
        $temp->payer_id = $user->id;
        $temp->amount = $amount;
        $temp->currency_id = $currency->id;
        $temp->plan_id = $plan->id;
        $temp->timestamp = hash('whirlpool', rand().$temp->payment_id.rand());
        $temp->is_deleted = 2;
        $temp->save();

        $token = base64_encode(hash('adler32', $date).$temp->timestamp.hash('crc32b', $date));

        $return_pay .= '/'.$token;
        $payment_id = $temp->payment_id;

        $message = array('url' => $return_pay, 'id' => $payment_id);

        return response()->json(['status' => 1, 'message' => json_encode($message)], 200);
    }

    public function success($token)
    {
        $token = base64_decode($token);

        $token = substr($token, 8, -8);

        $temp = AdminTemp::where('timestamp', $token)->where('is_deleted', 2)->first();

        if ($temp == null) {
            return redirect(route('plans'))->with('error', trans('messages.payment_error'));
        }

        AdminTemp::where('id', $temp->id)
            ->update([
                'is_deleted' => 1
            ]);

        AdminTemp::where('is_deleted', 2)->whereDate('created_at', '<=', now()->subDays(1))
            ->update([
                'is_deleted' => 1,
            ]);

        $plan = Plans::where('type', 1)->where('id', $temp->plan_id)->first();

        $transaction = new Transaction;

        User::where('id', Auth::user()->id)
            ->update([
                'payment_id' => @$temp->payment_id,
                'plan' => $plan->name,
                'purchase_amount' => $plan->price,
                'payment_type' => 'PayPal',
                'free_plan' => 1,
                'purchase_date' => date("Y-m-d h:i:sa"),
            ]);

        $date = date("Y-m-d h:i:sa");

        $transaction->restaurant = Auth::user()->id;
        $transaction->plan = $plan->name;
        $transaction->amount = $plan->price;
        $transaction->payment_type = 'PayPal';
        $transaction->payment_id = @$temp->payment_id;
        $transaction->date = $date;
        $transaction->status = 2;
        $transaction->plan_period = $plan->plan_period;
        $transaction->save();

        return redirect(route('plans'))->with('success', trans('messages.success'));
    }

    public function cancel() {
        return redirect(route('plans'))->with('error', trans('messages.payment_error'));
    }
}
