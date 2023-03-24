<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\Mercado;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\Cart;

class MercadoController extends Controller {

  public function mercadoorder(Request $request) {
    
    \MercadoPago\SDK::setAccessToken("TEST-7855953668068111-110615-562ebe44520cdb100578323a0501bd9a-485841852");

    $contents = json_decode(file_get_contents('php://input'), true);

    $payment = new \MercadoPago\Payment();
    $payment->transaction_amount = $contents['transaction_amount'];
    $payment->token = $contents['token'];
    $payment->installments = $contents['installments'];
    $payment->payment_method_id = $contents['payment_method_id'];
    $payment->issuer_id = $contents['issuer_id'];
    $payer = new \MercadoPago\Payer();
    $payer->email = $contents['payer']['email'];
    $payer->identification = array(
      "type" => $contents['payer']['identification']['type'],
      "number" => $contents['payer']['identification']['number']
    );
    $payment->payer = $payer;
    if ($payment->save()) {
         $response = array(
          'status' => $payment->status,
          'status_detail' => $payment->status_detail,
          'id' => $payment->id
        );
    
        return json_encode($response);
    } else {
        return json_encode(['error'=>'there is something wrong']);
    }
  }

  public function mercado_save(Request $request) {
    $mercado = new Mercado;

    $restaurant = $request->restaurant;

    if ($request->order_type == "2") {
        $delivery_charge = "0.00";
        $address = "";
        $building = "";
        $landmark = "";
        $order_type = "1";
    } else {
        $delivery_charge = $request->delivery_charge;
        $address = $request->address;
        $building = $request->building;
        $landmark = $request->landmark;
        $order_type = "2";
    }
    if ($request->discount_amount == "NaN") {
        $discount_amount = 0;
    } else {
        $discount_amount = $request->discount_amount;
    }
  
    $order_number = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 10)), 0, 15);

    $mercado->order_number = $order_number;

    $mercado->delivery_time = $request->delivery_time;
    $mercado->sub_total = $request->sub_total;
    // $mercado   = parseFloat($('#tax').val());
    $mercado->tax = $request->tax;
    $mercado->grand_total = $request->grand_total;
    $mercado->delivery_date = $request->delivery_date;
    $mercado->delivery_area = $request->delivery_area;
    $mercado->delivery_charge = $delivery_charge;
    $mercado->couponcode = $request->couponcode;
    $mercado->order_notes = $request->notes;
    $mercado->customer_name = $request->customer_name;
    $mercado->customer_email = $request->customer_email;
    $mercado->mobile = $request->customer_mobile;
    $mercado->restaurant = $restaurant;
    $mercado->payment_type = "Mercado";
    $mercado->delivery_date = date("Y-m-d");
    $mercado->created_at = date("Y-m-d h:m:sa");
    $mercado->updated_at = date("Y-m-d h:m:sa");
    $mercado->order_type = $order_type;
    $mercado->address = $address;
    $mercado->building = $building;
    $mercado->landmark = $landmark;
    $mercado->discount_amount = $discount_amount;
    $mercado->status = 1;

    $mercado->save();

    $transaction = new Transaction;
    $token = new Payment;
    

    $payment_id = $token->select("public_key")->where("restaurant", $restaurant)->first();

    $transaction->restaurant = $restaurant;
    $transaction->amount = $request->grand_total;
    $transaction->payment_id = $payment_id;
    $transaction->date = date("Y-m-d");
    $transaction->payment_type = "Mercado";
    $transaction->created_at = date("Y-m-d h:m:s a");
    $transaction->updated_at = date("Y-m-d h:m:s a");

    $transaction->save();
    
    
    $cart = new Cart;

    $cart->where("restaurant", $restaurant)->delete();

  }


}

    

?>