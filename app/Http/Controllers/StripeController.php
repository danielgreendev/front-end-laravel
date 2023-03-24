<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StripteController extends Controller {
  
  public function stripePost(Request $request)
  {
      $total_price = $request->total_amount;
      try {
          Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
          $paymentIntent = Stripe\PaymentIntent::create([
              "amount" => 100 * $total_price,
              // "amount" => 100 * 2,
              "currency" => "eur",
              'automatic_payment_methods' => [
                  'enabled' => true,
              ],
              "description" => $description,
          ]);
          $output = [
              'clientSecret' => $paymentIntent->client_secret,
          ];
          echo json_encode($output);
      } catch (Error $e) {
          http_response_code(500);
          echo json_encode(['error' => $e->getMessage()]);
      }
  }

  public function stripeorder () {
    require_once 'vendor/autoload.php';
    require_once 'vendor/secrets.php';

    \Stripe\Stripe::setApiKey($stripeSecretKey);

    function calculateOrderAmount(array $items): int {
        // Replace this constant with a calculation of the order's amount
        // Calculate the order total on the server to prevent
        // people from directly manipulating the amount on the client
        return 1400;
    }
 
    header('Content-Type: application/json');

    try {
        // retrieve JSON from POST body
        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => calculateOrderAmount($jsonObj->items),
            'currency' => 'brl',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        echo json_encode($output);
    } catch (Error $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
  }
}

    

?>