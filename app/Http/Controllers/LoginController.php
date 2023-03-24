<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use Helper;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login_');
    }
    
    public function check_admin(Request $request)
    {
        try{
            if( ini_get('allow_url_fopen') ) {
                $payload = file_get_contents('https://gravityinfotech.net/api/keyverify.php?url='.str_replace('check-admin', '', url()->current()).'&type=login');
                $obj = json_decode($payload);
                $obj->status = '1';
                if ($obj->status == '1') {
                    $validator = Validator::make($request->all(),[
                            'email' => 'required|email',
                            'password' => 'required',
                        ],  [ 
                            'email.required' => trans('messages.enter_email'),
                            'email.email' => trans('messages.valid_email'),
                            'password.required' => trans('messages.enter_password')
                        ]);
                    if ($validator->fails()) {
                    
                        return redirect()->back()->withErrors($validator)->withInput();
                        
                    }else{
                        
                        if (Auth::attempt($request->only('email', 'password'))) 
                        {
                            if(Auth::user()->type==1 || Auth::user()->type==2 || Auth::user()->type==3) { 
                                
                                User::where('type', 3)->where('plan_app', null)->whereDate('app_purchase_date', '<', now()->subDays(7))
                                    ->update([
                                        'is_expired' => 2,
                                    ]);

                                // return redirect()->route('user.landing.index');
                                return redirect()->route('dashboard');

                            } else{
                                Auth::logout();
                                return redirect()->back()->with('error',trans('messages.email_pass_invalid'));
                            }
                        }else{
                            return redirect()->back()->with('error',trans('messages.email_pass_invalid'));
                        }
                    }
                } elseif ($obj->status == '3') {
                    return Redirect::to('/admin')->with('danger', $obj->message);
                } else {
                    return Redirect::to('/admin/verification')->with('danger', $obj->message);
                }
            }
        }catch(Exception $exception){
            return back()->withError($exception->getMessage())->withInput();    
        }
    }
    public function logout() {
        Auth::logout();
        session()->flush();
        return redirect()->route('home');
    }

    public function systemverification(Request $request)
    {
        if( ini_get('allow_url_fopen') ) {
            $username = str_replace(' ','',$request->envato_username);

            $payload = file_get_contents('https://gravityinfotech.net/api/getdata.php?envato_username='.$username.'&email='.$request->email.'&purchase_key='.$request->purchase_key.'&domain='.$request->domain.'&purchase_type=Envato&version=1');

            $obj = json_decode($payload);
            $obj->status = '1';

            if ($obj->status == '1') {
                return Redirect::to('/admin')->with('success', 'You have successfully verified your License. Please try to Login now. If any query Contact us infotechgravity@gmail.com');
            } else {
                return Redirect::back()->with('danger', $obj->message);
            }
        } else {
            return Redirect::back()->with('danger', "allow_url_fopen is disabled. file_get_contents would not work. ASK TO YOUR SERVER SUPPORT TO ENABLE THIS 'allow_url_fopen' AND TRY AGAIN");
        }
    }

    public function forgotpassword() {
        return view('admin.auth.forgot-password_');
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
            $checkadmin = User::where('email', $request->email)->where('type', '!=', 1)->first();
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
