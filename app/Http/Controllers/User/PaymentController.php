<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use MercadoPago;

class PaymentController extends Controller {
	function index() {

	}

	function purchase_plan(Request $request) {
		//REPLACE WITH YOUR ACCESS TOKEN AVAILABLE IN: https://developers.mercadopago.com/panel/credentials
		MercadoPago\SDK::setAccessToken("sk_test_1EnpJj3uGsLR4evZ");

		$preference = new MercadoPago\Preference();

		$item = new MercadoPago\Item();
        $item->title = $request->description;
        $item->quantity = $request->quantity;
        $item->unit_price = $request->price;

        $preference->items = array($item);

        $preference->back_urls = array(
            "success" => "http://localhost:8080/feedback",
            "failure" => "http://localhost:8080/feedback", 
            "pending" => "http://localhost:8080/feedback"
        );

        $preference->auto_return = "approved"; 

        $preference->save();

        $response = array(
            'id' => $preference->id,
        );

        return response()->json(['status' => 1, 'message' => json_encode($response)], 200);
	}
}
