<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function show()
    {
        $settingdata = Settings::where('restaurant',Auth::user()->id)->first();
        return view('admin.settings.index',compact('settingdata'));
    }
    public function update(Request $request)
    {
        if ($request->id == 1) {
            $validator = Validator::make($request->all(),[
                'currency' => 'required',
                'currency_position' => 'required',
                'copyright' => 'required',
                'website_title' => 'required',
            ],[ 
                'currency.required' => trans('messages.currency_required'),
                'currency_position.required' => trans('messages.currency_position_required'),
                'copyright.required' => trans('messages.copyright_required'),
                'website_title.required' => trans('messages.website_title_required'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                if($request->file('store_img') != ""){
                    $validator = Validator::make($request->all(),[
                            'store_img' => 'image|mimes:jpg,jpeg,png',
                        ],[
                            'store_img.image' => trans('messages.enter_image_file'),
                            'store_img.mimes' => trans('messages.valid_image'),
                        ]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }else{
                        $rec = Settings::first(); 
                        if(file_exists(storage_path("app/public/images/".$rec->store_img))){
                            unlink(storage_path("app/public/images/".$rec->store_img));
                        }
                        $file = $request->file('store_img');
                        $filename = 'store_img-'.time().".".$file->getClientOriginalExtension();
                        $file->move(storage_path().'/app/public/images/',$filename);
                        Settings::where('id',Auth::user()->id)->update(['store_img'=>$filename]);
                        User::where('id',Auth::user()->id)->update(['image'=>$filename]);
                    }  
                }
                if($request->file('logo') != ""){
                    $validator = Validator::make($request->all(),[
                            'logo' => 'image|mimes:jpg,jpeg,png',
                        ],[
                            'logo.image' => trans('messages.enter_image_file'),
                            'logo.mimes' => trans('messages.valid_image'),
                        ]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }else{
                        $rec = Settings::first(); 
                        if(file_exists(storage_path("app/public/images/".$rec->logo))){
                            unlink(storage_path("app/public/images/".$rec->logo));
                        }
                        $file = $request->file('logo');
                        $filename = 'logo-'.time().".".$file->getClientOriginalExtension();
                        $file->move(storage_path().'/app/public/images/',$filename);
                        Settings::where('id',Auth::user()->id)->update(['logo'=>$filename]);
                        User::where('id',Auth::user()->id)->update(['image'=>$filename]);
                    }  
                }
                if($request->file('favicon') != ""){
                    $validator = Validator::make($request->all(),[
                            'favicon' => 'image|mimes:jpg,jpeg,png',
                        ],[
                            'favicon.image' => trans('messages.enter_image_file'),
                            'favicon.mimes' => trans('messages.valid_image'),
                        ]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }else{
                        $rec = Settings::first(); 
                        if(file_exists(storage_path("app/public/images/".$rec->favicon))){
                            unlink(storage_path("app/public/images/".$rec->favicon));
                        }
                        $file = $request->file('favicon');
                        $filename = 'favicon-'.time().".".$file->getClientOriginalExtension();
                        $file->move(storage_path().'/app/public/images/',$filename);
                        Settings::where('id',Auth::user()->id)->update(['favicon'=>$filename]);
                    }
                }
                
                Settings::where('id',Auth::user()->id)->update(['currency'=>$request->currency,'currency_position'=>$request->currency_position,'timezone'=>$request->timezone,'copyright'=>$request->copyright,'website_title'=>$request->website_title]);
                
                return redirect(route('settings'))->with('success','Success');
            }
        } else {            
            $validator = Validator::make($request->all(),[
                'currency' => 'required',
                'currency_position' => 'required',
                'timezone' => 'required',
                'address' => 'required',
                'contact' => 'required',
                'email' => 'required|email',
                'description' => 'required',
                'copyright' => 'required',
                'website_title' => 'required',
                'meta_title' => 'required',
                'meta_description' => 'required',
                'facebook_link' => 'required',
                'twitter_link' => 'required',
                'instagram_link' => 'required',
                'linkedin_link' => 'required',
                'delivery_type' => 'required',
                'whatsapp_message' => 'required',
                'item_message' => 'required',
            ],[ 
                'currency.required' => trans('messages.currency_required'),
                'currency_position.required' => trans('messages.currency_position_required'),
                'timezone.required' => trans('messages.timezone_required'),
                'address.required' => trans('messages.address_required'),
                'contact.required' => trans('messages.contact_required'),
                'email.required' => trans('messages.email_required'),
                'email.email' => trans('messages.valid_email'),
                'description.required' => trans('messages.description_required'),
                'copyright.required' => trans('messages.copyright_required'),
                'website_title.required' => trans('messages.website_title_required'),
                'meta_title.required' => trans('messages.meta_title_required'),
                'meta_description.required' => trans('messages.meta_description_required'),
                'facebook_link.required' => trans('messages.link_required'),
                'twitter_link.required' => trans('messages.link_required'),
                'instagram_link.required' => trans('messages.link_required'),
                'linkedin_link.required' => trans('messages.link_required'),
                'delivery_type.required' => trans('messages.delivery_type_required'),
                'whatsapp_message.required' => trans('messages.whatsapp_message_required'),
                'item_message.required' => trans('messages.item_message_required'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $rec = Settings::where('restaurant',Auth::user()->id)->first();
                if (@$rec->restaurant == "") {
                    $data = new Settings;
                } else {
                    $data = new Settings;
                    $data->exists = true;
                    $data->id = $request->id;
                }
                if(isset($request->store_img)){
                    if($request->hasFile('store_img')){
                        $validator = Validator::make($request->all(),[
                                'store_img' => 'image|mimes:jpg,jpeg,png',
                            ],[
                                'store_img.image' => trans('messages.enter_image_file'),
                                'store_img.mimes' => trans('messages.valid_image'),
                            ]);
                        if ($validator->fails()) {
                            return redirect()->back()->withErrors($validator)->withInput();
                        }else{
                            $file = $request->file('store_img');
                            $filename = 'store_img-'.time().".".$file->getClientOriginalExtension();
                            $file->move(storage_path().'/app/public/images/',$filename);
                            $data->store_img=$filename;
                        }
                        
                    }            
                }
                if(isset($request->logo)){
                    if($request->hasFile('logo')){
                        $validator = Validator::make($request->all(),[
                                'logo' => 'image|mimes:jpg,jpeg,png',
                            ],[
                                'logo.image' => trans('messages.enter_image_file'),
                                'logo.mimes' => trans('messages.valid_image'),
                            ]);
                        if ($validator->fails()) {
                            return redirect()->back()->withErrors($validator)->withInput();
                        }else{
                            $file = $request->file('logo');
                            $filename = 'logo-'.time().".".$file->getClientOriginalExtension();
                            $file->move(storage_path().'/app/public/images/',$filename);
                            $data->logo=$filename;
                        }
                        
                    }            
                }
                if(isset($request->favicon)){
                    if($request->hasFile('favicon')){
                        $validator = Validator::make($request->all(),[
                                'favicon' => 'image|mimes:jpg,jpeg,png',
                            ],[
                                'favicon.image' => trans('messages.enter_image_file'),
                                'favicon.mimes' => trans('messages.valid_image'),
                            ]);
                        if ($validator->fails()) {
                            return redirect()->back()->withErrors($validator)->withInput();
                        }else{
                            $file = $request->file('favicon');
                            $filename = 'favicon-'.time().".".$file->getClientOriginalExtension();
                            $file->move(storage_path().'/app/public/images/',$filename);
                            $data->favicon=$filename;
                            User::where('id',Auth::user()->id)->update(['image'=>$filename]);
                        }
                    }            
                }
                if(isset($request->og_image)){
                    if($request->hasFile('og_image')){
                        $validator = Validator::make($request->all(),[
                                'og_image' => 'image|mimes:jpg,jpeg,png',
                            ],[
                                'og_image.mage' => trans('messages.enter_image_file'),
                                'og_image.mimes' => trans('messages.valid_image'),
                            ]);
                        if ($validator->fails()) {
                            return redirect()->back()->withErrors($validator)->withInput();
                        }else{
                            $file = $request->file('og_image');
                            $filename = 'og-'.time().".".$file->getClientOriginalExtension();
                            $file->move(storage_path().'/app/public/images/',$filename);
                            $data->og_image=$filename;
                        }  
                    }            
                }
                $data->restaurant = Auth::user()->id;
                $data->currency = $request->currency;
                $data->currency_position = $request->currency_position;
                $data->timezone = $request->timezone;
                $data->address = $request->address;
                $data->contact = $request->contact;
                $data->email = $request->email;
                $data->description = $request->description;
                $data->copyright = $request->copyright;
                $data->website_title = $request->website_title;
                $data->meta_title = $request->meta_title;
                $data->meta_description = $request->meta_description;
                $data->facebook_link = $request->facebook_link;
                $data->linkedin_link = $request->linkedin_link;
                $data->instagram_link = $request->instagram_link;
                $data->twitter_link = $request->twitter_link;
                $data->whatsapp_widget = $request->whatsapp_widget;
                $data->delivery_type = $request->delivery_type;
                $data->whatsapp_message = $request->whatsapp_message;
                $data->item_message = $request->item_message;
                $data->language = $request->language;
                $data->template = $request->template;
                $data->primary_color = $request->primary_color;
                $data->secondary_color = $request->secondary_color;
                $data->save();
                return redirect(route('settings'))->with('success','Success');
            }            
        }
    }
    public function share()
    {
        return view('admin.share.index');
    }
}
