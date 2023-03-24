<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Helper;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        if (Auth::user()->type == 1) {
            $transaction = Transaction::with('users')->orderBy('id', 'DESC')->paginate(10);
        }
        else
        {
            $transaction = Transaction::where('restaurant', Auth::user()->id)->paginate(10);
        }
        return view('admin.transaction.index',compact('transaction'));
    }
    
    public function status(Request $request)
    {
        date_default_timezone_set(Helper::webinfo(Auth::user()->id)->timezone);
        $status = Transaction::where('id',$request->id)->update(['date'=>date("Y-m-d h:i:sa"),'status'=>$request->status]);
        if($status){
            $transaction = Transaction::where('id',$request->id)->first();

            User::where('id', $transaction->restaurant)
            ->update([
                'payment_id' => $transaction->payment_id,
                'plan' => $transaction->plan,
                'purchase_amount' => $transaction->amount,
                'payment_type' => $transaction->payment_type,
                'free_plan' => 1,
                'purchase_date' => date("Y-m-d h:i:sa"),
            ]);
            return 1;
        }else{
            return 0;
        }
    }
}