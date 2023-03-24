<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{trans('labels.print')}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{Helper::admininfo()->favicon}}"><!-- Favicon icon -->
    <style type="text/css">
        #printDiv {
            background: #ffffff;
        }
        @media print {
            @page {
                margin: 0;
            }
            #btnPrint {
                display: none;
            }
            #download_btn {
                display: none;
            }
            thead {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/orders/print.css')}}">
    <script src="{{asset('storage/app/public/vendor/js/rasterizeHTML.allinone.js')}}"></script>
    <script src="{{asset('storage/app/public/vendor/js/html2canvas.js')}}"></script>
    <script src="{{asset('storage/app/public/vendor/js/jspdf.debug.js')}}"></script>
</head>
<body>
    <div class="invoice-container-wrap">
        <div class="invoice-container">
            <main id="main">
                <div class="as-invoice invoice_style6">
                    <div class="download-inner" id="printDiv">
                        <header class="as-header header-layout4">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto">
                                    <div class="header-logo">
                                        <a href="#"><img src="{{ asset('storage/app/public/admin-assets/img/logo.svg') }}" alt="Invce"></a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <h1 class="big-title">{{Helper::webinfo(Auth::user()->id)->website_title}}</h1>
                                    <span><b>Invoice No : </b>#{{$order->order_number}}</span>
                                    <span><b>Data e Hora do Recibo : </b><?php echo date("d-m-Y H:i:s", strtotime($order->created_at)); ?></span>
                                </div>
                            </div>
                        </header>

                        <div class="row justify-content-between mb-4">
                            <div class="col-auto">
                                <div class="invoice-left">
                                    <b>Informação do Cliente:</b>
                                    <address>
                                        {{trans('labels.name')}} : {{$order->customer_name}}
                                        @if($order->order_type == 1)
                                        <br> {{trans('labels.address')}} : {{$order->address}}
                                        @endif
                                        <br>{{trans('labels.mobile')}} : {{$order->mobile}}
                                    </address>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="invoice-right">
                                    <b>{{ trans('labels.order_type') }}:</b>
                                    <address>
                                        {{ $order->order_type == '1' ? trans('labels.delivery') : trans('labels.pickup') }}
                                    </address>
                                </div>
                            </div>
                        </div>

                        <hr class="style1">

                        <p class="table-title"><b>Detalhes do pedido :</b></p>

                        @if ($order->order_notes != "")
                        <div class="order_details_desc">
                            <h4>{{trans('labels.notes')}} : </h4><span>{{$order->order_notes}}</span>
                        </div>
                        @endif

                        <table class="invoice-table table-stripe3 style4">
                            <thead>
                                <tr>
                                    <th>{{trans('labels.item')}}</th>
                                    <th>Preço</th>
                                    <th>{{trans('labels.qty')}}</th>
                                    <th>{{trans('labels.total')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderdetails as $odata)
                                <tr>
                                    <td>
                                        @if ($odata->variants_id != "")
                                        {{$odata->item_name}} - {{$odata->variants_name}}
                                        @else

                                        {{$odata->item_name}}
                                        @endif


                                        @if ($odata->extras_id != "")
                                        <?php

                                        $extras_id = explode(",", $odata->extras_id);
                                        $extras_name = explode(",", $odata->extras_name);
                                        $extras_price = explode(",", $odata->extras_price);
                                        ?>
                                        @foreach($extras_id as $key => $addons)
                                        <br><b>{{$extras_name[$key]}}</b> : {{Helper::currency_format($extras_price[$key], Auth::user()->id)}}<br>
                                        @endforeach

                                        @endif
                                    </td>
                                    <td>
                                        @if ($odata->variants_id != "")
                                        {{Helper::currency_format($odata->variants_price,Auth::user()->id)}}
                                        @else
                                        {{Helper::currency_format($odata->price,Auth::user()->id)}}
                                        @endif
                                    </td>
                                    <td>{{$odata->qty}}</td>
                                    <td>
                                        {{Helper::currency_format($odata->qty*$odata->price,Auth::user()->id)}}
                                    </td>
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

                        <div class="row justify-content-between">
                            <div class="col-auto terms">
                                <div class="invoice-left">
                                    <b>{{ trans('labels.terms') }}</b>
                                    <p class="mb-0">{!!@$terms->terms_content!!}</p>
                                </div>
                            </div>

                            <div class="col-auto">
                                <table class="total-table">
                                    <tbody>
                                        <tr>
                                            <th>Metódo de Pagamento : </th>
                                            <td>
                                                @if ($order->payment_type == "COD")
                                                    COD
                                                @endif

                                                @if ($order->payment_type == "RazorPay")
                                                    RazorPay {{$order->payment_id}}
                                                @endif

                                                @if ($order->payment_type == "Stripe")
                                                    Stripe {{$order->payment_id}}
                                                @endif

                                                @if ($order->payment_type == "PayPal")
                                                    PayPal {{$order->payment_id}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('labels.sub_total')}} :</th>
                                            <td>{{Helper::currency_format($order_total,Auth::user()->id)}}</td>
                                        </tr>
                                        @if ($order->discount_amount > 0 && $order->discount_amount != 'NaN')
                                        <tr>
                                            <th>{{trans('labels.discount')}} {{ $order->offer_code != "" ? '('.$order->offer_code.')' : '' }}</th>
                                            <td>{{Helper::currency_format($order->discount_amount,Auth::user()->id)}}</td>
                                        </tr>
                                        @endif
                                        @if ($order->delivery_charge > 0)
                                        <tr>
                                            <th>{{trans('labels.delivery_charge')}} :</th>
                                            <td>{{Helper::currency_format($order->delivery_charge,Auth::user()->id)}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>{{trans('labels.grand_total')}} :</th>
                                            <td>{{Helper::currency_format($order->grand_total,Auth::user()->id)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <p class="company-address style2"><b>Invce Inc:</b><br>{!!$setting->address!!}<br>{!!$setting->email!!}, {!!$setting->country_code!!}{!!$setting->contact!!}</p>

                        <p class="invoice-note mt-3"><svg width="13" height="16" viewBox="0 0 13 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.22969 12.6H9.77031V11.4H3.22969V12.6ZM3.22969 9.2H9.77031V8H3.22969V9.2ZM1.21875 16C0.89375 16 0.609375 15.88 0.365625 15.64C0.121875 15.4 0 15.12 0 14.8V1.2C0 0.88 0.121875 0.6 0.365625 0.36C0.609375 0.12 0.89375 0 1.21875 0H8.55156L13 4.38V14.8C13 15.12 12.8781 15.4 12.6344 15.64C12.3906 15.88 12.1063 16 11.7812 16H1.21875ZM7.94219 4.92V1.2H1.21875V14.8H11.7812V4.92H7.94219ZM1.21875 1.2V4.92V1.2V14.8V1.2Z" fill="#41b6e6"></path></svg> <b>NOTA: </b>Este é um recibo gerado por computador e não requer assinatura física.</p>

                        <p class="company-address style2">{!!$setting->copyright!!}</p>
                    </div>
                    <div class="invoice-buttons hidden-print">
                        <button class="print_btn" id="btnPrint">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.9688 8.46875C12.1146 8.32292 12.2917 8.25 12.5 8.25C12.7083 8.25 12.8854 8.32292 13.0312 8.46875C13.1771 8.61458 13.25 8.79167 13.25 9C13.25 9.20833 13.1771 9.38542 13.0312 9.53125C12.8854 9.67708 12.7083 9.75 12.5 9.75C12.2917 9.75 12.1146 9.67708 11.9688 9.53125C11.8229 9.38542 11.75 9.20833 11.75 9C11.75 8.79167 11.8229 8.61458 11.9688 8.46875ZM13.5 5.5C14.1875 5.5 14.7708 5.75 15.25 6.25C15.75 6.72917 16 7.3125 16 8V12C16 12.1458 15.9479 12.2708 15.8438 12.375C15.7604 12.4583 15.6458 12.5 15.5 12.5H13.5V15.5C13.5 15.6458 13.4479 15.7604 13.3438 15.8438C13.2604 15.9479 13.1458 16 13 16H3C2.85417 16 2.72917 15.9479 2.625 15.8438C2.54167 15.7604 2.5 15.6458 2.5 15.5V12.5H0.5C0.354167 12.5 0.229167 12.4583 0.125 12.375C0.0416667 12.2708 0 12.1458 0 12V8C0 7.3125 0.239583 6.72917 0.71875 6.25C1.21875 5.75 1.8125 5.5 2.5 5.5V1C2.5 0.729167 2.59375 0.5 2.78125 0.3125C2.96875 0.104167 3.1875 0 3.4375 0H10.375C10.7917 0 11.1458 0.145833 11.4375 0.4375L13.0625 2.0625C13.3542 2.35417 13.5 2.70833 13.5 3.125V5.5ZM4 1.5V5.5H12V3.5H10.5C10.3542 3.5 10.2292 3.45833 10.125 3.375C10.0417 3.27083 10 3.14583 10 3V1.5H4ZM12 14.5V12.5H4V14.5H12ZM14.5 11V8C14.5 7.72917 14.3958 7.5 14.1875 7.3125C14 7.10417 13.7708 7 13.5 7H2.5C2.22917 7 1.98958 7.10417 1.78125 7.3125C1.59375 7.5 1.5 7.72917 1.5 8V11H14.5Z" fill="white"></path></svg>
                            <span>{{trans('labels.print')}}</span>
                        </button>
                        <button id="download_btn" class="download_btn">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.5 9C16.9167 9 17.2708 9.14583 17.5625 9.4375C17.8542 9.72917 18 10.0833 18 10.5V14.5C18 14.9167 17.8542 15.2708 17.5625 15.5625C17.2708 15.8542 16.9167 16 16.5 16H1.5C1.08333 16 0.729167 15.8542 0.4375 15.5625C0.145833 15.2708 0 14.9167 0 14.5V10.5C0 10.0833 0.145833 9.72917 0.4375 9.4375C0.729167 9.14583 1.08333 9 1.5 9H4.375L2.9375 7.5625C2.47917 7.08333 2.375 6.54167 2.625 5.9375C2.875 5.3125 3.33333 5 4 5H6V1.5C6 1.08333 6.14583 0.729167 6.4375 0.4375C6.72917 0.145833 7.08333 0 7.5 0H10.5C10.9167 0 11.2708 0.145833 11.5625 0.4375C11.8542 0.729167 12 1.08333 12 1.5V5H14C14.6667 5 15.125 5.3125 15.375 5.9375C15.6458 6.54167 15.5417 7.08333 15.0625 7.5625L13.625 9H16.5ZM4 6.5L9 11.5L14 6.5H10.5V1.5H7.5V6.5H4ZM16.5 14.5V10.5H12.125L10.0625 12.5625C9.77083 12.8542 9.41667 13 9 13C8.58333 13 8.22917 12.8542 7.9375 12.5625L5.875 10.5H1.5V14.5H16.5ZM13.9688 13.0312C13.8229 12.8854 13.75 12.7083 13.75 12.5C13.75 12.2917 13.8229 12.1146 13.9688 11.9688C14.1146 11.8229 14.2917 11.75 14.5 11.75C14.7083 11.75 14.8854 11.8229 15.0312 11.9688C15.1771 12.1146 15.25 12.2917 15.25 12.5C15.25 12.7083 15.1771 12.8854 15.0312 13.0312C14.8854 13.1771 14.7083 13.25 14.5 13.25C14.2917 13.25 14.1146 13.1771 13.9688 13.0312Z" fill="white"></path></svg>
                            <span>Download</span>
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        const $btnPrint = document.querySelector("#btnPrint");
        const $btnDownload = document.querySelector("#download_btn");
        $btnPrint.addEventListener("click", () => {
            var printContents = document.getElementById('main').innerHTML;

            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

            window.location.reload();
        });

        $btnDownload.addEventListener("click", () => {
            window.html2canvas = html2canvas;
            var dpi = window.devicePixelRatio;
            var pdf = new jsPDF({
                unit: 'px', // set the unit of measurement to px
                format: 'letter', // set your paper size format
                userUnit: 72, // set the DPI you desire. We used 72 because thats the default DPI used in browsers.
            });

            var printContents = document.getElementById('printDiv');

            pdf.addHTML(printContents,function() {
                pdf.save('Invoice' + '#{{$order->order_number}}' + '.pdf');
            });
        });
    </script>
</body>