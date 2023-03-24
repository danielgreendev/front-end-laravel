<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_deleted',2)->where('restaurant',Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.category.index',compact('categories'));
    }
    public function add()
    {
        return view('admin.category.add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [   'name' => 'required'
            ],[ 
                "name.required"=>trans('messages.category_name_required')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{  

            $check = Category::where('slug',Str::slug($request->name, '-'))->first();
            if($check != ""){
                $last = Category::select('id')->orderByDesc('id')->first();
                $slug =   Str::slug($request->name." ".($last->id+1),'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }

            $category = new Category;
            $category->restaurant = Auth::user()->id;
            $category->name = $request->name;
            $category->slug = $slug;
            $category->is_deleted = 2;
            $category->save();

            return redirect(route('menus'))->with('success',trans('messages.success'));
        }
    }

    public function del(Request $request)
    {
        $del = Category::where('id',$request->id)->update(['is_deleted'=>1]);
        if($del){
            return 1;
        }else{
            return 0;
        }
    }

    public function show($slug)
    {
        $cdata = Category::where('slug',$slug)->first();
        return view('admin.category.show',compact('cdata'));
    }
    
    public function update(Request $request,$category)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required'
            ],[
                "name.required"=>trans('messages.category_name_required')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{

            $cdata = Category::where('slug',$category)->first();
            $checkslug = Category::where('slug',Str::slug($request->name, '-'))->where('id','!=',$cdata->id)->first();
            if($checkslug != ""){
                $last = Category::select('id')->orderByDesc('id')->first();
                $create = $request->name." ".($last->id+1);
                $slug =   Str::slug($create,'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }
            Category::where('slug', $category)->update(['restaurant' => Auth::user()->id,'name' => $request->name,'slug' => $slug]);
            return redirect()->route('menus')->with('success',trans('messages.success'));
        }
    }
}
