<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use Helper;

class LandingController extends Controller {
	public function index()
	{

	}

	public function sendMsg(Request $request) 
	{
    $name = trim($request->name);
    $email = trim($request->email);
    $title = trim($request->title);
    $message = trim($request->message);

    if (empty($name))
      return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
      return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    if (empty($title))
      return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    if (strlen($message) < 30)
      return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);

    $mail = new PHPMailer;
    $mail->isSMTP();
    //$mail->SMTPDebug = 2;
    $mail->Host = env('MAIL_HOST');
    $mail->Port = env('MAIL_PORT');
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = env('MAIL_ENCRYPTION');
    $mail->Username = env('MAIL_USERNAME');
    $mail->Password = env('MAIL_PASSWORD');
    $mail->setFrom(env('MAIL_USERNAME'), 'Oneoutlet.site');
    $mail->addReplyTo($email, $name);
    $mail->addAddress(env('MAIL_TO_NAME'), 'Support Team');
    $mail->Subject = $title;
    $mail->isHTML(true);
    //$mail->msgHTML('<h1>Hello, Hi</h1><p>Oneoutlet.site</p>');
    $body = '<h1>'.$title.'</h1>'.'<div><h3>From: </h3><p>Email: '.$email.'</p><p>'.$name.'</p></div><p>'.$message.'</p>';
    $mail->Body = $body;

    if (!$mail->send()) {
        return response()->json(['status' => 1, 'message' => trans('messages.failed')], 500);
    } else {
      return response()->json(['status' => 1, 'message' => 'success'], 200);
    }
	}
}