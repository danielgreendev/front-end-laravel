{!!Helper::webinfo($getrestaurant->id)->whatsapp_widget!!}
<footer>
  <div class="container d-flex justify-content-between flex-wrap">
    <div class="footer-head">
      <div class="footer-logo"><img src="{{Helper::webinfo($getrestaurant->id)->image}}" alt=""></div>
      <p class=" {{ session()->get('direction') == '2' ? 'text-right' : 'text-left' }}">{{Helper::webinfo($getrestaurant->id)->description}}</p>
    </div>
    <div class="download-app text-center">
      <ul class="footer_response">
        <!-- <li><a class="text-white" href="{{URL::to($getrestaurant->slug.'/book/')}}"> {{ trans('labels.book_table') }} </a></li>
        <li><a class="text-white" href="{{URL::to($getrestaurant->slug.'/terms/')}}"> {{ trans('labels.terms') }} </a></li> -->
        <li><a class="text-white" href="{{URL::to($getrestaurant->slug.'/privacy-policy/')}}"> {{ trans('labels.privacypolicy') }} </a></li>
      </ul>
    </div>
    <div class="footer-socialmedia">
      @if(Helper::webinfo($getrestaurant->id)->facebook_link != "")
      <a href="{{Helper::webinfo($getrestaurant->id)->facebook_link}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
      @endif
      @if(Helper::webinfo($getrestaurant->id)->twitter_link != "")
      <a href="{{Helper::webinfo($getrestaurant->id)->twitter_link}}" target="_blank"><i class="fab fa-twitter"></i></a>
      @endif
      @if(Helper::webinfo($getrestaurant->id)->instagram_link != "")
      <a href="{{Helper::webinfo($getrestaurant->id)->instagram_link}}" target="_blank"><i class="fab fa-instagram"></i></a>
      @endif
    </div>
  </div>
  <div class="copy-right text-center">
    <p>{{Helper::webinfo($getrestaurant->id)->copyright}}</p>
  </div>
</footer>
<!-- footer -->
<!-- Product View -->
<div class="modal fade" id="viewproduct-over" tabindex="-1" role="dialog" aria-labelledby="add-payment" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content" id="view-product">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="sp-wrap gallerys">
            </div>
          </div>
          <input type="hidden" name="price" id="price" value="">
          <div class="col-lg-6 col-md-12 col-sm-12 {{session()->get('direction') == '2' ? 'text-right' : ''}}">
            <div class="woo_pr_detail">
              <div class="woo_cats_wrps">
                <a href="#" class="woo_pr_cats" id="category_name"></a>
              </div>
              <h5 class="woo_pr_title" id="item_name"></h2>
              <div class="woo_pr_short_desc">
                <h6 id="item_price" class="pricing"></h3>
                <p id="tax"></p>
                <p id="item_description"></p>
              </div>
              <div class="woo_pr_color flex_inline_center mb-3">
                <div class="woo_colors_list">
                  <span id="variation"></span>
                  {{ $errors->login->first('variation') }}
                </div>
              </div>
              <div class="woo_pr_color flex_inline_center mb-3">
                <div class="woo_colors_list">
                  <span id="extras"></span>
                  {{ $errors->login->first('extras') }}
                </div>
              </div>
              <div class="woo_btn_action">
                <input type="hidden" name="restaurant" id="overview_restaurant">
                <input type="hidden" name="item_id" id="overview_item_id">
                <input type="hidden" name="item_name" id="overview_item_name">
                <input type="hidden" name="item_image" id="overview_item_image">
                <input type="hidden" name="item_price" id="overview_item_price">
                <input type="hidden" name="tax" id="tax_val">
                <div class="col-12 col-lg-auto">
                  <button class="btn btn-block btn-dark mb-2 {{ Helper::is_store_closed($getrestaurant->id) == 1 ? 'disabled' : '' }}" @if(Helper::is_store_closed($getrestaurant->id) == "2") onclick="AddtoCart()" @endif>{{ trans('labels.add_to_cart') }} <i class="ti-shopping-cart-full ml-2"></i></button>
                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
<!-- MODAL-INFORMATION -->
<div class="modal fade" id="infomodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                  <img class="rounded width-50" src="{{ Helper::webinfo(@$getrestaurant->id)->image }}">
                  {{ Helper::getrestaurant($getrestaurant->slug)->name }}
              </h5>
              <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
              </button>
          </div>
          <div class="modal-body">
              <div class="modal-store-information">
                  <div class="store-timings mb-4">
                      <h5 class="card-header text-center"> {{ trans('labels.working_hours') }}</h5>
                      @if (is_array(@Helper::timings($getrestaurant->id)) || is_object(@Helper::timings($getrestaurant->id)))
                          @foreach (@Helper::timings($getrestaurant->id) as $time)
                              <div class="d-flex justify-content-between">
                                  <span> @if ($time->day == 'Monday')
                                      {{ trans('labels.monday') }}
                                  @endif
                                  @if ($time->day == 'Tuesday')
                                      {{ trans('labels.tuesday') }}
                                  @endif
                                  @if ($time->day == 'Wednesday')
                                      {{ trans('labels.wednesday') }}
                                  @endif
                                  @if ($time->day == 'Thursday')
                                      {{ trans('labels.thursday') }}
                                  @endif
                                  @if ($time->day == 'Friday')
                                      {{ trans('labels.friday') }}
                                  @endif
                                  @if ($time->day == 'Saturday')
                                      {{ trans('labels.saturday') }}
                                  @endif
                                  @if ($time->day == 'Sunday')
                                      {{ trans('labels.sunday') }}
                                  @endif </span>
                                  <span>
                                      {{ $time->is_always_close == 1 ? trans('labels.closed') : $time->open_time . ' ' . trans('labels.to') . ' ' . $time->close_time }}
                                  </span>
                              </div>
                          @endforeach
                      @endif
                  </div>
                  <div class="store-timings mb-4 text-center">
                      <h5 class="card-header text-center"> {{ trans('labels.about') }} </h5>
                      <i class="fal fa-light fa-mobile"></i> {{ trans('labels.contact') }} :
                      {{ Helper::webinfo($getrestaurant->id)->contact }} <br>
                      <i class="fal fa-map-marker-alt"></i> {{ trans('labels.address') }} :
                      {{ Helper::webinfo($getrestaurant->id)->address }}
                  </div>
                  <div class="services mb-4 text-center">
                      <h5 class="card-header text-center"> {{ trans('labels.types_services') }}</h5>
                      @if (Helper::webinfo($getrestaurant->id)->delivery_type == 'both')
                          <i class="fa fa-check"></i> {{ trans('labels.delivery') }} <i class="fa fa-check"></i>
                          {{ trans('labels.pickup') }}
                      @elseif (Helper::webinfo($getrestaurant->id)->delivery_type == 'delivery')
                          <i class="fa fa-check"></i> {{ trans('labels.delivery') }}
                      @elseif (Helper::webinfo($getrestaurant->id)->delivery_type == 'pickup')
                          <i class="fa fa-check"></i> {{ trans('labels.pickup') }}
                      @endif
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- End Modal -->
<input type="hidden" name="currency" id="currency" value="{{Helper::webinfo($getrestaurant->id)->currency}}">
<!-- Age Verification Modal -->
<div class="modal fade" id="restaurantplan" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <!-- <div class="modal-header">
          <h4 class="modal-title">MUST BE 18+ TO ENTER</h4>
      </div> -->
      <div class="modal-body">
        <div class="col-lg-12">
          <img src="{{Helper::webinfo(@$getrestaurant->id)->image}}" class="img-responsive center-block d-block mx-auto" alt="Sample Image" width="100px">
        </div>
        <h3 class="hidden-xs mt-5" style="text-align: center;"><strong>{{ trans('labels.restaurant_is_unavailable') }}</strong></h3>
      </div>
    </div>
  </div>
</div>
<!-- View order btn -->
@if (session()->get('cart') && $getrestaurant->id == session()->get('restaurant_id') && request()->route()->getName() != "front.cart")
<a href="{{URL::to($getrestaurant->slug.'/cart/')}}" class="cart-btn {{ session()->get('direction') == 2 ? 'cart-button-rtl' : 'cart-button' }}"><i class="fas fa-shopping-cart"></i><span id="cartcnt">{{session()->get('cart')}}</span></a>
@endif
<!-- View order btn -->
<!-- jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- bootstrap js -->
<script src="{!! asset('storage/app/public/front/js/bootstrap.bundle.js') !!}"></script>
<!-- owl.carousel js -->
<script src="{!! asset('storage/app/public/front/js/owl.carousel.min.js') !!}"></script>
<!-- lazyload js -->
<script src="{!! asset('storage/app/public/front/js/lazyload.js') !!}"></script>
<!-- custom js -->
<script src="{!! asset('storage/app/public/front/js/custom.js') !!}"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="{!! asset('storage/app/public/assets/plugins/sweetalert/js/sweetalert.min.js') !!}"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/jquery.validate.js')}}" type="text/javascript"></script>
@yield('script')
<script type="text/javascript">
  $(window).on('load', function() {
    $('#preloader').hide();
  });

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

  toastr.options = {
    "closeButton": true,
    "progressBar": true
  }

  function paymentError(msg) {
    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "timeOut": 10000
    }
    toastr.error(msg);
  }

  function GetProductOverview(id) {
    $('#preloader').show();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ URL::to('product-details/details') }}",
      data: {
        id: id
      },
      method: 'POST', //Post method,
      dataType: 'json',
      success: function(response) {
        $('#preloader').hide();
        jQuery("#viewproduct-over").modal('show');
        $('#overview_restaurant').val(response.ResponseData.restaurant);
        $('#overview_item_id').val(response.ResponseData.id);
        $('#overview_item_name').val(response.ResponseData.item_name);
        $('#overview_item_image').val(response.ResponseData.image_name);
        $('#overview_item_price').val(response.ResponseData.item_price);
        $('#item_name').text(response.ResponseData.item_name);
        $('#item_description').text(response.ResponseData.description);
        $('#category_name').text(response.ResponseData.name);
        $('#tax_val').val(response.ResponseData.tax);
        $('.gallerys').html("<img src=" + response.ResponseData.image +
          " class='img-fluid rounded' width='100%''>");
        // if (response.ResponseData.tax == null || response.ResponseData.tax == 0) {
        //   $('#tax').html("<span style='color: green'>{{trans('labels.include_tax')}}</span>");
        // } else {
        //   $('#tax').html("<span style='color: red'>" + response.ResponseData.tax +
        //     "% {{ trans('labels.additional_tax') }}</span>");
        // }
        var e;
        var i;
        var sessionValue = $("#hdnsession").val();
        var classforview = "";
        var classforul = "extra-food";
        if (sessionValue == "2") {
          var classforview = "d-flex";
          var classforul = "mr-0 pr-2 extra-food-rtl";
        }
        let html = '';
        html += '<ul class="list-unstyled ' + classforul + '"><div id="pricelist">';
        for (e in response.ResponseData.extras) {
          if (response.ResponseData.extras[e].price < 0) {
            html += '<li><input type="checkbox" name="addons[]" extras_name="' + response
              .ResponseData.extras[e].name + '" class="Checkbox" value="' + response
              .ResponseData.extras[e].id + '" price="' + response.ResponseData.extras[e]
              .price + '"><p>' + response.ResponseData.extras[e].name + '</p></li>'
          } else {
            html += '<li><input type="checkbox" name="addons[]" extras_name="' + response
              .ResponseData.extras[e].name + '" class="Checkbox" value="' + response
              .ResponseData.extras[e].id + '" price="' + response.ResponseData.extras[e]
              .price + '"><p>' + response.ResponseData.extras[e].name + ' : ' + currency_format(parseFloat(response.ResponseData.extras[e].price)) + '</p></li>'
          }
        }
        html += '</div></ul>';
        $('#extras').html(html);
        let varhtml = '';
        for (i in response.ResponseData.variation) {
          if (i == 0) {
            var checked = "checked";
            $('#price').val(response.ResponseData.variation[i].price);
            $('#item_price').text(currency_format(parseFloat(response.ResponseData.variation[i].price)));
            $('#overview_item_price').val(response.ResponseData.variation[i].price);
          } else {
            var checked = "";
          }
          varhtml += '<div class="custom-varient custom-size"><input type="radio" ' + checked +
            ' variation-id="' + response.ResponseData.variation[i].id +
            '" class="custom-control-input Radio" name="variation" id="variation-' + i + '-' +
            response.ResponseData.variation[i].item_id + '" variants_name="' + response
            .ResponseData.variation[i].name + '" value="' + response.ResponseData.variation[i]
            .name + ' - ' + response.ResponseData.variation[i].price + '" price="' + response
            .ResponseData.variation[i].price +
            '"><label class="custom-control-label" for="variation-' + i + '-' + response
            .ResponseData.variation[i].item_id + '">' + response.ResponseData.variation[i]
            .name + ' - ' + currency_format(parseFloat(response.ResponseData.variation[i].price)) +'</label></div>'
        }
        $('#variation').html(varhtml);
        if (response.ResponseData.variation.length === 0) {
          $('#price').val(response.ResponseData.item_price);
          $('#item_price').text(response.ResponseData.item_p);
          $('#overview_item_price').val(response.ResponseData.item_price);
        }
      },
      error: function(error) {
        $('#preloader').hide();
      }
    })
  }
  function AddtoCart() {
    var restaurant = $('#overview_restaurant').val();
    var item_id = $('#overview_item_id').val();
    var item_name = $('#overview_item_name').val();
    var item_image = $('#overview_item_image').val();
    var item_price = $('#overview_item_price').val();
    var tax = $('#tax_val').val();
    var price = $('#price').val();
    var variants_id = $('input[name="variation"]:checked').attr("variation-id");
    var variants_name = $('input[name="variation"]:checked').attr("variants_name");
    var variants_price = $('input[name="variation"]:checked').attr("price");
    var extras_id = ($('.Checkbox:checked').map(function() {
      return this.value;
    }).get().join(', '));
    var extras_name = ($('.Checkbox:checked').map(function() {
      return $(this).attr('extras_name');
    }).get().join(', '));
    var extras_price = ($('.Checkbox:checked').map(function() {
      return $(this).attr('price');
    }).get().join(', '));
    $('#preloader').show();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ URL::to('/add-to-cart') }}",
      data: {
        restaurant: restaurant,
        item_id: item_id,
        item_name: item_name,
        item_image: item_image,
        item_price: item_price,
        tax: tax,
        variants_id: variants_id,
        variants_name: variants_name,
        variants_price: variants_price,
        extras_id: extras_id,
        extras_name: extras_name,
        extras_price: extras_price,
        qty: '1',
        price: price
      },
      method: 'POST', //Post method,
      dataType: 'json',
      success: function(response) {
        $("#preloader").hide();
        if (response.status == 1) {
          $('#cartcnt').text(response.cartcnt);
          location.reload();
        } else {
          $("#viewproduct-over").modal('hide');
          $('#ermsg').text(response.message);
          $('#error-msg').addClass('alert-danger');
          $('#error-msg').css("display", "block");
          setTimeout(function() {
            $("#success-msg").hide();
          }, 5000);
        }
      },
      error: function(error) {}
    })
  };
  $('body').on('change', 'input[type="checkbox"]', function(e) {
    var total = parseFloat($("#price").val());
    if ($(this).is(':checked')) {
      total += parseFloat($(this).attr('price')) || 0;
    } else {
      total -= parseFloat($(this).attr('price')) || 0;
    }
    $('h3.pricing').text(currency_format(parseFloat(total)));
    $('#price').val(total);
  })
  $('body').on('change', 'input[type="radio"]', function(e) {
    $('h3.pricing').text(currency_format(parseFloat($(this).attr('price'))));
    $('#price').val(parseFloat($(this).attr('price')));
    $('input[type=checkbox]').prop('checked', false);
  })
  $(window).on('load', function() {
    var restaurant = "{{$getrestaurant->id}}";
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ URL::to('/orders/checkplan') }}",
      data: {
        restaurant: restaurant,
      },
      method: 'POST',
      success: function(response) {
        if (response.status == 2) {
          $('#restaurantplan').modal('show');
        } else {
          $('#restaurantplan').modal('hide');
        }
      },
      error: function(error) {
      }
    });
  });
  function currency_format(price) {
    if ("{{ @Helper::webinfo($getrestaurant->id)->currency_position }}" == "left") {
      return "{{ @Helper::webinfo($getrestaurant->id)->currency }}" + parseFloat(price).toFixed(2);
    } else {
      return parseFloat(price).toFixed(2) + "{{ @Helper::webinfo($getrestaurant->id)->currency }}";
    }
  }
  $('.cat-check').on('click', function() {
    if ($(this).attr('data-cat-type') == 'first') {
      $('html, body').animate({
        scrollTop: 0
      }, '1000');
    }
    $('.cat-aside-wrap').find('.active').removeClass('active');
    $(this).addClass('active');
  });
  function RemoveCart(cart_id) {
        swal({
            title: "{{ trans('messages.are_you_sure') }}",
            type: 'error',
            showCancelButton: true,
            confirmButtonText: "{{ trans('messages.yes') }}",
            cancelButtonText: "{{ trans('messages.no') }}"
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ URL::to('/cart/deletecartitem') }}",
                    data: {
                        cart_id: cart_id
                    },
                    method: 'POST',
                    success: function(response) {
                        if (response.status == 1) {
                            location.reload();
                        } else {
                            swal("Cancelled", "{{ trans('messages.wrong') }} :(", "error");
                        }
                    },
                    error: function(e) {
                        swal("Cancelled", "{{ trans('messages.wrong') }} :(", "error");
                    }
                });
            } else {
                swal("Cancelled", "{{ trans('messages.record_safe') }} :)", "error");
            }
        });
    }
    function qtyupdate(cart_id,item_id,type) 
    {
        var qtys= parseInt($("#number_"+cart_id).val());
        var item_id= item_id;
        var cart_id= cart_id;
        if (type == "decreaseValue") {
            qty= qtys-1;
        } else {
            qty= qtys+1;
        }
        if (qty >= "1") {
            $('#preloader').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ URL::to('/cart/qtyupdate') }}",
                data: {
                    cart_id: cart_id,
                    qty:qty,
                    item_id,item_id,
                    type,type
                },
                method: 'POST',
                success: function(response) {
                    $('#preloader').hide();
                    if (response.status == 1) {
                        location.reload();
                    } else {
                        $('#ermsg').text(response.message);
                        $('#error-msg').addClass('alert-danger');
                        $('#error-msg').css("display","block");
                        setTimeout(function() {
                            $("#success-msg").hide();
                        }, 5000);
                    }
                },
                error: function(error) {
                }
            });
        } else {
            $('#preloader').show();
            if (qty < "1") {
                $('#ermsg').text("Você atingiu as unidades mínimas permitidas para a compra deste item");
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display","block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
            }
        }
    }
</script>
</body>
</html>