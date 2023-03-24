<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function index()
    {
        $timingdata = Timing::where('restaurant',Auth::user()->id)->get();
        return view('admin.time.index',compact('timingdata'));
    }
    public function edit(Request $request)
    {
        $day = $request->day;
        $open_time = $request->open_time;
        $close_time= $request->close_time;     
        $is_always_close= $request->is_always_close;

        foreach($day as $key => $no)
        {
            $input['day'] = $no;
            if ($is_always_close[$key] == "2") {
                if($open_time[$key] == "Closed"){
                    $input['open_time'] = "09:00am";
                }else{
                    $input['open_time'] = $open_time[$key];    
                }
            } else {
                $input['open_time'] = "09:00am";
            }
            if ($is_always_close[$key] == "2") {
                if($close_time[$key] == "Closed"){
                    $input['close_time'] = "06:00pm";
                }else{
                    $input['close_time'] = $close_time[$key];
                }
            } else {
                $input['close_time'] = "06:00pm";
            }
            $input['is_always_close'] = $is_always_close[$key];

            Timing::where('restaurant',Auth::user()->id)->where('day', $no)->update($input);
        }

        return redirect()->back()->with('success', 'The time has been updated.');
    }
}
