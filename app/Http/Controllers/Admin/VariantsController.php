<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Str;

class VariantsController extends Controller
{
    public function store(Request $request)
    {
        $check = Variants::where('restaurant',Auth::user()->id)->where('slug',Str::slug($request->variants_name, '-'))->first();
        if($check != ""){
            $last = Variants::select('id')->orderByDesc('id')->first();
            $slug =   Str::slug($request->variants_name." ".($last->id+1),'-');
        }else{
            $slug = Str::slug($request->variants_name, '-');
        }

        $category = new Variants;
        $category->restaurant = Auth::user()->id;
        $category->item_id = $request->item_id;
        $category->name = $request->variants_name;
        $category->price = $request->variants_price;
        $category->slug = $slug;
        $category->save();

        return redirect()->back()->with('success',trans('messages.success'));
    }

    public function del(Request $request)
    {
        $del = Variants::where('id',$request->id)->delete();
        if($del){
            return 1;
        }else{
            return 0;
        }
    }
    
    public function update(Request $request)
    {
        
        $cdata = Variants::where('id',$request->variants_id)->first();

        $checkslug = Variants::where('slug',Str::slug($request->variants_name, '-'))->where('id','!=',$cdata->variants_id)->first();
        if($checkslug != ""){
            $last = Variants::select('id')->orderByDesc('id')->first();
            $create = $request->variants_name." ".($last->id+1);
            $slug =   Str::slug($create,'-');
        }else{
            $slug = Str::slug($request->variants_name, '-');
        }
        Variants::where('id', $request->variants_id)
                ->update([
                    'restaurant' => Auth::user()->id,
                    'item_id' => $request->item_id,
                    'name' => $request->variants_name,
                    'price' => $request->variants_price,
                    'slug' => $slug
                ]);
        return redirect()->back()->with('success',trans('messages.success'));
    }
}
