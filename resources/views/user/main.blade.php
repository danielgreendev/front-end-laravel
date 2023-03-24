<!DOCTYPE html>
<html>
<head>
	@yield('header')
</head>
<body>

	@yield('content')

	@include('front.landing.layout.footer')
	
	<a href="#" class="scroll-top" style="display: none;">
		<i class="lni lni-chevron-up"></i>
	</a>

	@yield('scripts')
</body>

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script type="text/javascript">
	// Toaster Success/error Message Start

	@if(Session::has('success'))
	toastr.options = {
	  "closeButton": true,
	  "progressBar": true
	}
	toastr.success("{{ session('success') }}");
	@endif

	@if(Session::has('error'))
	toastr.options = {
	  "closeButton": true,
	  "progressBar": true,
	  "timeOut": 10000

	}
	toastr.error("{{ session('error') }}");
	@endif

	function ErrorMsg(str) {
      toastr.error("Erro!", str);
  }

  $('#btn_free').click(function(event) {
    event.preventDefault();

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ URL::to('user/payment/free-plan') }}",
      type: 'POST',
      dataType: 'json',
      data: {
        plan: 'free'
      },
      success: function(response) {
          if (response.status == 1) {
            toastr.success("Sucesso!", "Você adquiriu com sucesso um plano gratuito");
            window.location.reload();
            return true;
          }
       },
       error: function(error) {
         ErrorMsg("{{trans('messages.payment_error')}}");
         return false;
       }
    })
  });

	$('#btn_plus').click(function(event) {
    event.preventDefault();

    $("#plan").val('PLUS');
    Pay_PayPal();
   });

   $("#btn_premium").click(function(event) {
      event.preventDefault();

      $("#plan").val('PREMIUM');
      Pay_PayPal();
   });

	function Pay_PayPal() {
		var amount = $("#amount").val();
    var business = $("#business").val();
    var plan = $("#plan").val();
    var payer_email = $("#payer_email").val();
    var payer_name = $("#payer_name").val();
    var item_number = $("#item_number").val(); // payment_id
    var no_shopping = $("#no_shipping").val();
    var currency_code = $("#currency_code").val();
    var notify_url = $("#notify_url").val();
    var cancel_return = $("#cancel_return").val();
    var return_pay = $("#return_pay").val();
    var cmd = $("#cmd").val();
    var t3 = $("#t3").val();
    var p3 = $("#p3").val();
    var a3 = $("#a3").val();
    var src = $("#src").val();
    var couponcode = $("#couponcode").val();

    $.ajax({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       url: "{{ URL::to('/user/payment/app/notify/reset') }}",
       type: 'POST',
       dataType: 'json',
       data: {
          payment_id: item_number,
          business: business,
          amount: amount,
          payer_email: payer_email,
          payer_name: payer_name,
          no_shopping: no_shopping,
          currency_code: currency_code,
          plan: plan,
          notify_url: notify_url,
          cancel_return: cancel_return,
          return_pay: return_pay,
          cmd: cmd,
          t3: t3,
          p3: p3,
          a3: a3,
          src: src,
          couponcode: couponcode
       },
       success: function(response) {
          if (response.status == 1) {
            var message = JSON.parse(response.message);
            $("#amount").val(message.amount);
            $("#a3").val(message.amount);
            $("#return_pay").val(message.url);
            $("#item_number").val(message.id);
            $('#notify_url').val(message.notify);
            $('#cancel_return').val(message.cancel);
            $('#payment-form').submit();
            return true;
          }
       },
       error: function(error) {
         ErrorMsg("{{trans('messages.payment_error')}}");
         window.location.reload();
         return false;
       }
    });
	}

  $('#btn_search').click(function(e) {
    e.preventDefault();
    $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: "{{URL::to('/lojas/search')}}",
      data: {
        search: $('#place-event').val(),
        location: $('#search_locate').val(),
        category: $('#search_category').val(),
      },
      method: 'POST',
      success: function(response) {
        if (response.status == 1) {
          $('#list_view').html(response.Component);
        }
      },
      error: function(e) {
        console.log(e);
        toastr.error("{{ session('error') }}");
      }
    });
  });

  $('#btn_page_next').click(function(e) {
    var index_max = 12;
    var index = parseInt($('.page-active a').text());
    if (index % 4 == 0)
    {
      for (var i = 1; i < 5; i++) {
        $(('#btn_page'+i) + ' a').text(index + i);
      }
    }
    onPageClick(e, (index % 4) + 1);

    console.log(index);
  });

  function onPageClick(event, page) {
    event.preventDefault();
    $('.page-active').removeClass('page-active');
    $('#btn_page'+page).addClass('page-active');
  }

  $('#btn_page1 a').click(function(e) {
    onPageClick(e, 1);
  });

  $('#btn_page2 a').click(function(e) {
    onPageClick(e, 2);
  });

  $('#btn_page3 a').click(function(e) {
    onPageClick(e, 3);
  });

  $('#btn_page4 a').click(function(e) {
    onPageClick(e, 4);
  });
</script>
</html>