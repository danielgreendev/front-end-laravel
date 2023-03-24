<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Privacypolicy;
use Illuminate\Support\Facades\Auth;


class PrivacyPolicyController extends Controller
{
    public function privacypolicy()
    {
        $getprivacypolicy = Privacypolicy::where('restaurant',Auth::user()->id)->first();

        return view('admin.cms.privacypolicy',compact('getprivacypolicy'));
    }
    public function update(Request $request)
    {
        $getprivacypolicy = Privacypolicy::where('restaurant',Auth::user()->id)->first();
        if(empty($getprivacypolicy)) {
            $privacypolicy = new Privacypolicy;
            $privacypolicy->restaurant = Auth::user()->id;
            $privacypolicy->privacypolicy_content = $request->privacypolicy;
            $privacypolicy->save();
        } else {
            Privacypolicy::where('restaurant', Auth::user()->id)
                ->update([
                    'privacypolicy_content' => $request->privacypolicy
                ]);
        }
        return redirect()->back()->with('success',trans('messages.success'));
    }
}
