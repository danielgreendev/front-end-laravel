@extends('admin.layout.main')

@section('page_title')
	{{trans('labels.categories')}} | {{trans('labels.update')}}
@endsection

@section('content')
	
<section class="invoice-template">
    <div class="card">
        <div class="card-body p-3">
            <div id="invoice-template" class="card-block">
                <!-- Invoice Company Details -->
                <div id="invoice-company-details" class="row">
                    <div class="col-6 text-left">
                        <ul class="px-0 list-unstyled">
                            <li class="text-bold-800">{{Auth::user()->name}}</li>
                            <li>{{Auth::user()->email}}</li>
                            <li>{{Auth::user()->mobile}}</li>
                            <li>{{Auth::user()->address}}</li>
                        </ul>
                    </div>
                    <div class="col-6 text-right">
                        <h2>RECIBO</h2>
                        <p class="pb-3"># {{$order->order_number}}</p>
                    </div>
                </div>
                <!--/ Invoice Company Details -->
                <!-- Invoice Customer Details -->
                <div id="invoice-customer-details" class="row pt-2">
                    <!-- <div class="col-sm-12 text-left">
                        <p class="text-muted">Bill To</p>
                    </div> -->
                    <div class="col-6 text-left">
                        <ul class="px-0 list-unstyled">
                            <li class="text-bold-800">{{$order->customer_name}}</li>
                            <li>{{$order->address}}</li>
                            <li>{{$order->building}}, {{$order->landmark}}</li>
                            <li>{{$order->pincode}}.</li>
                        </ul>
                    </div>
                    <div class="col-6 text-right">
                        <p><span class="text-muted">Data e Hora do Recibo :</span> <?php echo date("d-m-Y H:i:s", strtotime($order->created_at)); ?></p>
                        @if($order->order_type == 1)
                        	<!-- <p><span class="text-muted">Delivery date :</span> {{$order->delivery_date}}</p> -->
                        @else
                        	<!-- <p><span class="text-muted">Pickup date :</span> {{$order->delivery_date}}</p> -->
                        @endif
                        @if($order->order_type == 1)
                            <!-- <p><span class="text-muted">Delivery time :</span> {{$order->delivery_time}}</p> -->
                        @else
                            <!-- <p><span class="text-muted">Pickup time :</span> {{$order->delivery_time}}</p> -->
                        @endif
                    </div>
                </div>
                <!--/ Invoice Customer Details -->
                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                        <div class="table-responsive col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th class="text-right">Preço</th>
                                        <th class="text-right">Quantidade</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@foreach($orderdetails as $odata)
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                        	@if ($odata->variants_id != "")
                                        		<p>{{$odata->item_name}} - {{$odata->variants_name}}</p>
                                        	@else
                                        	    <p>{{$odata->item_name}}</p>
                                        	@endif

                                        	@if ($odata->extras_id != "")
                                        		<?php
                                        		$extras_id = explode(",",$odata->extras_id);
                                        		$extras_name = explode(",",$odata->extras_name);
                                        		$extras_price = explode(",",$odata->extras_price);
                                        		?>

                                        		@foreach($extras_id as $key => $addons)
                                        		    <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <b>{{$extras_name[$key]}}</b> : {{Helper::currency_format($extras_price[$key],Auth::user()->id)}}<br>
                                        		@endforeach
                                        	@endif

                                        	
                                        </td>
                                        <td class="text-right">
                                        	@if ($odata->variants_id != "")
                                        		{{Helper::currency_format($odata->variants_price,Auth::user()->id)}}
                                        	@else
                                        		{{Helper::currency_format($odata->price,Auth::user()->id)}}
                                        	@endif
                                        </td>
                                        <td class="text-right">{{$odata->qty}}</td>
                                        <td class="text-right">{{Helper::currency_format($odata->qty*$odata->price,Auth::user()->id)}}</td>
                                    </tr>
                                    <?php
                                    $data[] = array(
                                        "total_price" => $odata->qty * $odata->price,
                                    );
                                    $order_total = array_sum(array_column(@$data, 'total_price'));
                                    ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 text-left">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Metódo de Pagamento:</td>
                                                <td class="text-right">
                                                    @if ($order->payment_type == "COD")
                                                        COD
                                                    @endif

                                                    @if ($order->payment_type == "RazorPay")
                                                        RazorPay : {{$order->payment_id}}
                                                    @endif

                                                    @if ($order->payment_type == "Stripe")
                                                        Stripe: {{$order->payment_id}}
                                                    @endif

                                                    @if ($order->payment_type == "PayPal")
                                                        PayPal: {{$order->payment_id}}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <p class="lead">Total</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Subtotal</td>
                                            <td class="text-right">{{Helper::currency_format($order_total,Auth::user()->id)}}</td>
                                        </tr>
                                        <!-- <tr>
                                            <td>Tax</td>
                                            <td class="text-right">{{Helper::currency_format($order->tax,Auth::user()->id)}}</td>
                                        </tr> -->
                                        @if($order->order_type == 1)
                                        	<tr>
                                        	    <td>Taxa de entrega ({{$order->delivery_area}})</td>
                                        	    <td class="text-right">{{Helper::currency_format($order->delivery_charge,Auth::user()->id)}}</td>
                                        	</tr>
                                        @endif
                                        
                                        <tr>
                                            <td class="text-bold-800">Total</td>
                                            <td class="text-bold-800 text-right">{{Helper::currency_format($order->grand_total,Auth::user()->id)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ URL::to('vendor/print/' . $order->id) }}" class="btn btn-info mx-1">
                    <i class="fa fa-pdf" aria-hidden="true"></i> {{ trans('labels.print') }}
                </a>
            </div>
        </div>
    </div>
</section>

@endsection