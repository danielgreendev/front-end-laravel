<div style="display: none">
    @include('front.theme.header')
</div>

<section class="py-0 row order-success">
    <div class="container">
        <div class="row justify-content-center order-success">
            <div class="col-md-8 d-grid justify-items-center text-center">
                <h2>{{ trans('labels.order_successfull') }}</h2>
                <img src="{{ url('storage/app/public/front/images/ordersuccess.png') }}" class="success-img" alt="ordersuccess" srcset="">
                <p class="mb-2 font-weight-normal col-lg-11">{{ trans('labels.order_success_note') }}</p>
                <div class="input-group col-lg-11">
                    <input type="text" class="form-control {{ session()->get('direction') == 2 ? 'rounded' : '' }}" id="data" value="{{URL::to($getrestaurant->slug.'/track-order/'.$orderdata->order_number)}}" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary border-0 {{ session()->get('direction') == 2 ? 'rounded' : '' }}" type="button" id="tool"
                            onclick="copytext('{{ trans('labels.copied') }}')">{{ trans('labels.copy') }}</button>
                    </div>
                </div>
                <div class="d-flex row action_buttons">
                    <a href="{{URL::to($getrestaurant->slug)}}" class="btn btn-primary btn-sm border-0 text-white mx-2 col-lg-5">
                        <i class="far fa-home-lg {{ session()->get('direction') == 2 ? 'ml-1' : 'mr-1' }}"></i>
                        {{ trans('labels.continue_shop') }}
                    </a>
                    <a href="https://api.whatsapp.com/send?phone={{Helper::webinfo($getrestaurant->id)->country_code.Helper::webinfo($getrestaurant->id)->contact}}&text={{$whmessage}}" target="_blank" class="btn btn-primary btn-sm border-0 text-white mx-2 col-lg-6">
                        <i class="fab fa-whatsapp {{ session()->get('direction') == 2 ? 'ml-1' : 'mr-1' }}"></i>
                        {{ trans('labels.send_order_whatsapp') }}
                    </a>
                    <!-- <a target="_blank" class="btn btn-primary btn-sm border-0 text-white mx-2 col-lg-6" id="btn_whatsapp">
                        <i class="fab fa-whatsapp {{ session()->get('direction') == 2 ? 'ml-1' : 'mr-1' }}"></i>
                        {{ trans('labels.send_order_whatsapp') }}
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</section>

<div style="display: none">
    
    <link rel="stylesheet" href="{{asset('resources/views/front/ordersuccess.css')}}" />

    @include('front.theme.footer')
    <script>
        function copytext(copied) {
            "use strict";
            var copyText = document.getElementById("data");
            copyText.select();
            document.execCommand("copy");
            document.getElementById("tool").innerHTML = copied;
        }

        $('#btn_whatsapp').click(function(e) {
            e.preventDefault();
            $(this).addClass('disabled');
            phone = "{{Helper::webinfo($getrestaurant->id)->country_code.Helper::webinfo($getrestaurant->id)->contact}}";
            phone = phone.replace(/ /g, '');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{URL::to('/order/send-whatsapp')}}",
                data: {
                    mobile: phone,
                    info: '{{$notify->info}}',
                    msg: `{{$whmessage}}`,
                },
                method: 'POST',
                success: function(response) {
                    if (response.status == 1) {
                        toastr.success("Sucesso", "Sua mensagem de pedido foi enviada.");
                    }
                    else {
                        toastr.error("Erro!", "Alguma coisa errada.");
                        $('#btn_whatsapp').removeClass('disabled');
                    }
                },
                error: function(error) {
                    toastr.error("Erro!", "Alguma coisa errada.");
                    $('#btn_whatsapp').removeClass('disabled');
                }
            });
        })
    </script>
</div>
