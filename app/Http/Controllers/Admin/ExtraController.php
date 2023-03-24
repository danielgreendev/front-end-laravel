<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Extra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Str;

class ExtraController extends Controller
{
    public function add()
    {
        return view('admin.extra.add');
    }
    public function store(Request $request)
    {
        $check = Extra::where('slug',Str::slug($request->name, '-'))->first();
        if($check != ""){
            $last = Extra::select('id')->orderByDesc('id')->first();
            $slug =   Str::slug($request->name." ".($last->id+1),'-');
        }else{
            $slug = Str::slug($request->name, '-');
        }

        $category = new Extra;
        $category->restaurant = Auth::user()->id;
        $category->item_id = $request->item_id;
        $category->name = $request->name;
        $category->price = $request->price;
        $category->slug = $slug;
        $category->save();

        return redirect()->back()->with('success',trans('messages.success'));
    }

    public function del(Request $request)
    {
        $del = Extra::where('id',$request->id)->delete();
        if($del){
            return 1;
        }else{
            return 0;
        }
    }

    public function show($slug)
    {
        $cdata = Extra::where('slug',$slug)->first();
        return view('admin.extra.show',compact('cdata'));
    }
    
    public function update(Request $request)
    {
        $cdata = Extra::where('id',$request->extra_id)->first();

        $checkslug = Extra::where('slug',Str::slug($request->name, '-'))->where('id','!=',$cdata->extra_id)->first();
        if($checkslug != ""){
            $last = Extra::select('id')->orderByDesc('id')->first();
            $create = $request->name." ".($last->id+1);
            $slug =   Str::slug($create,'-');
        }else{
            $slug = Str::slug($request->name, '-');
        }
        Extra::where('id', $request->extra_id)
                ->update([
                    'restaurant' => Auth::user()->id,
                    'item_id' => $request->item_id,
                    'name' => $request->name,
                    'price' => $request->price,
                    'slug' => $slug
                ]);
        return redirect()->back()->with('success',trans('messages.success'));
    }
}
