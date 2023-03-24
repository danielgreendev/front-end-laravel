<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryArea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Str;

class DeliveryAreaController extends Controller
{
    public function index()
    {
        $deliveryarea = DeliveryArea::where('restaurant',Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.delivery-area.index',compact('deliveryarea'));
    }
    public function add()
    {
        return view('admin.delivery-area.add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [   
                'name' => 'required',
                'price' => 'required'
            ],[ 
                "name.required"=>trans('messages.area_name_required'),
                "price.required"=>trans('messages.price_required')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{  

            $check = DeliveryArea::where('slug',Str::slug($request->name, '-'))->first();
            if($check != ""){
                $last = DeliveryArea::select('id')->orderByDesc('id')->first();
                $slug =   Str::slug($request->name." ".($last->id+1),'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }

            $area = new DeliveryArea;
            $area->restaurant = Auth::user()->id;
            $area->name = $request->name;
            $area->price = $request->price;
            $area->slug = $slug;
            $area->save();

            return redirect(route('delivery-area'))->with('success',trans('messages.success'));
        }
    }

    public function del(Request $request)
    {
        $del = DeliveryArea::where('id',$request->id)->delete();
        if($del){
            return 1;
        }else{
            return 0;
        }
    }

    public function show($slug)
    {
        $cdata = DeliveryArea::where('slug',$slug)->first();
        return view('admin.delivery-area.show',compact('cdata'));
    }
    
    public function update(Request $request,$area)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required'
            ],[
                "name.required"=>trans('messages.area_name_required')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{

            $cdata = DeliveryArea::where('slug',$area)->first();
            $checkslug = DeliveryArea::where('slug',Str::slug($request->name, '-'))->where('id','!=',$cdata->id)->first();
            if($checkslug != ""){
                $last = DeliveryArea::select('id')->orderByDesc('id')->first();
                $create = $request->name." ".($last->id+1);
                $slug =   Str::slug($create,'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }
            DeliveryArea::where('slug', $area)
                    ->update([
                        'restaurant' => Auth::user()->id,
                        'name' => $request->name,
                        'price' => $request->price,
                        'slug' => $slug
                    ]);
            return redirect()->route('delivery-area')->with('success',trans('messages.success'));
        }
    }
}
