<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\Plans;
use App\Models\Transaction;

class AdminController extends Controller

{
    public function home(Request $request)
    {
        $months = array('January' => 'Janeiro', 'February' => 'Fevereiro', 'March' => 'Marchar', 'April' => 'Abril', 'May' => 'Poderia', 'June' => 'Junho', 'July' => 'Julho', 'August' => 'Agosto', 'September' => 'Setembro', 'October' => 'Outubro', 'November' => 'Novembro', 'December' => 'Dezembro');

        if (Auth::user()->type == 1) {
            $restaurants = User::where('type',2)->count();
            $menus = Item::where('is_available','1')->count();
            $orders = Order::count();
            $plans = Plans::where('type', 1)->count();

            // ORDER-CHART-START
            $request->getyear != "" ? $year = $request->getyear : $year = date('Y');
            $order_years = Order::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
            $orderlabels = Order::select(DB::raw("MONTHNAME(created_at) as month_name"))
                ->whereYear('created_at', $year)
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('month_name');

            if ($orderlabels != null)
            {
                for ($i = 0; $i < count($orderlabels); $i++)
                    $orderlabels[$i] = $months[$orderlabels[$i]];             
            }
            
            $deliverydata = Order::select(DB::raw("COUNT(id) as total_order"))
                ->whereYear('created_at', $year)
                ->where('order_type', 1)
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('total_order');
            $pickupdata = Order::select(DB::raw("COUNT(id) as total_order"))
                ->whereYear('created_at', $year)
                ->where('order_type', 2)
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('total_order');
            //ORDER-CHART-END

            // USERS-CHART-START
            $request->useryear != "" ? $useryear = $request->useryear : $useryear = date('Y');

            $user_years = User::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
            
            $userslist = User::select(DB::raw("MONTHNAME(created_at) as month_name"),DB::raw("COUNT(id) as total_user"))
                ->whereYear('created_at', $useryear)
                ->where('type', 2)
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('total_user','month_name');
            $userslabels = $userslist->keys();

            if ($userslabels != null)
            {
                for ($i = 0; $i < count($userslabels); $i++)
                    $userslabels[$i] = $months[$userslabels[$i]];             
            }

            $userdata = $userslist->values();
            // USERS-CHART-END

            // EARNINGS-CHART-START
            $request->earningsyear != "" ? $earningsyear = $request->earningsyear : $earningsyear = date('Y');

            if (Auth::user()->id == 1) {
                $earnings_years = Transaction::select(DB::raw("YEAR(date) as year"))->groupBy(DB::raw("YEAR(date)"))->orderByDesc('date')->get();
                $earningslabels = Transaction::select(DB::raw("MONTHNAME(date) as month_name"))
                ->whereYear('date', $year)
                ->orderBy('date')
                ->groupBy(DB::raw("MONTHNAME(date)"))
                ->pluck('month_name');
                $earningsdata = Transaction::select(DB::raw("SUM(amount) as grand_total"))
                ->whereYear('date', $earningsyear)
                ->whereIn('status', array(2))
                ->orderBy('date')
                ->groupBy(DB::raw("MONTHNAME(date)"))
                ->pluck('grand_total');
                // dd($earningsdata);
            } else {
                $earnings_years = Order::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
                $earningslabels = Order::select(DB::raw("MONTHNAME(created_at) as month_name"))
                ->whereYear('created_at', $year)
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('month_name');

                $earningsdata = Order::select(DB::raw("SUM(grand_total) as grand_total"))
                ->whereYear('created_at', $earningsyear)
                ->whereIn('status', array(4))
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('grand_total');
            }
            
            if ($earningslabels != null)
            {
                for ($i = 0; $i < count($earningslabels); $i++)
                    $earningslabels[$i] = $months[$earningslabels[$i]];             
            }
                
            // EARNINGS-CHART-END

            if($request->ajax()){
                return response()->json(['orderlabels'=>$orderlabels,'deliverydata'=>$deliverydata,'pickupdata'=>$pickupdata,'earningslabels'=>$earningslabels,'earningsdata'=>$earningsdata,'userslabels'=>$userslabels,'userdata'=>$userdata,'user_years'=>$user_years],200);
            }else{            
                return view('admin.dashboard.home',compact('restaurants','menus','orders','plans','year','order_years','orderlabels','deliverydata','pickupdata','earnings_years','earningsdata','earningslabels','userslabels','userdata','user_years'));
            }

           
        } else {
            $restaurants = User::where('type',2)->count();
            $menus = Item::where('restaurant',Auth::user()->id)->where('is_available','1')->count();
            $orders = Order::where('restaurant',Auth::user()->id)->count();
            $plans = Plans::where('type', 1)->count();

            // ORDER-CHART-START
            $request->getyear != "" ? $year = $request->getyear : $year = date('Y');
            $order_years = Order::select(DB::raw("YEAR(created_at) as year"))->where('restaurant',Auth::user()->id)->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
            $orderlabels = Order::select(DB::raw("MONTHNAME(created_at) as month_name"))
                ->where('restaurant',Auth::user()->id)
                ->whereYear('created_at', $year)
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('month_name');
            $deliverydata = Order::select(DB::raw("COUNT(id) as total_order"))
                ->where('restaurant',Auth::user()->id)
                ->whereYear('created_at', $year)
                ->where('order_type', 1)
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('total_order');
            $pickupdata = Order::select(DB::raw("COUNT(id) as total_order"))
                ->where('restaurant',Auth::user()->id)
                ->whereYear('created_at', $year)
                ->where('order_type', 2)
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('total_order');
            //ORDER-CHART-END

            if ($orderlabels != null)
            {
                for ($i = 0; $i < count($orderlabels); $i++)
                    $orderlabels[$i] = $months[$orderlabels[$i]];             
            }

            // USERS-CHART-START
            $request->useryear != "" ? $useryear = $request->useryear : $useryear = date('Y');

            $user_years = User::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
            
            $userslist = User::select(DB::raw("MONTHNAME(created_at) as month_name"),DB::raw("COUNT(id) as total_user"))
                ->whereYear('created_at', $useryear)
                ->where('type', 2)
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('total_user','month_name');
            $userslabels = $userslist->keys();

            $userslabels = $userslist->keys();

            if ($userslabels != null)
            {
                for ($i = 0; $i < count($userslabels); $i++)
                    $userslabels[$i] = $months[$userslabels[$i]];             
            }

            $userdata = $userslist->values();
            // USERS-CHART-END

            // EARNINGS-CHART-START
            $request->earningsyear != "" ? $earningsyear = $request->earningsyear : $earningsyear = date('Y');
            $earnings_years = Order::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->where('restaurant',Auth::user()->id)->get();
            $earningslabels = Order::select(DB::raw("MONTHNAME(created_at) as month_name"))
                ->where('restaurant',Auth::user()->id)
                ->whereYear('created_at', $year)
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('month_name');

            if ($earningslabels != null)
            {
                for ($i = 0; $i < count($earningslabels); $i++)
                    $earningslabels[$i] = $months[$earningslabels[$i]];             
            }

            $earningsdata = Order::select(DB::raw("SUM(grand_total) as grand_total"))
                ->where('restaurant',Auth::user()->id)
                ->whereYear('created_at', $earningsyear)
                ->whereIn('status', array(4))
                ->orderBy('created_at')
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('grand_total');
            // EARNINGS-CHART-END


            if($request->ajax()){
                return response()->json(['orderlabels'=>$orderlabels,'deliverydata'=>$deliverydata,'pickupdata'=>$pickupdata,'earningslabels'=>$earningslabels,'earningsdata'=>$earningsdata,'userslabels'=>$userslabels,'userdata'=>$userdata,'user_years'=>$user_years],200);
            }else{            
                return view('admin.dashboard.home',compact('restaurants','menus','orders','plans','year','order_years','orderlabels','deliverydata','pickupdata','earnings_years','earningsdata','earningslabels','userslabels','userdata','user_years'));
            }
        }          
    }
    public function changepassword(Request $request)
    {
        if(\Hash::check($request->old_password,Auth::user()->password)){
            User::where('id', Auth::user()->id)->update( array('password'=>Hash::make($request->new_password)) );
            return redirect()->back()->with('success',trans('messages.success'));
           
        }else{
            return redirect()->back()->with('danger',trans('messages.old_password_incorrect'));
        }
    }
    public function updateprofile(Request $request)
    {
        if (strlen(trim($request->name)) < 10)
            return response()->json(['status' => 1, 'message' => trans('messages.user_name_min')], 500);
        if($request->file('avatar-image') != ""){
            $validator = Validator::make($request->all(),[
                    'avatar-image' => 'image|mimes:jpg,jpeg,png',
                ],[
                    'avatar-image.image' => trans('messages.enter_image_file'),
                    'avatar-image.mimes' => trans('messages.valid_image'),
                ]);
            if ($validator->fails()) {
                return response()->json(['status' => 1, 'message' => trans('messages.invalid_image')], 500);
            }else{
                $file = $request->file('avatar-image');
                // exit(json_encode($_FILES));
                $filename = 'avatar-'.time().".".$file->getClientOriginalExtension();
                $file->move(storage_path().'/app/public/admin-assets/img/portrait/avatars/',$filename);
                User::where('id',Auth::user()->id)->update(['avatar'=>$filename]);
            }  
        }
        
        if (Auth::user()->id == 1) {
            $users = User::where('email', $request->email)->where('id', '!=', Auth::user()->id)->first();
            if ($users != null)
                return response()->json(['status' => 1, 'message' => trans('messages.email_exist')], 500);

            User::where('id',$request->id)
                ->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                ]);
        }
        else {
            User::where('id',$request->id)
                ->update([
                    'name'=>$request->name,
                ]);   
        }
        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }
}
