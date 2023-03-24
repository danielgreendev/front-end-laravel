<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\User;
use App\Models\Item;
use App\Models\Extra;
use App\Models\Plans;
use App\Models\Timing;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Settings;
use App\Models\Variants;
use App\Models\SystemAddons;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Str;

class RestaurantController extends Controller

{
    public function index()
    {
        $restaurants = User::where('type',2)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.restaurants.index',compact('restaurants'));
    }
    public function add()
    {
        $plans = Plans::where('type', 1)->get();
        return view('admin.restaurants.add',compact('plans'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:10',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|unique:users,mobile',
        ],[
            "name.required"=>trans('messages.restaurant_name_required'),
            "name.min" => trans("messages.user_name_min"),
            "email.required"=>trans('messages.email_required'),
            "email.email"=>trans('messages.valid_email'),
            "email.unique"=>trans('messages.email_exist'),
            "mobile.required"=>trans('messages.mobile_required'),
            "mobile.unique"=>trans('messages.mobile_exist')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $check = User::where('slug',Str::slug($request->name, '-'))->first();
            if($check != ""){
                $last = User::select('id')->orderByDesc('id')->first();
                $slug =   Str::slug($request->name." ".($last->id+1),'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }
            $rec = Settings::where('restaurant','1')->first();
            date_default_timezone_set($rec->timezone);

            $date = date("Y-m-d h:i:sa");

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = hash::make(12345678);
            $user->country_code = '+55';
            $user->mobile = $request->mobile;
            $user->token = hash('sha512', $request->name.$date.$request->email).hash('md5', $slug);
            $user->avatar = "1.png";
            $user->image = "default-logo.png";
            $user->slug = $slug;
            $user->login_type = "email";
            $user->type = 2;
            $user->is_verified = 2;
            $user->is_available = 1;
            $user->is_approved = 2;
            $user->payment_id = hash("whirlpool", rand().$user->password.$date.rand());
            $user->plan = "EXPERT";
            $user->purchase_amount = 10000;
            $user->purchase_date = $date;
            $user->payment_type = 5;
            $user->free_plan = 1;
            $user->app_token = rand().hash('sha384', $request->name.$date.$request->email.rand()).rand();
            $user->save();
            $restaurant = \DB::getPdo()->lastInsertId();
            $days = [ "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" ];
            foreach ($days as $day) {
                $timedata = new Timing;
                $timedata->restaurant =$restaurant;
                $timedata->day =$day;
                $timedata->open_time ='12:00am';
                $timedata->close_time ='11:59pm';
                $timedata->is_always_close ='2';
                $timedata->save();
            }
            $check = SystemAddons::where('unique_identifier', 'payment')->first();
            $paymentlist = Payment::select('payment_name')->where('restaurant', null)->where('account_number', null)->get();

            foreach ($paymentlist as $payment) {
                $gateway = new Payment;
                $gateway->restaurant = $restaurant;
                $gateway->payment_name = $payment->payment_name;
                $gateway->public_key = NULL;
                $gateway->secret_key = NULL;
                $gateway->encryption_key = NULL;
                $gateway->environment = '1';
                $gateway->status = $payment->status;
                $gateway->_id = hash('sha512', $restaurant.$user->email.rand().$date);
                $gateway->save();
            }
            $data = new Settings;
            $data->restaurant = $restaurant;
            $data->currency = $rec->currency;
            $data->currency_position = $rec->currency_position;
            $data->timezone = $rec->timezone;
            $data->address = "Endereço completo";
            $data->country_code = '+55';
            $data->contact = "Prefixo + nº";
            $data->email = "Informe seu email";
            $data->description = "Faça uma descrição do negócio";
            $data->copyright = $rec->copyright;
            $data->website_title = "Insira o nome da loja";
            $data->meta_title = "Insira o nome da loja";
            $data->meta_description = "Faça uma descrição do negócio";
            $data->facebook_link = "Insira o link da sua pagina do face";
            $data->linkedin_link = "Insira o link da sua pagina do twitter";
            $data->instagram_link = "Insira o link da sua pagina do insta";
            $data->twitter_link = "Insira o link da sua pagina do linkedin";
            $data->delivery_type = "both";
            $data->item_message = "🔵 {qty} X {item_name} {variantsdata} - {item_price}";
            $data->whatsapp_message = "Olá, 

Eu gostaria de confirmar meu pedido 👇

*{delivery_type}* Nº do Pedido: {order_no}
---------------------------
{item_variable}
---------------------------

👉Taxa de Entrega : {delivery_charge}

👉Desconto : - {discount_amount}
---------------------------

📃 Total : {grand_total}
---------------------------

📄 Observação : {notes}

✅ Informação do Cliente



Nome do cliente : {customer_name}

Celular do cliente : {customer_mobile}

📍 Detalhes da Entrega



Endereço : {address}, {building}, {landmark}
---------------------------

💳 Forma de pagamento :
{payment_type}
{store_name} Agradece a preferência.

Acompanhe seu pedido por aqui 👇

{track_order_url}

Clique aqui fazer um novo pedido 👇

{store_url}";
            $data->save();
            return redirect(route('restaurants'))->with('success',trans('messages.success'));
        }
    }
    
    public function status(Request $request)
    {
        if (strlen($request->token) > 10) {
            $restaurant = $request->id;
            User::where('id', $request->id)->delete();
            Variants::where('restaurant', $restaurant)->delete();
            Timing::where('restaurant', $restaurant)->delete();
            Payment::where('restaurant', $restaurant)->delete();
            Item::where('restaurant', $restaurant)->delete();
            Extra::where('restaurant', $restaurant)->delete();
            Category::where('restaurant', $restaurant)->delete();
            Cart::where('restaurant', $restaurant)->delete();
            Settings::where('restaurant', $restaurant)->delete();
            return 1;
        }
        $status = User::where('id',$request->id)->update(['is_available'=>$request->status]);
        if($status){
            return 1;
        }else{
            return 0;
        }
    }

    public function status_whatsapp(Request $request)
    {
        $status = User::where('id', $request->id)->update(['is_approved'=>$request->status]);
        if($status){
            return 1;
        }else{
            return 0;
        }
    }

    public function show($slug)
    {
        $plans = Plans::where('type', 1)->get();
        $rdata = User::where('slug',$slug)->first();
        return view('admin.restaurants.show',compact('rdata','plans'));
    }
    public function update(Request $request , $restaurant)
    {
        $rdata = User::where('slug',$restaurant)->first();
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$rdata->id,
            'mobile' => 'required|unique:users,mobile,'.$rdata->id,
        ],[ 
            "name.required"=>trans('messages.restaurant_name_required'),
            "email.required"=>trans('messages.email_required'),
            "email.email"=>trans('messages.valid_email'),
            "email.unique"=>trans('messages.email_exist'),
            "mobile.required"=>trans('messages.mobile_required'),
            "mobile.unique"=>trans('messages.mobile_exist')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $user = User::find($rdata->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->save();
            return redirect(route('restaurants'))->with('success',trans('messages.success'));
        }
    }
}
