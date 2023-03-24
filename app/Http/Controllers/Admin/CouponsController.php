<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Coupons;
use App\Models\Transaction;

use Str;

class CouponsController extends Controller
{
	public function index() {
    // $transaction = Transaction::select('coupon_id', DB::raw('count(*) as sold'))->where('coupon_id', '!=', null)->groupBy('coupon_id');

		// $coupons = Coupons::where('restaurant', 1)->joinSub($transaction, 'transaction', function($join) {
    //   // $join->on('id', '=', 'transaction.coupon_id');
    // })->get();

    $coupons = Coupons::select('coupons.id', 'coupons.restaurant', 'coupons.name', 'coupons.code', 'coupons.price', 'coupons.active_from', 'coupons.active_to', 'coupons.limit', 'coupons.status', 'coupons.token', DB::raw('count(*) as sold'), 'transaction.date')->where('coupons.restaurant', 1)->leftJoin('transaction', 'coupons.id', '=', 'transaction.coupon_id')->groupBy('coupons.id')->get();

		return view('admin.coupons.index', compact('coupons'));
	}

	public function add() {
		return view('admin.coupons.add');
	}

	public function show($token) {
		$rdata = Coupons::where('restaurant', Auth::user()->id)->where('token', $token)->first();
		return view('admin.coupons.show', compact('rdata'));
	}

	public function store(Request $request) {
		$validator = Validator::make($request->all(),[
      'name' => 'required|min:10',
      'code' => 'required|min:10|unique:coupons',
      'price' => 'required',
      'active_from' => 'required',
      'active_to' => 'required',
      'limit' => 'required'
    ],[
      "name.required"=>trans('messages.name_required'),
      "name.min" => trans("messages.name_min"),
      "code.required"=>trans('messages.code_required'),
      "code.min"=>trans('messages.code_min'),
      "code.unique"=>trans('messages.code_unique'),
      "price.required"=>trans('messages.price_required'),
      "active_from.required"=>trans('messages.active_from_required'),
      "active_to.required"=>trans('messages.active_to_required'),
      "limit.required"=>trans('messages.coupon_limit_required')
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }else{
    	if ($request->price < 1 || $request->limit < 0 || Auth::user()->type != 1) {
    		return redirect()->back()->withErrors($validator)->withInput();
    	}

    	$date = date("Y-m-d h:i:sa");

    	$coupon = new Coupons;
    	$coupon->restaurant = Auth::user()->id;
    	$coupon->name = $request->name;
    	$coupon->code = $request->code;
    	$coupon->type = 1;
    	$coupon->price = $request->price;
    	$coupon->active_from = $request->active_from;
    	$coupon->active_to = $request->active_to;
    	$coupon->limit = $request->limit;
      // $coupon->sold = 0;
    	$coupon->status = 2;
    	$coupon->token = hash('md5', $request->name.$date.$request->code);
    	$coupon->save();

    	return redirect(route('coupons'))->with('success',trans('messages.success'));
    }
	}

	public function update(Request $request, $token) {
		$validator = Validator::make($request->all(),[
      'name' => 'required|min:10',
      'price' => 'required',
      'active_from' => 'required',
      'active_to' => 'required',
      'limit' => 'required'
    ],[
      "name.required"=>trans('messages.name_required'),
      "name.min" => trans("messages.name_min"),
      "price.required"=>trans('messages.price_required'),
      "active_from.required"=>trans('messages.active_from_required'),
      "active_to.required"=>trans('messages.active_to_required'),
      "limit.required"=>trans('messages.coupon_limit_required')
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }else{
    	if ($request->price < 1 || $request->limit < 0 || Auth::user()->type != 1) {
    		return redirect()->back()->withErrors($validator)->withInput();
    	}

    	$date = date("Y-m-d h:i:sa");

    	$coupon = Coupons::where('restaurant', Auth::user()->id)->where('token', $token)->first();
    	$coupon->name = $request->name;
    	$coupon->price = $request->price;
    	$coupon->active_from = $request->active_from;
    	$coupon->active_to = $request->active_to;
    	$coupon->limit = $request->limit;
    	$coupon->save();

    	return redirect(route('coupons'))->with('success',trans('messages.success'));
    }
	}

	public function status(Request $request, $token)
  {
      $status = Coupons::where('restaurant', Auth::user()->id)->where('token', $token)->update(['status'=>$request->status]);
      if($status){
          return 1;
      }else{
          return 0;
      }
  }
}