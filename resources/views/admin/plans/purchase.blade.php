@extends('admin.layout.main')
@section('page_title',trans('labels.pricing_plans'))
@section('content')

<?php 
  	
use Omnipay\Omnipay;

class Payment123
{
	public function gateway($a, $b)
	{
		$gateway = Omnipay::create('PayPal_Express');

		$gateway->setUsername($a);
		$gateway->setPassword($b);
		$gateway->setSignature("EOEwezsNWMWQM63xxxxxknr8QLoAOoC6lD_-kFqjgKxxxxxwGWIvsJO6vP3syd10xspKbx7LgurYNt9");
		//$gateway->setTestMod(false);
		return $gateway;
	}

	public function purchase(array $parameters)
	{
		$response = $this->gateway()->purchase($parameters)->send();

		return $response;
	}

	public function complete(array $parameters)
	{
		$response = $this->gateway()->completePurchase($parameters)->send();
		return $response;
	}

	public function formatAmount($amount)
	{
		return number_format($amount, 2, '.', '');
	}

	public function getCancelUrl($order = "")
	{
		return $this->route("http://Oneoutlet.site/", $order);
	}

	public function getReturnUrl($order = "")
   {
       return $this->route('http://Oneoutlet.site/src/License', $order);
   }

   public function route($name, $params)
   {
       return $name;
   }
}
 	ob_start();
 	session_start();

 	$payment = new Payment123;
 	$payment->gateway($paypal->public_key, $paypal->secret_key);
?>

<section id="content-types">
	<div class="row">
		<div class="col-12 mt-3 mb-1">
			<h4 class="content-header">{{trans('labels.pricing_plans')}}</h4>
		</div>
	</div>
	<div class="row match-height">
		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="card" style="height: 473px;">
				<div class="card-body">
					<div class="card-block">
						<h4 class="card-title">{{$plans->name}}</h4>
						<p class="card-text">{{$plans->description}}</p>
					</div>
					<ul class="list-group">
						<li class="list-group-item">
						<h4 class="card-title">{{Helper::currency_format($plans->price,1)}} / 
								@if($plans->plan_period == 5)
									{{trans('labels.7_days')}}
								@endif
								@if($plans->plan_period == 1)
									{{trans('labels.1_month')}}
								@endif
								@if($plans->plan_period == 2)
									{{trans('labels.3_month')}}
								@endif
								@if($plans->plan_period == 3)
									{{trans('labels.6_month')}}
								@endif
								@if($plans->plan_period == 4)
									{{trans('labels.1_year')}}
								@endif
							</h4>
						</li>
						<li class="list-group-item"><i class="ft-check"></i>
							@if ($plans->item_unit == -1)
								{{trans('labels.item_unlimited')}}
							@else {{$plans->item_unit}} {{trans('labels.item_limit')}}@endif
						</li>
						<li class="list-group-item"><i class="ft-check"></i>
							@if ($plans->order_limit == -1)
								{{trans('labels.item_unlimited')}}
							@else {{$plans->item_unit}} {{trans('labels.order_limit')}} @endif </li>
						<?php
						$myString = $plans->features;
						$myArray = explode(',', $myString);
						?>
						@foreach($myArray as $features)
						<li class="list-group-item"><i class="ft-check"></i> {{$features}}</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="card" style="height: 473px;">
				<div class="card-body">
					<div class="card-block">
						<h4 class="card-title">{{trans('labels.select_payment')}}</h4>
					</div>
					@foreach ($paymentlist as $key => $payment)
					<div class="list-group-item">
						<!-- Radio -->
						<div class="custom-control custom-radio">
							<!-- Input -->
							<input class="custom-control-input" onclick="selectPayMethod(event)" id="{{$payment->payment_name}}" data-payment_type="{{$payment->payment_name}}" name="payment" type="radio" @if (!$key) {!! "checked" !!} @endif>
							<!-- Label -->
							<label class="custom-control-label font-size-sm text-body text-nowrap payment_icon" for="{{$payment->payment_name}}">
								@if($payment->payment_name == "RazorPay")
								<div>
									<img src="{{asset('storage/app/public/payment/razorpay.png')}}" class="ml-2" alt="" width="30px" />
									<input type="hidden" name="razorpay" id="razorpay" value="{{$payment->public_key}}">{{$payment->payment_name}}
								</div>
								@endif
								@if($payment->payment_name == "Stripe")
								<div>
									<img src="{{asset('storage/app/public/payment/stripe.png')}}" class="ml-2" alt="" width="30px" />
									<input type="hidden" name="stripe" id="stripe" value="{{$payment->public_key}}">{{$payment->payment_name}}
								</div>
								@endif
								@if($payment->payment_name == "PayPal")
								<div>
									<img src="{{asset('storage/app/public/payment/paypal.svg')}}" class="ml-2" alt="" width="30px" /> {{$payment->payment_name}}
								</div>
								<form class="form-horizontal" method="POST" action="{{$paypal->ifsc}}" id="payment-form" validate>@csrf
					                <input id="amount_paypal" name="amount" type="hidden" value="{{$plans->price}}">
					                <input id="business" type='hidden' name='business' value='{{$payment->public_key}}'>
					                <input id="item_name" type='hidden' name='item_name' value='{{$plans->name}}'>
					                <input id="payer_email" type='hidden' name='payer_email' value="{{Helper::getrestaurant(Auth::user()->slug)->email}}">
					                <input id="payer_name" type='hidden' name='payer_name' value="{{Helper::getrestaurant(Auth::user()->slug)->name}}">
					                <input type='hidden' class="form-control" name='item_number' value="43543534523423535" required>
					                <input type='hidden' id="no_shipping" name='no_shipping' value='1'>
					                <input type='hidden' id="currency_code" name='currency_code' value='USD'>
					                <input type='hidden' id="notify_url" name='notify_url' value="{{ URL::to('/vendor/plans/notify') }}">
					                <input type='hidden' id="cancel_return" name='cancel_return' value="{{ URL::to('/vendor/plans') }}">
					                <input type='hidden' name='return' id="return_pay" value="{{ URL::to('/vendor/plans/notify/success/') }}">
					                <input name="txn_type" type="hidden" value="web_accept" />
					                <input name="txn_id" type="hidden" value="CUSTOMER" />
					                <input type="hidden" name="cmd" value="_xclick">
					                <button type="submit" name="pay_now" id="btn_paypal" class="btn btn-raised btn-success btn-min-width" disabled>ADQUIRIR</button>
					              </form>
								@endif
							</label>
						</div>
					</div>
					@endforeach
				</div>
				<div class="card-block">
					@if (env('Environment') == 'sandbox')
					<button onclick="myFunction()" class="btn btn-raised btn-success btn-min-width mr-1 mb-1">{{trans('labels.buy_now')}}</button>
					@else
					<button onclick="Paynow(event)" class="btn btn-raised btn-success btn-min-width mr-1 mb-1" id="pay_payment">{{trans('labels.buy_now')}}</button>
					@endif
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="plan" id="plan" value="{{$plans->name}}">
	<input type="hidden" name="amount" id="amount" value="{{$plans->price}}">
	<input type="hidden" name="plan_period" id="plan_period" value="{{$plans->plan_period}}">
	<input type="hidden" name="email" id="email" value="{{Helper::getrestaurant(Auth::user()->slug)->email}}">
	<input type="hidden" name="mobile" id="mobile" value="{{Helper::getrestaurant(Auth::user()->slug)->mobile}}">
	<input type="hidden" name="name" id="name" value="{{Helper::getrestaurant(Auth::user()->slug)->name}}">
</section>
@endsection
@section('scripts')
<script src="{{asset('resources/views/admin/plans/plans.js')}}" type="text/javascript"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://checkout.stripe.com/v2/checkout.js"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script type="text/javascript">
	$("#btn_paypal").prop('disabled', true);

	function selectPayMethod(e)
	{
		if (e.target.id == "PayPal") {
			$("#btn_paypal").prop('disabled', false);
			$("#pay_payment").prop('disabled', true);
		}
		else {
			$("#btn_paypal").prop('disabled', true);
			$("#pay_payment").prop('disabled', false);
		}
	}

	function Paynow(e) {
		"use strict";
		var payment_type = $('input[name="payment"]:checked').attr("data-payment_type");
		var flutterwavekey = $('#flutterwavekey').val();
		var paystackkey = $('#paystackkey').val();
		var plan = $('#plan').val();
		var plan_period = $('#plan_period').val();
		var email = $('#email').val();
		var mobile = $('#mobile').val();
		var amount = $('#amount').val();
		var name = $('#name').val();
		//Razorpay
		if (payment_type == "RazorPay") {
			var options = {
				"key": $('#razorpay').val(),
				"amount": (parseInt(amount * 10000)), // 2000 paise = INR 20
				"name": name,
				"description": "Plan payment",
				"image": "{{asset('storage/app/vendor/'.Helper::getrestaurant(Auth::user()->slug)->image)}}",
				"handler": function(response) {
					$('#preloader').show();
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: "{{ URL::to('/vendor/plans/order') }}",
						type: 'POST',
						dataType: 'json',
						data: {
							payment_id: response.razorpay_payment_id,
							amount: amount,
							payment_type: "RazorPay",
							plan: plan,
							plan_period: plan_period,
						},
						success: function(response) {
							$('#preloader').hide();
							if (response.status == 1) {
								window.location.href = "{{ URL::to('/vendor/plans')}}";
							}
						},
						error: function(error) {
							$('#preloader').hide();
							paymentError("{{trans('messages.razor_payment_error')}}");
						}
					});
				},
				"prefill": {
					"contact": mobile,
					"email": email,
					"name": name,
				},
				"theme": {
					"color": "#366ed4"
				}
			};
			var rzp1 = new Razorpay(options);
			rzp1.open();
			e.preventDefault();
		}
		//Stripe
		if (payment_type == "Stripe") {
			$('#preloader').show();
			var handler = StripeCheckout.configure({
				key: $('#stripe').val(),
				image: "{{asset('storage/app/vendor/'.Helper::getrestaurant(Auth::user()->slug)->image)}}",
				locale: 'auto',
				token: function(token) {
					// You can access the token ID with `token.id`.
					// Get the token ID to your server-side code for use.
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: "{{ URL::to('/vendor/plans/order') }}",
						data: {
							stripeToken: token.id,
							email: email,
							name: name,
							amount: amount,
							payment_type: "Stripe",
							plan: plan,
							plan_period: plan_period,
						},
						method: 'POST',
						success: function(response) {
							$('#preloader').hide();
							if (response.status == 1) {
								window.location.href = "{{ URL::to('/vendor/plans')}}";
							}
						},
						error: function(error) {
							$('#preloader').hide();
							paymentError("{{trans('messages.stripe_payment_error')}}");
						}
					});
				},
				opened: function() {
					$('#preloader').hide();
				},
				closed: function() {
					$('#preloader').hide();
				}
			});
			//Stripe Popup
			handler.open({
				name: name,
				description: 'Plan payment',
				amount: amount * 100,
				currency: "USD",
				email: email
			});
			e.preventDefault();
			// Close Checkout on page navigation:
			$(window).on('popstate', function() {
				handler.close();
			});
		}
	}
</script>
<link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/plans/plans.css')}}">
@endsection