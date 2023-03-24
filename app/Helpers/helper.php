<?php

namespace App\Helpers;

use App\Models\Settings;
use App\Models\User;
use App\Models\Timing;
use App\Models\Plans;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use Omnipay\Omnipay;
use Str;

class helper

{
    public static function gateway($str0, $str1)
    {
        $gateway = Omnipay::create('PayPal_Express');

        $gateway->setUsername($str0);
        $gateway->setPassword($str1);
        $gateway->setSignature("EOEwezsNWMWQM63xxxxxknr8QLoAOoC6lD_-kFqjgKxxxxxwGWIvsJO6vP3syd10xspKbx7LgurYNt9");
        //$gateway->setTestMod(false);
        return $gateway;
    }

    public static function webinfo($restaurant)
    {
        $webinfo = Settings::select(\DB::raw("CONCAT('" . asset('/storage/app/public/images/') . "/', logo) AS image"), \DB::raw("CONCAT('" . asset('/storage/app/public/images/') . "/', favicon) AS favicon"), 'copyright', 'address', 'timezone', 'country_code', 'contact', 'currency', 'currency_position', 'email', 'description', 'website_title', 'meta_title', 'meta_description', \DB::raw("CONCAT('" . asset('/storage/app/public/images/') . "/', og_image) AS og_image"), 'facebook_link', 'twitter_link', 'instagram_link', 'linkedin_link', 'delivery_type', 'whatsapp_widget', 'whatsapp_message', 'item_message', 'primary_color', 'secondary_color', 'language','template')
            ->where('restaurant', $restaurant)
            ->first();
        return $webinfo;
    }
    public static function timings($restaurant)
    {
        $timings = Timing::where('restaurant',@$restaurant)->get();
        return $timings;
    }
    public static function is_store_closed($restaurant)
    {
        date_default_timezone_set(Helper::webinfo(@$restaurant)->timezone);
        $todaydata = Timing::where('restaurant',@$restaurant)->where('day',date("l",strtotime(date('d-m-Y'))))->first();
            
            $current_time = \DateTime::createFromFormat('H:i a', date("h:i a"));
            $open_time = \DateTime::createFromFormat('H:i a', $todaydata->open_time);
            $close_time = \DateTime::createFromFormat('H:i a', $todaydata->close_time);
            if ($current_time > $open_time && $current_time < $close_time && $todaydata->is_always_close == 2) {
                $is_store_closed = 2;
            } else {
                $is_store_closed = 1;
            }
        return $is_store_closed;
    }

    public static function image_path($image)
    {
        $path = asset('storage/app/public/images/not-found');
        if (Str::contains($image, 'res')) {
            $path = asset('storage/app/public/vendor/' . $image);
        }
        if (Str::contains($image, 'item')) {
            $path = asset('storage/app/public/item/' . $image);
        }
        if (Str::contains($image, 'logo')) {
            $path = asset('storage/app/public/images/' . $image);
        }
        if (Str::contains($image, 'favicon')) {
            $path = asset('storage/app/public/images/' . $image);
        }
        if (Str::contains($image, 'og')) {
            $path = asset('storage/app/public/images/' . $image);
        }
        return $path;
    }

    public static function currency_format($price, $restaurant)
    {
        $currency = Settings::select('currency', 'currency_position')->where('restaurant', $restaurant)->first();
        $position = strtolower($currency->currency_position);
        if ($position == "left") {
            return $currency->currency . number_format($price, 2);
        }
        if ($position == "right") {
            return number_format($price, 2) . $currency->currency;
        }
    }

    public static function getrestaurant($restaurant)
    {

        $restaurantinfo = User::where('slug', $restaurant)->first();

        return $restaurantinfo;
    }

    public static function restauranttime($restaurant)
    {
        $webinfo = Settings::select('timezone')
            ->where('restaurant', $restaurant)
            ->first();

        date_default_timezone_set($webinfo->timezone);

        $t = date('d-m-Y');

        $time = Timing::select('close_time')
            ->where('restaurant', $restaurant)
            ->where('day', date("l", strtotime($t)))
            ->first();

        $txt = "Opened until " . date("D", strtotime($t)) . " " . $time->close_time . "";

        return $txt;
    }

    public static function restaurant_time_today($restaurant)
    {
        $webinfo = Settings::select('timezone')
            ->where('restaurant', $restaurant)
            ->first();

        date_default_timezone_set($webinfo->timezone);

        $t = date('d-m-Y');

        $time = Timing::select('close_time')
            ->where('restaurant', $restaurant)
            ->where('day', date("l", strtotime($t)))
            ->first();

        $txt = $time->close_time;

        return $txt;
    }

    public static function admininfo()
    {

        $admininfo = Settings::select('website_title', 'copyright', \DB::raw("CONCAT('" . asset('/storage/app/public/images/') . "/', logo) AS image"), \DB::raw("CONCAT('" . asset('/storage/app/public/images/') . "/', favicon) AS favicon"))
            ->where('restaurant', 1)
            ->first();

        return $admininfo;
    }

    public static function checkplan($restaurant)
    {
        date_default_timezone_set(Helper::webinfo($restaurant)->timezone);
        $restaurantinfo = User::where('id', $restaurant)->first();
        if ($restaurantinfo->is_verified == "2") {
            if ($restaurantinfo->is_available == "2") {
                return response()->json(['status' => 2, 'message' => trans('labels.restaurant_is_unavailable')], 200);
            }
            $checkplan = Plans::where('type', "!=", 2)->where('name', $restaurantinfo->plan)->first();
            $checkorder = Order::where('restaurant', $restaurant)->count();
            $checkitem = Item::where('restaurant', $restaurant)->count();

            if (!empty($checkplan)) {

                if (@$restaurantinfo->plan_app == 'PREMIUM') {
                    return response()->json(['status' => 1], 200);
                }

                if (@$checkplan->plan_period == '10') {
                    return response()->json(['status' => 1], 200);
                }

                if (@$checkplan->plan_period == "5") {
                    $purchasedate = date("Y-m-d", strtotime($restaurantinfo->purchase_date));
                    $exdate = date('Y-m-d', strtotime($purchasedate . ' + 7 days'));
                    $currentdate = date('Y-m-d');
                    if ($currentdate > $exdate) {
                        return response()->json(['status' => 2, 'message' => trans('labels.expired')], 200);
                    }
                }

                if (@$checkplan->plan_period == "1") {
                    $purchasedate = date("Y-m-d", strtotime($restaurantinfo->purchase_date));
                    $exdate = date('Y-m-d', strtotime($purchasedate . ' + 30 days'));
                    $currentdate = date('Y-m-d');
                    if ($currentdate > $exdate) {
                        return response()->json(['status' => 2, 'message' => trans('labels.expired')], 200);
                    }
                }
                if (@$checkplan->plan_period == "2") {
                    $purchasedate = date("Y-m-d", strtotime($restaurantinfo->purchase_date));
                    $exdate = date('Y-m-d', strtotime($purchasedate . ' +90 days'));
                    $currentdate = date('Y-m-d');
                    if ($currentdate > $exdate) {
                        return response()->json(['status' => 2, 'message' => trans('labels.expired')], 200);
                    }
                }
                if (@$checkplan->plan_period == "3") {
                    $purchasedate = date("Y-m-d", strtotime($restaurantinfo->purchase_date));
                    $exdate = date('Y-m-d', strtotime($purchasedate . ' +180 days'));
                    $currentdate = date('Y-m-d');
                    if ($currentdate > $exdate) {
                        return response()->json(['status' => 2, 'message' => trans('labels.expired')], 200);
                    }
                }
                if (@$checkplan->plan_period == "4") {
                    $purchasedate = date("Y-m-d", strtotime($restaurantinfo->purchase_date));
                    $exdate = date('Y-m-d', strtotime($purchasedate . ' +365 days'));
                    $currentdate = date('Y-m-d');
                    if ($currentdate > $exdate) {
                        return response()->json(['status' => 2, 'message' => trans('labels.expired')], 200);
                    }
                }
                if (@$checkplan->item_unit != -1) {
                    if (@$checkitem >= @$checkplan->item_unit) {
                        return response()->json(['status' => 2, 'message' => trans('messages.item_unit_exceeded')], 200);
                    } else {
                        if (@$checkplan->order_limit != -1) {
                            if ($checkorder >= @$checkplan->order_limit) {
                                return response()->json(['status' => 2, 'message' => trans('messages.order_limit_exceeded')], 200);
                            } else {
                                return response()->json(['status' => 1], 200);
                            }
                        } else {
                            return response()->json(['status' => 1], 200);
                        }
                    }
                } else {
                    return response()->json(['status' => 1], 200);
                }
            } else {
                if(@$restaurantinfo->plan_app == "PREMIUM") {
                    return response()->json(['status' => 1], 200);
                }

                return response()->json(['status' => 2, 'message' => trans('labels.restaurant_is_unavailable')], 200);
            }
        } else {
            if(@$restaurantinfo->plan == "EXPERT") {
                    return response()->json(['status' => 1], 200);
            }

            if(@$restaurantinfo->type == 1) {
                return response()->json(['status' => 1], 200);
            }
            
            return response()->json(['status' => 2, 'message' => trans('labels.restaurant_is_unavailable')], 200);
        }
    }

    public static function create_order_invoice($emaildata, $orderdata, $itemdata)
    {
        $data = ['title' => trans('labels.order_placed'), 'email' => $emaildata->email, 'name' => $emaildata->name, 'order_number' => $orderdata->order_number, 'orderdata' => $orderdata, 'itemdata' => $itemdata, 'logo' => Helper::webinfo($orderdata->restaurant)->image];

        try {
            Mail::send('Email.emailinvoice', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 1;
        }
    }

    public static function send_pass($email, $name, $password, $id){
        //$data = ['title'=>trans('labels.new_password'),'email'=>$email,'name'=>$name,'password'=>$password,'logo'=>Helper::webinfo($id)->image];
        try {
            // Mail::send('Email.email',$data,function($message)use($data){
            //     $message->from(env('MAIL_USERNAME'))->subject($data['title']);
            //     $message->to($data['email']);
            // });
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');
            $mail->Port = env('MAIL_PORT');
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->setFrom(env('MAIL_USERNAME'), 'Oneoutlet.site');
            $mail->addAddress($email, $name);
            $mail->Subject = 'Senha Nova';
            $mail->isHTML(true);
            $body = '<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Reset Password</title>
    <meta name="description" content="Reset Password">
    <style type="text/css">
        a:hover {text-decoration: underline !important;}
        * {
            font-family: "Arial";
        }
        p {
            color: #818181;
        }
    </style>
</head>
<body style="background-color: #f2f3f8;">
    <table width="100%">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%">
                    <tr>
                        <td>
                            <table width="95%" style="max-width:670px;background:#fff; border-radius:3px; -webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06); box-shadow:0 6px 18px 0 rgba(0,0,0,.06); padding-top: 30px;">
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1 style="color:#1e1e2d; font-weight:500;font-size:32px;">Esqueceu sua senha?</h1>
                                        <p>Prezado '.$name.', essa é a sua nova senha provisória.</p>
                                        <h2>'.$password.'</h2>
                                        <p>Mude a senha acessando o Painel Administrativo.</p>
                                        <p>Se você tiver algum problema, sinta-se à vontade para entrar em contato conosco.</p>
                                        <p>WhatsApp: (+55) 13 99606 9536, Email: oneoutlet@oneoutlet.site</p>
                                        <p style="margin-top: 10px;">Equipe de Suporte One Outlet.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>Oneoutlet.site</strong></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
            $mail->Body = $body;

            if (!$mail->send()) {
                return 0;
            } else {
              return 1;
            }
        } catch (\Throwable $th) {
            return 0;
        }
    }
}
