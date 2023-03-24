@include('front.theme.header')

<section class="order-details">
    <div class="container">
        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{ trans('labels.order_details') }}</h2>
        <p>({{$summery['order_number']}} - {{$summery['created_at']}})</p>
        @if($summery['status'] == 1)
            <ul class="{{session()->get('direction') == '2' ? 'progressbar-rtl' : 'progressbar'}}  d-flex px-0 text-center justify-content-center" >
                <li class="active">{{ trans('labels.order_placed') }}</li>
                <li>{{ trans('labels.order_ready') }}</li>
                <li>{{ trans('labels.order_delivered') }}</li>
            </ul>
        @elseif($summery['status'] == 2)
            <ul class="{{session()->get('direction') == '2' ? 'progressbar-rtl' : 'progressbar'}} d-flex px-0 text-center justify-content-center" >
                <li class="active">{{ trans('labels.order_placed') }}</li>
                <li class="active">{{ trans('labels.order_ready') }}</li>
                <li>{{ trans('labels.order_delivered') }}</li>
            </ul>
        @elseif($summery['status'] == 3)
            <ul class="{{session()->get('direction') == '2' ? 'progressbar-rtl' : 'progressbar'}} d-flex px-0 text-center justify-content-center" >
                <li class="active">{{ trans('labels.order_placed') }}</li>
                <li class="active">{{ trans('labels.order_ready') }}</li>
                <li class="active">{{ trans('labels.order_delivered') }}</li>
            </ul>
        @elseif($summery['status'] == 5)
            <ul class="{{session()->get('direction') == '2' ? 'progressbar-rtl' : 'progressbar'}} d-flex px-0 text-danger text-center justify-content-center" >
                <li class="active text-danger">{{ trans('labels.rejected') }}</li>
            </ul>
        @endif
        <div class="row">
            <div class="col-lg-8">
                @foreach ($orderdetails as $odata)
                <div class="order-details-box">
                    <div class="order-details-name">
                        <h3>
                            {{$odata->item_name}}
                            @if ($odata->variants_id != "")
                                {{$odata->variants_name}}
                                - {{Helper::currency_format($odata->variants_price,$getrestaurant->id)}}
                                <span>{{Helper::currency_format($odata->variants_price,$getrestaurant->id)}}</span>
                            @else
                                - {{Helper::currency_format($odata->qty * $odata->price,$getrestaurant->id)}}
                                <span>{{Helper::currency_format($odata->price,$getrestaurant->id)}}</span>
                            @endif
                        </h3>
                        <p>{{ trans('labels.qty') }} : {{$odata->qty}}</p>

                        <?php 
                        $extras_id = explode(",",$odata->extras_id);
                        $extras_price = explode(",",$odata->extras_price);
                        $extras_name = explode(",",$odata->extras_name);
                        ?>

                        @if ($odata->extras_id != "")
                        @foreach ($extras_id as $key =>  $addons)                                
                            <div class="cart-addons-wrap">
                                <div class="cart-addons">
                                <b class="{{session()->get('direction') == '2' ? 'text-right' : ''}}">{{$extras_name[$key]}}</b> : {{Helper::currency_format($extras_price[$key],$getrestaurant->id)}}
                                </div>
                            </div>
                        @endforeach
                        @endif

                        
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-lg-4">
                <div class="order-payment-summary">
                    <h3>{{ trans('labels.payment_summary') }}</h3>
                    <p>{{ trans('labels.sub_total') }} <span>{{Helper::currency_format(@$summery['sub_total'],$getrestaurant->id)}}</span></p>

                    <p>{{ trans('labels.tax') }} <span>{{Helper::currency_format(@$summery['tax'],$getrestaurant->id)}} </span></p>

                    <p>{{ trans('labels.delivery_charge') }} <span>{{Helper::currency_format(@$summery['delivery_charge'],$getrestaurant->id)}} </span></p>

                    @if ($summery['couponcode'] !="")
                    <p>{{ trans('labels.discount') }} ({{$summery['couponcode']}}) <span>- {{Helper::currency_format(@$summery['discount_amount'],$getrestaurant->id)}}</span></p>
                    @endif
                    <p class="order-details-total">{{ trans('labels.total_amount') }} <span>{{Helper::currency_format($summery['grand_total'],$getrestaurant->id)}}</span></p>
                </div>

                @if($summery['order_type'] == 1)
                
                    <div class="order-add">
                        <h6>{{ trans('labels.delivery_info') }}</h6>
                        <p>{{$summery['address']}}</p>
                        <p>{{$summery['building']}}</p>
                        <p>{{$summery['landmark']}}</p>
                    </div>

                @endif

               
            </div>
        </div>
    </div>
</section>

@include('front.theme.footer')