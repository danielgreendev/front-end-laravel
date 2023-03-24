<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terms;
use Illuminate\Support\Facades\Auth;


class TermsController extends Controller
{
    public function terms()
    {
        $getterms = Terms::where('restaurant',Auth::user()->id)->first();

        return view('admin.cms.terms',compact('getterms'));
    }
    public function update(Request $request)
    {
        $getterms = Terms::where('restaurant',Auth::user()->id)->first();
        if(empty($getterms)) {
            $terms = new Terms;
            $terms->restaurant = Auth::user()->id;
            $terms->terms_content = $request->terms;
            $terms->save();
        } else {
            Terms::where('restaurant', Auth::user()->id)
                ->update([
                    'terms_content' => $request->terms
                ]);
        }
        return redirect()->back()->with('success',trans('messages.success'));
    }
}
