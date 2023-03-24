@include('front.theme.header')
<?php 
    
use Omnipay\Omnipay;

class Payment125
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

    $payment = new Payment125;
    $payment->gateway($user->user_id, $user->name);
?>


<section class="cart">
    <div class="container">
        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{ trans('labels.my_cart') }}
            @if (Helper::webinfo($getrestaurant->id)->delivery_type == "delivery")
            <span class="text-danger">{{Helper::getrestaurant($getrestaurant->slug)->name}} {{trans('labels.provide_only_delivery')}}</span>
            @endif
            @if (Helper::webinfo($getrestaurant->id)->delivery_type == "pickup")
            <span class="text-danger">{{Helper::getrestaurant($getrestaurant->slug)->name}} {{trans('labels.provide_only_pickup')}}</span>
            @endif
        </h2>
        <div class="row">
            @if (count($cartdata) == 0)
            <p>No Data found</p>
            @else
            <div class="col-lg-8">
                @foreach ($cartdata as $cart)
                <?php
                $data[] = array(
                    "total_price" => $cart->qty * $cart->price,
                    "tax" => ($cart->qty * $cart->price) * $cart->tax / 100
                );
                ?>
                <div class="cart-box">
                    <div class="cart-pro-img">
                        <img src="{{asset('storage/app/public/item/'.$cart->item_image)}}" alt="">
                    </div>
                    <div class="cart-pro-details">
                        <div class="cart-pro-edit">
                            <a href="#" class="cart-pro-name {{session()->get('direction') == 2 ? 'text-right' : '' }}">
                                {{$cart->item_name}} -
                                @if ($cart->variants_id != "")
                                {{$cart->variants_name}}
                                <span>
                                    {{Helper::currency_format($cart->variants_price,$getrestaurant->id)}}
                                </span>
                                @else
                                <span>
                                    {{Helper::currency_format($cart->item_price,$getrestaurant->id)}}
                                </span>
                                @endif
                            </a>
                            <a href="javascript:void(0)"><i class="fal fa-trash-alt" onclick="RemoveCart('{{$cart->id}}')"></i></a>
                        </div>
                        <div class="cart-pro-edit">
                            <div class="pro-add">
                                <div class="value-button sub" id="decrease" onclick="qtyupdate('{{$cart->id}}','{{$cart->item_id}}','decreaseValue')" value="Decrease Value">
                                    <i class="fal fa-minus-circle"></i>
                                </div>
                                <input type="number" id="number_{{$cart->id}}" name="number" value="{{$cart->qty}}" min="1" style="background-color: #f7f7f7;" />
                                <div class="value-button add" id="increase" onclick="qtyupdate('{{$cart->id}}','{{$cart->item_id}}','increase')" value="Increase Value">
                                    <i class="fal fa-plus-circle"></i>
                                </div>
                            </div>
                            <p class="cart-pricing">{{Helper::currency_format($cart->qty * $cart->price,$getrestaurant->id)}}</p>
                        </div>

                        @if ($cart->extras_id != "")
                        <div class="cart-addons-wrap">
                            <?php
                            $extras_id = explode(",", $cart->extras_id);
                            $extras_price = explode(",", $cart->extras_price);
                            $extras_name = explode(",", $cart->extras_name);
                            ?>
                            @foreach ($extras_id as $key => $addons)
                            <div class="cart-addons">
                                <b>{{$extras_name[$key]}}</b> : <b style="color: #000; text-align: center;">{{Helper::currency_format($extras_price[$key],$getrestaurant->id)}}</b>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                <center>
                    <div class="col-lg-6 mt-3">
                        <div class="cart-delivery-type open">
                            @if (Helper::webinfo($getrestaurant->id)->delivery_type == "delivery")
                            <label for="cart-delivery">
                                <input type="radio" name="cart-delivery" id="cart-delivery" checked value="1">
                            </label>
                            @endif
                            @if (Helper::webinfo($getrestaurant->id)->delivery_type == "pickup")
                            <label for="cart-pickup">
                                <input type="radio" name="cart-delivery" id="cart-pickup" checked value="2">
                            </label>
                            @endif
                            @if (Helper::webinfo($getrestaurant->id)->delivery_type == "both")
                            <label for="cart-delivery">
                                <input type="radio" name="cart-delivery" id="cart-delivery" checked value="1">
                                <div class="cart-delivery-type-box">
                                    <p>{{ trans('labels.delivery') }}</p>
                                </div>
                            </label>
                            <label for="cart-pickup">
                                <input type="radio" name="cart-delivery" id="cart-pickup" value="2">
                                <div class="cart-delivery-type-box">
                                    <p>{{ trans('labels.pickup') }}</p>
                                </div>
                            </label>
                            @endif
                        </div>
                    </div>
                </center>
                <div class="col-12 mt-3" style="display: none;">
                    <div class="cart-summary">
                        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}" id="delivery_date">{{trans('labels.delivery_date')}}</h2>
                        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}" id="pickup_date" style="display: none;">{{trans('labels.pickup_date')}}</h2>
                        <div class="promo-wrap mt-3">
                            <input type="date" name="delivery_date" id="delivery_dt" placeholder="{{ trans('messages.select_delivery_date') }}">
                        </div>
                        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}" id="delivery">{{trans('labels.delivery_time')}}</h2>
                        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}" id="pickup" style="display: none;">{{trans('labels.pickup_time')}}</h2>
                        <div class="promo-wrap mt-3">
                            <select name="delivery_time" id="delivery_time" class="form-control">
                                <option value="none">{{trans('labels.select')}}</option>
                                <option value="10:00 - 10:30">10:00 - 10:30</option>
                                <option value="10:30 - 11:00">10:30 - 11:00</option>
                                <option value="11:00 - 11:30">11:00 - 11:30</option>
                                <option value="11:30 - 12:00">11:30 - 12:00</option>
                                <option value="12:00 - 12:30">12:00 - 12:30</option>
                                <option value="12:30 - 13:00">12:30 - 13:00</option>
                                <option value="13:00 - 13:30">13:00 - 13:30</option>
                                <option value="13:30 - 14:00">13:30 - 14:00</option>
                                <option value="14:00 - 14:30">14:00 - 14:30</option>
                                <option value="14:30 - 15:00">14:30 - 15:00</option>
                                <option value="15:00 - 15:30">15:00 - 15:30</option>
                                <option value="15:30 - 16:00">15:30 - 16:00</option>
                                <option value="16:00 - 16:30">16:00 - 16:30</option>
                                <option value="16:30 - 17:00">16:30 - 17:00</option>
                                <option value="17:00 - 17:30">17:00 - 17:30</option>
                                <option value="17:30 - 18:00">17:30 - 18:00</option>
                                <option value="18:00 - 18:30">18:00 - 18:30</option>
                                <option value="18:30 - 19:00">18:30 - 19:00</option>
                                <option value="19:00 - 19:30">19:00 - 19:30</option>
                                <option value="19:30 - 20:00">19:30 - 20:00</option>
                                <option value="20:00 - 20:30">20:00 - 20:30</option>
                                <option value="20:30 - 21:00">20:30 - 21:00</option>
                                <option value="21:00 - 21:30">21:00 - 21:30</option>
                                <option value="21:30 - 22:00">21:30 - 22:00</option>
                                <option value="22:00 - 22:30">22:00 - 22:30</option>
                                <option value="22:30 - 23:00">22:30 - 23:00</option>
                                <option value="23:00 - 23:30">23:00 - 23:30</option>
                                <option value="23:30 - 0:00">23:30 - 0:00</option>
                                <option value="0:00 - 0:30">0:00 - 0:30</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3" id="open">
                    <div class="cart-summary">
                        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{trans('labels.delivery_info')}}</h2>
                        <div class="promo-wrap mt-3">
                            <select name="delivery_area" id="delivery_area" class="form-control">
                                @if(count($deliveryarea) == 0)
                                    <option value="none" price="0">{{trans('labels.no_select_delivery_type')}}</option>
                                @endif
                                @foreach ($deliveryarea as $area)
                                <option value="{{$area->name}}" price="{{$area->price}}">{{$area->name}} - {{Helper::currency_format($area->price,$getrestaurant->id)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="promo-wrap mt-3">
                            <input type="text" placeholder="{{ trans('messages.enter_delivery_address') }}" name="address" id="address" required="">
                        </div>
                        <div class="promo-wrap">
                            <input type="text" placeholder="{{ trans('messages.enter_building') }}" name="building" id="building" required="">
                        </div>
                        <div class="promo-wrap">
                            <input type="text" placeholder="{{ trans('messages.enter_landmark') }}" name="landmark" id="landmark" required="">
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="cart-summary">
                        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{trans('labels.customer')}}</h2>
                        <div class="promo-wrap">
                            <input type="text" placeholder="{{ trans('labels.enter_name') }}" name="customer_name" id="customer_name" required="">
                        </div>
                        <div class="promo-wrap input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="ft-mobile">+55</i>
                                </span>
                            </div>
                            <input type="text" class="form-control form_text" placeholder="{{ trans('messages.enter_contact_number_required') }}" name="customer_mobile" id="customer_mobile" required="" onblur="checkphone()">
                        </div>
                        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{ trans('labels.notes') }}</h2>
                        <div class="promo-wrap mt-3">
                            <textarea name="notes" id="notes" placeholder="{{ trans('labels.enter_order_note') }}" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="restaurant" name="restaurant" value="{{Helper::getrestaurant($getrestaurant->slug)->id}}" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-3">
                <?php
                $sub_total = array_sum(array_column(@$data, 'total_price'));
                $tax = array_sum(array_column(@$data, 'tax'));
                $total = array_sum(array_column(@$data, 'total_price'));
                ?>
                <div class="cart-summary">
                    <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{ trans('labels.payment_summary') }}</h2>
                    <p class="pro-total" id="subtotal">{{ trans('labels.sub_total') }} <span>{{Helper::currency_format($sub_total,$getrestaurant->id)}}</span></p>
                    <!-- <p class="pro-total">{{ trans('labels.tax') }} <span>{{Helper::currency_format($tax,$getrestaurant->id)}}</span></p> -->
                    <p class="pro-total" id="delivery_charge_hide">{{ trans('labels.delivery_charge') }}<span id="shipping_charge">{{Helper::currency_format('0.0',$getrestaurant->id)}}</span></p>
                    @if (Session::has('offer_amount'))
                    <p class="pro-total offer_amount">{{ trans('labels.discount') }} ({{Session::get('offer_code')}})</span>
                        <span id="offer_amount">
                            - {{Helper::currency_format(Session::get('offer_amount'),$getrestaurant->id)}}
                        </span>
                    </p>
                    @endif
                    @if (Session::has('offer_amount'))
                    <p class="cart-total">{{ trans('labels.total_amount') }} <span id="total_amount">
                            {{Helper::currency_format($total-Session::get('offer_amount'),$getrestaurant->id)}}
                        </span></p>
                    @else
                    <p class="cart-total">{{ trans('labels.total_amount') }} <span id="total_amount">{{Helper::currency_format($total,$getrestaurant->id)}}</span></p>
                    @endif
                    @if (App\Models\SystemAddons::where('unique_identifier', 'coupons')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'coupons')->first()->activated)
                    @if (Session::has('offer_amount'))
                    <div class="promo-code mt-3">
                        <div class="promo-wrap">
                            <input type="text" name="removepromocode" id="removepromocode" autocomplete="off" readonly="" value="{{Session::get('offer_code')}}">
                            <button class="btn" onclick="RemoveCopon()">{{ trans('labels.remove') }}</button>
                        </div>
                    </div>
                    @else
                    <div class="promo-code mt-3">
                        <div class="promo-wrap">
                            <input type="text" placeholder="{{ trans('messages.enter_promocode') }}" name="promocode" id="promocode" autocomplete="off">
                            <button class="btn" onclick="ApplyCopon()">{{ trans('labels.apply') }}</button>
                        </div>
                    </div>
                    @endif
                    @endif
                    <input type="hidden" name="sub_total" id="sub_total" value="{{$sub_total}}">
                    <!-- <input type="hidden" name="tax" id="tax" value="{{$tax}}"> -->
                    <input type="hidden" name="delivery_charge" id="delivery_charge" value="0">
                    @if (Session::has('offer_amount'))
                    <input type="hidden" name="grand_total" id="grand_total" value="{{number_format($total-Session::get('offer_amount'), 2)}}">
                    @else
                    <input type="hidden" name="grand_total" id="grand_total" value="{{number_format($total, 2)}}">
                    @endif


                    
                    <div class="mt-3">
                        <button class="btn btn-block" data-toggle="modal" data-target="#cardPaymentBrick_container" onclick='requestpayment()' id="btn-send">
                            Send Request
                        </button>
                    </div>
                </div>
                <div class="cart-summary mt-3" id="payForm" style="display: none;">
                    <div id="payment">     </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    <form class="form-horizontal" method="POST" action="{{$user->url}}" id="payment-form" validate>@csrf
        <input id="amount_paypal" name="amount" type="hidden" value="">
        <input id="business" type='hidden' name='business' value='{{$user->user_id}}'>
        <input id="item_name" type='hidden' name='item_name' value='Order'>
        <input id="payer_email" type='hidden' name='payer_email' value="">
        <input id="payer_name" type='hidden' name='payer_name' value="">
        <input type='hidden' class="form-control" name='item_number' value="43543534523423535" required>
        <input type='hidden' id="no_shipping" name='no_shipping' value='1'>
        <input type='hidden' id="currency_code" name='currency_code' value='BRL'>
        <input type='hidden' id="notify_url" name='notify_url' value="">
        <input type='hidden' id="cancel_return" name='cancel_return' value="">
        <input type='hidden' name='return' id="return_pay" value="">
        <input name="txn_type" type="hidden" value="web_accept" />
        <input name="txn_id" type="hidden" value="CUSTOMER" />
        <input type="hidden" name="cmd" value="_xclick">
        <button name="pay_now" id="btn_paypal" class="btn btn-raised btn-success btn-min-width" disabled style="display: none;">ADQUIRIR</button>
    </form>

    <input type="hidden" id="delivery_time_required" value="{{trans('messages.delivery_time_required')}}">
    <input type="hidden" id="delivery_date_required" value="{{trans('messages.delivery_date_required')}}">
    <input type="hidden" id="address_required" value="{{trans('messages.address_required')}}">
    <input type="hidden" id="address_at_least" value="{{trans('messages.address_at_least')}}">
    <input type="hidden" id="no_required" value="{{trans('messages.no_required')}}">
    <input type="hidden" id="building_at_least" value="{{trans('messages.building_at_least')}}">
    <input type="hidden" id="landmark_required" value="{{trans('messages.landmark_required')}}">
    <input type="hidden" id="delivery_area" value="{{trans('messages.delivery_area')}}">
    <input type="hidden" id="pickup_time_required" value="{{trans('messages.pickup_time_required')}}">
    <input type="hidden" id="customer_mobile_required" value="{{trans('messages.customer_mobile_required')}}">
    <input type="hidden" id="customer_email_required" value="{{trans('messages.customer_email_required')}}">
    <input type="hidden" id="customer_name_required" value="{{trans('messages.customer_name_required')}}">
    <input type="hidden" id="currency" value="{{Helper::webinfo($getrestaurant->id)->currency}}">
    @if (Session::has('offer_amount'))
    <input type="hidden" name="discount_amount" id="discount_amount" value="{{Session::get('offer_amount')}}">
    <input type="hidden" name="couponcode" id="couponcode" value="{{Session::get('offer_code')}}">
    @else
    <input type="hidden" name="discount_amount" id="discount_amount" value="">
    <input type="hidden" name="couponcode" id="couponcode" value="">
    @endif

    <div id="success-msg" style="display : none">Check out successfully!</div>
</section>
@include('front.theme.footer')
<link rel="stylesheet" href="{{asset('resources/views/front/cart.css')}}" />
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://checkout.stripe.com/v2/checkout.js"></script>
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>

<script>
    $(document).ready(function() {
        $("input[name$='cart-delivery']").click(function() {
            var test = $(this).val();
            if (test == 1) {
                $("#open").show();
                $("#delivery_charge_hide").show();
                $("#delivery").show();
                $("#pickup").hide();
                $("#delivery_date").show();
                $("#pickup_date").hide();
                var sub_total = parseFloat($('#sub_total').val());
                var delivery_charge = parseFloat($('#delivery_charge').val());
                //var tax = parseFloat($('#tax').val());
                var tax = 0;
                var discount_amount = parseFloat($('#discount_amount').val());
                if (isNaN(discount_amount)) {
                    $('#total_amount').text(currency_format(parseFloat(sub_total + tax + delivery_charge)));
                    $('#grand_total').val((sub_total + tax + delivery_charge).toFixed(2));
                } else {
                    $('#total_amount').text(currency_format(parseFloat(sub_total + tax + delivery_charge - discount_amount)));
                    $('#grand_total').val((sub_total + tax + delivery_charge - discount_amount).toFixed(2));
                }
            } else {
                $("#open").hide();
                $("#delivery_charge_hide").hide();
                $("#delivery").hide();
                $("#pickup").show();
                $("#delivery_date").hide();
                $("#pickup_date").show();
                var sub_total = parseFloat($('#sub_total').val());
                var delivery_charge = parseFloat($('#delivery_charge').val());
                //var tax = parseFloat($('#tax').val());
                var tax = 0;
                var discount_amount = parseFloat($('#discount_amount').val());
                if (isNaN(discount_amount)) {
                    $('#total_amount').text(currency_format(parseFloat(sub_total + tax)));
                    $('#grand_total').val((sub_total + tax).toFixed(2));
                } else {
                    $('#total_amount').text(currency_format(parseFloat(sub_total + tax - discount_amount)));
                    $('#grand_total').val((sub_total + tax - discount_amount).toFixed(2));
                }
            }
        });

        if ("{{Helper::webinfo($getrestaurant->id)->delivery_type}}" != "both") {
            $(function() {
                $("input[name$='cart-delivery']").click();
            });
        }
    });
    $("#delivery_area").change(function() {
        var currency = parseFloat($('#currency').val());
        var deliverycharge = $('option:selected', this).attr('price');
        $('#shipping_charge').text(currency_format(deliverycharge));
        $('#delivery_charge').val(deliverycharge);
        var sub_total = parseFloat($('#sub_total').val());
        var delivery_charge = parseFloat($('#delivery_charge').val());
        //var tax = parseFloat($('#tax').val());
        var tax = 0;
        var discount_amount = parseFloat($('#discount_amount').val());
        if (isNaN(discount_amount)) {
            $('#total_amount').text(currency_format(parseFloat(sub_total + delivery_charge + tax)));
            $('#grand_total').val(((sub_total + delivery_charge + tax)).toFixed(2));
        } else {
            $('#total_amount').text(currency_format(parseFloat(sub_total + delivery_charge + tax - discount_amount)));
            $('#grand_total').val(((sub_total + delivery_charge + tax - discount_amount)).toFixed(2));
        }
    });

    function OrderPost() {
        var total_amount = $("#total_amount").val();
        $.ajax({
            url : "{{ URL::to('/orders/orderpost') }}",
            method : "POST",
            data : {
                total_price : total_amount,
            },
            success : Order(),
            error : function (err) {
                console.log(err)
            }
        })
    }

    function ApplyCopon() {
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ URL::to('/cart/applypromocode') }}",
            method: 'post',
            data: {
                promocode: jQuery('#promocode').val()
            },
            success: function(response) {
                $('#preloader').hide();
                if (response.status == 1) {
                    location.reload();
                } else {
                    $('#ermsg').text(response.message);
                    $('#error-msg').addClass('alert-danger');
                    $('#error-msg').css("display", "block");
                    setTimeout(function() {
                        $("#success-msg").hide();
                    }, 5000);
                }
            }
        });
    }

    function RemoveCopon() {
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ URL::to('/cart/removepromocode') }}",
            method: 'post',
            data: {
                promocode: jQuery('#promocode').val()
            },
            success: function(response) {
                $('#preloader').hide();
                if (response.status == 1) {
                    location.reload();
                } else {
                    $('#ermsg').text(response.message);
                    $('#error-msg').addClass('alert-danger');
                    $('#error-msg').css("display", "block");
                    setTimeout(function() {
                        $("#success-msg").hide();
                    }, 5000);
                }
            }
        });
    }

    $(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;

        $('#delivery_dt').attr('min', maxDate);
        $('#delivery_dt').attr('value', maxDate);
        $("#delivery_area").change();
    });

    function requestpayment(){
        var sub_total = parseFloat($('#sub_total').val());
        //var tax = parseFloat($('#tax').val());
        var tax = 0;
        var grand_total = parseFloat($('#grand_total').val());
        var delivery_time = $('#delivery_time').val();
        var delivery_date = $('#delivery_dt').val();
        var delivery_area = $('#delivery_area').val();
        var delivery_charge = parseFloat($('#delivery_charge').val());
        var discount_amount = parseFloat($('#discount_amount').val());
        var couponcode = $('#couponcode').val();
        var order_type = $("input:radio[name=cart-delivery]:checked").val();
        var address = $('#address').val();
        var building = $('#building').val();
        var landmark = $('#landmark').val();
        var notes = $('#notes').val();
        var customer_name = $('#customer_name').val();
        var customer_email = $('#customer_email').val();
        var customer_mobile = '+55' + $('#customer_mobile').val();
        var restaurant = $('#restaurant').val();
        var payment_type = $('input[name="payment"]:checked').attr("data-payment_type");
        var flutterwavekey = $('#flutterwavekey').val();
        var paystackkey = $('#paystackkey').val();
        var business = $("#business").val();
        var item_name = $("#item_name").val();
        var no_shipping = $("#no_shipping").val();
        var currency_code = $("#currency_code").val();
        var notify_url = $("#notify_url").val();
        var cancel_return = $("#cancel_return").val();
        var return_pay = $("#return_pay").val();

        if (order_type == "1") {
            if (delivery_time == "") {
                $('#ermsg').text($('#delivery_time_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (delivery_date == "") {
                $('#ermsg').text($('#delivery_date_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (address == "") {
                $('#ermsg').text($('#address_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (address.length < 5) {
                $('#ermsg').text($('#address_at_least').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (building == "") {
                $('#ermsg').text($('#no_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (landmark == "") {
                $('#ermsg').text($('#landmark_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (delivery_area == "") {
                $('#ermsg').text($('delivery_area').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (customer_name == "") {
                $('#ermsg').text($('#customer_name_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if ($("#customer_mobile").val() == "") {
                $('#ermsg').text($('#customer_mobile_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            }
        } else if (order_type == "2") {
            if (customer_name == "") {
                $('#ermsg').text($('#customer_name_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if ($("#customer_mobile").val() == "") {
                $('#ermsg').text($('#customer_mobile_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            }
        }

        $("#payForm").css("display", "block");
        $("#preloader").show();
        loadPaymentForm();
    }
    
    async function loadPaymentForm() {
        const mp = new MercadoPago('TEST-d57b5ef0-eed5-4011-91fd-ab1c68e85b4e');
        const productCost = $("#grand_total").val();
        const settings = {
            initialization: {
                amount: productCost,
            },
            callbacks: {
                onReady: () => {
                    console.log('brick ready');
                    $("#preloader").hide();
                },
                onError: (error) => {
                    alert(JSON.stringify(error))
                },
                onSubmit: (cardFormData) => {
                    proccessPayment(cardFormData);                    
                }
            },
            locale: 'en',
            customization: {
                paymentMethods: {
                    maxInstallments: 5
                },
                visual: {
                    style: {
                        theme: 'bootstrap',
                        customVariables: {
                            formBackgroundColor: '#f3f3f3',
                            baseColor: 'green'
                        }
                    }
                }
            },
        }

        const bricks = mp.bricks();
        cardPaymentBrickController = await bricks.create('cardPayment', 'payment', settings);
    };

    

    const proccessPayment = (cardFormData) => {

        $.ajax({
            url : "/public_html/orders/mercado",
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(cardFormData),
            success : function(response)  {
                $('#payForm').fadeOut(500);
                console.log(response)
                var data = JSON.parse(response);
                if (data.status == "approved") {
                    // alert("success");
                    // console.log(cardFormData.payer.email);
                    const request = ({
                        sub_total : parseFloat($('#sub_total').val()),
                        //tax : parseFloat($('#tax').val()),
                        tax : 0,
                        grand_total : parseFloat($('#grand_total').val()),
                        delivery_time : $('#delivery_time').val(),
                        delivery_date : $('#delivery_dt').val(),
                        delivery_area : $('#delivery_area').val(),
                        delivery_charge : parseFloat($('#delivery_charge').val()),
                        discount_amount : parseFloat($('#discount_amount').val()),
                        couponcode : $('#couponcode').val(),
                        order_type : $("input:radio[name=cart-delivery]:checked").val(),
                        address : $('#address').val(),
                        building : $('#building').val(),
                        landmark : $('#landmark').val(),
                        notes : $('#notes').val(),
                        customer_name : $('#customer_name').val(),
                        customer_email : cardFormData.payer.email,
                        customer_mobile : '+55' + $('#customer_mobile').val(),
                        restaurant : $('#restaurant').val(),
                        payment_type : $('input[name="payment"]:checked').attr("data-payment_type"),
                        business : $("#business").val(),
                        item_name : $("#item_name").val(),
                        no_shipping : $("#no_shipping").val(),
                        currency_code : $("#currency_code").val(),
                        notify_url : $("#notify_url").val(),
                        cancel_return : $("#cancel_return").val(),
                        return_pay : $("#return_pay").val(),
                    });
                    console.log(request);
                    $.ajax({
                        url : "/public_html/orders/mercado_save",
                        method : "post",
                        headers : {
                            // "Content-Type" : "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : {
                            sub_total : $('#sub_total').val(),
                            //tax : parseFloat($('#tax').val()),
                            tax : 0,
                            grand_total : $('#grand_total').val(),
                            delivery_time : $('#delivery_time').val(),
                            delivery_date : $('#delivery_dt').val(),
                            delivery_area : $('#delivery_area').val(),
                            delivery_charge : $('#delivery_charge').val(),
                            discount_amount : $('#discount_amount').val(),
                            couponcode : $('#couponcode').val(),
                            order_type : $("input:radio[name=cart-delivery]:checked").val(),
                            address : $('#address').val(),
                            building : $('#building').val(),
                            landmark : $('#landmark').val(),
                            notes : $('#notes').val(),
                            customer_name : $('#customer_name').val(),
                            customer_email : cardFormData.payer.email,
                            customer_mobile : '+55' + $('#customer_mobile').val(),
                            restaurant : $('#restaurant').val(),
                            business : $("#business").val(),
                            item_name : $("#item_name").val(),
                            no_shipping : $("#no_shipping").val(),
                            currency_code : $("#currency_code").val(),
                            notify_url : $("#notify_url").val(),
                            cancel_return : $("#cancel_return").val(),
                            return_pay : $("#return_pay").val(),
                        },
                        success : function (data){
                            console.log(data);
                            $("#success-msg").text("Checkout successfully!");
                            $("#success-msg").css("display", "block");
                            setTimeout(() => {
                                $("#success-msg").css("display", "none");
                            }, 5000);                          
                            
                        },
                        error : function () {
                            alert("error");
                        }
                    })
                } 
            },
            error : function(response) {
                var data = JSON.parse(response);
                console.log(data);
            }

        });
    }

    function checkphone() {
        $.ajax({
            url : "{{ URL::to('/orders/checkphone') }}",
            method : "post",
            data : {
                mobile : $("#customer_mobile").val()
            },
            success : function () {
                $("#btn-send").removeAttr("disabled");
            },
            error : function () {
                $('#ermsg').text($('#customer_mobile_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);                
                return false;
            }

        })
    }
</script>