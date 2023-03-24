<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Helper;

class WhatsappController extends Controller
{
	public function index()
	{
		$users = User::where('type', 3)->where('plan_app', 'PLUS')->paginate(10);
		return view('admin.whatsapp.index', compact('users'));
	}

	public function status(Request $request)
    {
        $status = User::where('id', $request->id)->update(['is_approved'=>$request->status]);
        if($status){
            return 1;
        }else{
            return 0;
        }
    }

    public function delete(Request $request)
    {
    	User::where('id', $request->id)->delete();
    	return 1;
    }
}