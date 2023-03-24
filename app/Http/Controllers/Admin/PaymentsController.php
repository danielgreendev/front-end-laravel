<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Helper;

class PaymentsController extends Controller
{
	public function index()
	{
		if (Auth::user()->type == 1)
			$payments = Payment::where('restaurant', null)->paginate(10);
		else
		{
			$payments = Payment::where('restaurant', Auth::user()->id)->paginate(10);
		}

		return view('admin.payments.index', compact('payments'));
	}

	public function show($id)
	{
		$pdata = Payment::where('_id', $id)->first();
        return view('admin.payments.show', compact('pdata'));
	}

	public function update(Request $req, $id)
	{
		$checkConfig = Payment::where('_id', $id)->first();

		if($checkConfig->payment_name == "Bank transfer")
		{
			$validator = Validator::make(
	            $req->all(),
	            [
	                'bank_name' => 'required',
	                'account_number' => 'required',
	                'account_holder_name' => 'required',
	                'ifsc' => 'required',
	            ],
	            [
	                "bank_name.required" => trans('messages.bank_name_required'),
	                "account_number.required" => trans('messages.account_number_required'),
	                'account_holder_name' => trans('messages.account_holder_name_required'),
	                'ifsc' => trans('messages.ifsc_required'),
	            ]
	        );
	        if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else {
					Payment::where('id', $req->id)
                        ->update([
                            'bank_name' => $req->bank_name,
                            'account_number' => $req->account_number,
                            'account_holder_name' => $req->account_holder_name,
                            'ifsc' => $req->ifsc,
                            'environment' => $req->environment
                        ]);
                    return redirect(route('payments'))->with('success', trans('messages.success'));
            }
		}
		else
		{
			$validator = Validator::make(
	            $req->all(),
	            [
	                'public_key' => 'required',
	                'secret_key' => 'required'
	            ],
	            [
	                "public_key.required" => trans('messages.public_key_required'),
	                "secret_key.required" => trans('messages.secret_key_required'),
	            ]
	        );
	        if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else {
				Payment::where('id', $req->id)
                    ->update([
                        'public_key' => $req->public_key,
                        'secret_key' => $req->secret_key,
                        'environment' => $req->environment
                    ]);
                return redirect(route('payments'))->with('success', trans('messages.success'));
            }
		}
	}

	public function status(Request $request)
    {
        $status = Payment::where('id', $request->id)->update(['status'=>$request->status]);
        if($status){
            return 1;
        }else{
            return 0;
        }
    }
}