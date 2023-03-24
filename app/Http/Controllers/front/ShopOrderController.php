<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Twilio\Rest\Client;
use Twilio\Exception\RestException;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use App\Models\Notifications;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Pusher;
use Helper;
use URL;

class NotificationTemplate {
  public string $sender;
  public string $type;
  public string $content;
  public string $timestamp;
  public string $period;
  public string $fullperiod;
}

class ShopOrderController extends Controller {
	public function index()
	{

	}

	public function sendMsg(Request $request) 
	{
    // $options = array(
    //         'cluster' => 'sa1',
    //         'useTLS' => true
    //       );
    //       $pusher = new Pusher\Pusher(
    //         '2f9ada63fb2c26d046f9',
    //         '4c90851a4b7b62cfc05c',
    //         '1522409',
    //         $options
    //       );

    //       $data['message'] = 'hello world';
    //       $pusher->trigger('my-channel', 'my-event', $data);
    // Instantiate the WhatsAppCloudApi super class.
    // $whatsapp_cloud_api = new WhatsAppCloudApi([
    //     'from_phone_number_id' => '870237347343111',
    //     'access_token' => 'EAAMXeev1awcBAITueI1m821B3gotSxGZBCmHpKmvBTaPyyalXNTUyIPff2r1P8YFswO6b4Sj1DZCejgl98olZBnbR9NYRvknAJNRZByLFQQytxddu4HENzPE6CqcaiwaFgLCycInfGmJwPtv7zuAZAZCqJFS8lDfNsH9IWGftrwelTUewCOFxi',
    // ]);
    // $whatsapp_cloud_api->sendTextMessage('+5513997541840', 'Hey there!');
    // return response()->json(['status' => 1, 'message' => 'success'], 200);
    // $phone="+5513 997541840";  // Enter your phone number here
    // $apikey="Lxn8cH9S55AS";       // Enter your personal apikey received in step 3 above
    // $message = "This is test";
    // $url='https://api.callmebot.com/whatsapp.php?source=php&phone='.$phone.'&text='.$message.'&apikey='.$apikey;

    // if($ch = curl_init($url))
    // {
    //     curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //     $html = curl_exec($ch);
    //     $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     // echo "Output:".$html;  // you can print the output for troubleshooting
    //     curl_close($ch);
    //     return (int) $status;
    // }
    // else
    // {
    //     return false;
    // }
    // return response()->json(['status' => 1, 'message' => 'success'], 200);
    try {
      $order = Order::where('order_number', $request->info)->first();

      if ($order == null)
        return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    	$twilio = new Client(env('TWILIO_AUTH_SID'), env('TWILIO_AUTH_TOKEN'));
      $message = $twilio->account->messages
        ->create('whatsapp:'.$request->mobile, // to
          [
           'from' => 'whatsapp:+14155238886',
           'body' => $request->msg,
          ]
      );
        
      return response()->json(['status' => 1, 'message' => 'success'], 200);
    } catch (\Twilio\Exceptions\RestException $e) {
      	return response()->json(['status' => 1, 'message' => $e], 500);
    }
	}

  public function notifyMonitoring(Request $request) {
    if ($request->info != 'notification')
      return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    $user = User::where('email', $request->email)->where('slug', $request->name)->first();

    if ($user == null || $user->type == 3)
      return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    if ($request->type != 'onload' && $request->type != 'event' && $request->type != "onstart")
      return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    $notifies = null;
    if ($request->type == 'event') {
      $notifies = Notifications::where('restaurant', $user->id)->where('is_deleted', 2)->where('is_new', 2)->orderBy('created_at', 'DESC')->get();
      Notifications::where('restaurant', $user->id)->where('is_deleted', 2)
        ->update([
        'is_new'=> 1
      ]);
    }
    else if ($request->type == 'onload') {
      $notifies = Notifications::where('restaurant', $user->id)->where('is_deleted', 2)->where('is_new', 1)->where('is_read', 2)->orderBy('created_at', 'DESC')->get();
    }
    else if ($request->type == 'onstart') {
      $notifies = Notifications::where('restaurant', $user->id)->where('is_deleted', 2)->orderBy('created_at', 'DESC')->get();
    }

    if ($notifies == null || empty($notifies) || count($notifies) == 0)
      return response()->json(['status' => 0, 'message' => 'success'], 200);

    $items = [];
    $date = date("Y-m-d h:i:sa");

    foreach ($notifies as $element) {
      $item = new NotificationTemplate;
      $item->sender = $element->sender;
      $item->type = $element->type;
      $item->contents = $element->contents;
      $item->timestamp = $element->timestamp;
      $period = (strtotime($date) - strtotime($element->created_at));
      $item->fullperiod = $period;
      $temp = intval($period / 86400);
      if ($temp > 1) {
        $item->period = $temp.' dia';
        if ($temp > 2)
          $item->period .= 's';
      }
      else if ($period / 3600 > 1) {
        $temp = intval($period / 3600);
        $item->period = $temp.' hora';
        if($temp > 2)
          $item->period .= 's';
        $temp = intval($period % 3600 / 60);
        if ($temp > 1) {
          $item->period .= ' e '.$temp.' minuto';
          if($temp > 2)
            $item->period .= 's';
        }
      }
      else if ($period / 60 > 1) {
        $temp = intval($period / 60);
        $item->period = $temp.' minuto';
        if($temp > 2)
          $item->period .= 's';
      }
      else if ($period > 1) {
        $temp = $period;
        $item->period = $temp.' second';
        if($temp > 2)
          $item->period .= 's';
      }
      array_push($items, $item);
    }

    return response()->json(['status' => 1, 'message' => $items], 200);    
  }

  public function notifyControl(Request $request) {
    if ($request->info != 'notification')
      return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    if ($request->type != 'delete' && $request->type != 'update')
      return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    $user = User::where('email', $request->email)->where('slug', $request->name)->first();

    if ($user == null || $user->type == 3)
      return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    if ($request->type == 'delete') {
      $notify = Notifications::where('restaurant', $user->id)->where('timestamp', $request->data)->where('is_deleted', 2)->first();

      if ($notify == null)
        return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

      Notifications::where('restaurant', $user->id)->where('timestamp', $request->data)->where('is_deleted', 2)->update([
        'is_deleted' => 1
      ]);
    }
    else if ($request->type == 'update')
    {
      foreach($request->data as $item) {
        $notify = Notifications::where('restaurant', $user->id)->where('timestamp', $item)->where('is_deleted', 2)->first();

        if ($notify == null)
          return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

        Notifications::where('restaurant', $user->id)->where('timestamp', $item)->where('is_deleted', 2)->update([
          'is_read' => 1
        ]);

        Notifications::where('is_deleted', 1)->whereDate('created_at', '<=', now()->subDays(2))
          ->update([
            'is_deleted' => 1,
        ]);
      }
    }

    return response()->json(['status' => 1, 'message' => 'success'], 200);
  }

  public function notifications() {
    Notifications::where('restaurant', Auth::user()->id)->where('is_deleted', 2)->where('is_new', 2)
      ->update([
      'is_new'=> 1
    ]);
    $notifications = Notifications::where('restaurant', Auth::user()->id)->where('is_deleted', 2)->get();
    return view('admin.notifications.index', compact('notifications'));
  }
}