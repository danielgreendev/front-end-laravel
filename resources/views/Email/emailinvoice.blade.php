<div style="max-width: 800px;margin: auto;padding: 15px;border: 1px solid #eee;box-shadow: 0 0 10px rgba(0, 0, 0, .15);font-size: 16px;line-height: 24px;font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;color: #555;">
    <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
        <tr>
            <td colspan="5" style="padding: 5px;vertical-align: top;">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="padding: 5px;vertical-align: top;padding-bottom: 20px;font-size: 45px;line-height: 45px;color: #333;"><img src='{{$logo}}' style="width:100%; max-width:100px;"></td>
                        <td style="padding: 5px;vertical-align: top;text-align: right;padding-bottom: 20px;">{{ trans('labels.invoice') }} #{{$orderdata->order_number}}</td>   
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="padding: 5px;vertical-align: top;">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="padding-bottom: 0px;vertical-align: top;font-family:'Poppins',Helvetica,Arial,sans-serif;color:#19c0c2;font-weight:700;">
                            <b>{{$name}}</b>,
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;text-align: left;padding-bottom: 30px;">
                            <p style="margin-top:2px;margin-bottom:2px; font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">You have received new Order : <span style="font-size: 12px; font-weight: 800; line-height: 24px; color: #777777;">{{$orderdata->order_number}}</span></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="padding: 5px;vertical-align: top;">
                <table style="width: 100%;line-height: inherit;text-align: left;">
                    <tr>
                        <td style="padding: 5px;vertical-align: top;padding-bottom: 20px;">
                            {{$orderdata->customer_name}}<br>
                            {{$orderdata->customer_email}}<br>
                            {{$orderdata->mobile}}<br>
                            {{$orderdata->address}}
                        </td>
                        <td style="padding: 5px;vertical-align: top;text-align: right;padding-bottom: 40px;">
                            @if ($orderdata['order_notes'] !="")
                                <strong>{{ trans('labels.order_note') }}</strong><br>
                                {{$orderdata['order_notes']}}
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">#</td>
            <td style="padding: 5px;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">{{ trans('labels.item') }}</td>
            <td style="padding: 5px;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">{{ trans('labels.rate') }}</td>
            <td style="padding: 5px;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">{{ trans('labels.qty') }}</td>
            <td style="padding: 5px;vertical-align: top;text-align: right;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">{{trans('labels.amount')}}</td>
        </tr>
        <?php
        
            $i=1;
            foreach ($itemdata as $orderitem){

            $orderitem['extras_price']=="" ? $extrasprice = 0 : $extrasprice = array_sum(explode(',',$orderitem['extras_price'])); 

            if ($orderitem['variants_id'] != "") {
                $total_price =$orderitem['qty']*$orderitem['variants_price']+$extrasprice;
            } else {
                $total_price = $orderitem['qty']*$orderitem['price']+$extrasprice;
            }
            $data[] = array("total_price" => $total_price,);
        ?>
            <tr>
                <td style="padding: 5px;vertical-align: top;border-bottom: 1px solid #eee;">{{$i}}</td>
                <td style="padding: 5px;vertical-align: top;border-bottom: 1px solid #eee;">
                    @if($orderitem['item_type'] == 1) 
                        <img src="{{Helper::image_path('veg.svg')}}" alt="">
                    @else 
                        <img src="{{Helper::image_path('nonveg.svg')}}" alt="">
                    @endif
                    {{$orderitem['item_name']}}
                    @if($orderitem->variants_name != "")
                        [{{$orderitem->variants_name}}]
                    @endif<br>
                    <?php
                        $extras_name = explode(',', $orderitem->extras_name);
                        $extras_price = explode(',', $orderitem->extras_price);
                        $extrastotal = 0;
                    ?>
                    @if($orderitem->extras_id != "")
                        @foreach($extras_name as $key => $val)
                        <small class="text-muted">{{$extras_name[$key]}} : <span>{{Helper::currency_format($extras_price[$key],$orderdata->restaurant)}}</span></small><br>
                        <?php $extrastotal += (float)$extras_price[$key]?>
                        @endforeach
                    @endif
                </td>        
                <td style="padding: 5px;vertical-align: top;border-bottom: 1px solid #eee;">
                @if ($orderitem['variants_id'] != "")
                {{Helper::currency_format($orderitem['qty']*$orderitem['variants_price'],$orderdata->restaurant)}}
                @else
                {{Helper::currency_format($orderitem['qty']*$orderitem['price'],$orderdata->restaurant)}}
                @endif

                @if($extrastotal != "0")
                    <br><small class="text-muted">+ {{Helper::currency_format($extrastotal,$orderdata->restaurant)}}</small>
                @endif
                </td>
                <td style="padding: 5px;vertical-align: top;border-bottom: 1px solid #eee;">{{$orderitem['qty']}}</td>  
                <td style="padding: 5px;vertical-align: top;text-align: right;border-bottom: 1px solid #eee;">{{Helper::currency_format($total_price,$orderdata->restaurant)}}</td>
            </tr>
        <?php
                $i++;
            }
            $order_total = array_sum(array_column(@$data, 'total_price'));
        ?>
        <tr>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #eee;font-weight: bold;">
               <strong>{{trans('labels.sub_total')}} : </strong> {{Helper::currency_format($order_total,$orderdata->restaurant)}}
            </td>
        </tr>
        <tr>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #eee;font-weight: bold;">
               <strong>{{trans('labels.tax')}} : </strong> {{Helper::currency_format($orderdata->tax,$orderdata->restaurant)}}
            </td>
        </tr>
        @if ($orderdata->delivery_charge > 0)
        <tr>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #eee;font-weight: bold;">
               <strong>{{trans('labels.delivery_charge')}}  ({{ $orderdata->delivery_area }}) : </strong> {{Helper::currency_format($orderdata->delivery_charge,$orderdata->restaurant)}}
            </td>
        </tr>
        @endif
        @if ($orderdata->discount_amount > 0 && $orderdata->discount_amount != "NaN")
        <tr>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #eee;font-weight: bold;">
               <strong>{{trans('labels.discount')}} ({{$orderdata->offer_code}}) : </strong> {{Helper::currency_format($orderdata->discount_amount,$orderdata->restaurant)}}
            </td>
        </tr>
        @endif
        <tr>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;"></td>
            <td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #eee;font-weight: bold;">
               <strong>{{trans('labels.grand_total')}} : </strong> {{Helper::currency_format($orderdata->grand_total,$orderdata->restaurant)}}
            </td>
        </tr>
    </table>
</div>