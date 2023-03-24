<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Settings;
use App\Models\Terms;
use Illuminate\Support\Facades\Auth;
class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $getorders = Order::where('restaurant',Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.orders.index',compact('getorders'));
    }
    public function show(Request $request)
    {
        $order = Order::where('restaurant',Auth::user()->id)->where('id', $request->id)->first();
        $orderdetails=OrderDetails::where('order_details.order_id',$request->id)->get();
        if(empty($order)) {
            return abort(404);
        } 
        return view('admin.orders.show',compact('order','orderdetails'));
    }
    
    public function update(Request $request)
    {
        $UpdateDetails = Order::where('id', $request->id)
                    ->update(['status' => $request->status]);
        return redirect()->back()->with('success',trans('messages.success'));
    }

    public function print(Request $request)
    {
        $order = Order::where('restaurant',Auth::user()->id)->where('id', $request->id)->first();
        $orderdetails=OrderDetails::where('order_details.order_id',$request->id)->get();
        $terms = Terms::select('terms_content')
            ->where('restaurant', Auth::user()->id)
            ->first();
        $setting = Settings::where('restaurant', Auth::user()->id)->first();
        return view('admin.orders.print',compact('order','orderdetails', 'terms', 'setting'));
    }
}
