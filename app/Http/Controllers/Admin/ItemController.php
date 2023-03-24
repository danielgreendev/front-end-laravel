<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Extra;
use App\Models\Variants;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Str;
use Helper;

class ItemController extends Controller
{
    public function index()
    {
        $menus = Item::where('restaurant',Auth::user()->id)->orderBy('id', 'DESC')->get();
        $categories = Category::where('is_available',1)->where('is_deleted',2)->where('restaurant', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('admin.menu.index',compact('menus','categories'));
    }

    public function add()
    {
        return view('admin.menu.add');
    }

    public function store(Request $request)
    {
        $checkplan = Helper::checkplan(Auth::user()->id);
        $v = json_decode(json_encode($checkplan));
        if ($v->original->status == "2") {
            return Redirect()->back()->with('error', $v->original->message);
        }

        $validation = Validator::make($request->all(),
            [   'cat_id' => 'required',
                'item_name' => 'required',
                'description' => 'required',
                'item_price' => 'required',
                'image' => 'required'
            ],[ 
                "cat_id.required"=>trans('messages.category_required'),
                "item_name.required"=>trans('messages.item_name_required'),
                "description.required"=>trans('messages.description_required'),
                "item_price.required"=>trans('messages.item_price_required'),
                "image.required"=>trans('messages.image_required')
            ]);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        } else{
            $file = $request->file("image");
            $filename = 'item-'.time().".".$file->getClientOriginalExtension();
            $file->move(storage_path().'/app/public/item/',$filename);

            $check = Item::where('slug',Str::slug($request->item_name, '-'))->first();
            if($check != ""){
                $last = Item::select('id')->orderByDesc('id')->first();
                $slug =   Str::slug($request->item_name." ".($last->id+1),'-');
            }else{
                $slug = Str::slug($request->item_name, '-');
            }

            $menu = new Item;
            $menu->restaurant = Auth::user()->id;
            $menu->cat_id = $request->cat_id;
            $menu->item_name = $request->item_name;
            $menu->slug = $slug;
            $menu->description = $request->description;
            $menu->item_price = $request->item_price;
            $menu->image = $filename;
            $str = $request->item_name.$request->description.$filename;
            $menu->_id = hash('whirlpool', $str);
            $menu->save();
            return redirect(route('menus'))->with('success',trans('messages.success'));
        }
    }

    public function del(Request $request)
    {
        $del = Item::where('id',$request->id)->delete();
        if($del){
            return 1;
        }else{
            return 0;
        }
    }

    public function show($id)
    {
        $categories = Category::where('is_available',1)->where('restaurant',Auth::user()->id)->where('is_deleted',2)->orderBy('id', 'DESC')->get();
        $mdata = Item::where('_id', $id)->where('restaurant',Auth::user()->id)->first();
        $extras = Extra::where('item_id',$mdata->id)->where('restaurant',Auth::user()->id)->orderBy('id', 'DESC')->get();
        $variants = Variants::where('item_id', $mdata->id)->where('restaurant',Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('admin.menu.show',compact('categories','mdata','extras','variants'));
    }

    public function update(Request $request,$item)
    {
        $validator = Validator::make($request->all(),[
                'cat_id' => 'required',
                'item_name' => 'required',
                'item_price' => 'required',
                'description' => 'required',
                'tax' => 'required'
            ],[
                "cat_id.required"=>trans('messages.category_required'),
                "item_name.required"=>trans('messages.item_name_required'),
                "description.required"=>trans('messages.description_required'),
                "item_price.required"=>trans('messages.item_price_required'),
                "tax.required"=>trans('messages.tax_required')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{
            
            $mdata = Item::where('slug',$item)->first();
            
            $check = Item::where('slug',Str::slug($request->item_name, '-'))->where('id','!=',$mdata->id)->first();
            if($check != ""){
                $last = Item::select('id')->orderByDesc('id')->first();
                $slug =   Str::slug($request->item_name." ".($last->id+1),'-');
            }else{
                $slug = Str::slug($request->item_name, '-');
            }

            if($request->file('image') != ""){
                $validator = Validator::make($request->all(),[
                        'image' => 'image|mimes:jpg,jpeg,png',
                    ],[
                        'image.image' => trans('messages.enter_image_file'),
                        'image.mimes' => trans('messages.valid_image'),
                    ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $rec = Item::where('id', $mdata->id)->first(); 
                    if(file_exists(storage_path("/app/public/item/".$rec->image))){
                        unlink(storage_path("/app/public/item/".$rec->image));
                    }
                    $file = $request->file('image');
                    $filename = 'image-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/item/',$filename);

                    Item::where('id',$mdata->id)->update(['image'=>$filename]);
                }  
            }

            Item::where('id', $mdata->id)->update(['restaurant' => Auth::user()->id,'cat_id' => $request->cat_id,'item_name' => $request->item_name,'item_price' => $request->item_price,'description' => $request->description,'tax' => $request->tax,'is_available' => $request->is_available,'has_variants' => $request->has_variants,'slug' => $slug]);
            return redirect()->back()->with('success',trans('messages.success'));
        }
    }
}
