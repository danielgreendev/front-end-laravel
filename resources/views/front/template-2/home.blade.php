@include('front.theme.header')

<section class="product-prev-sec product-list-sec pt-3">
    <div class="container">
        <div class="row product-rev-wrap">
            <div class="col-lg-3 pro-sec pro-top">
                <div class="cart-pro-head">
                    <div class="cat-aside">
                        <div class="cat-aside-wrap">
                            @foreach ($getcategory as $key => $category)
                            <a href="#{{ $category->slug }}" class="cat-check border-top-no mt-0 {{$key==0?'active':''}}" data-cat-type="{{$key==0?'first':''}}">
                                <p>{{ $category->name }}</p>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mt-6 recipe-card ">
                @foreach ($getcategory as $key => $category)
                    @if ($key != 0)
                    <hr>
                    @endif
                    <div class="card-header bg-transparent px-0" id="{{ $category->slug }}">
                        <h4 class="{{session()->get('direction') == 2 ? 'text-right' : '' }}">{{ $category->name }}</h4>
                    </div>
                    @if(!$getcategory->isEmpty())
                        @php $i = 0; @endphp
                        @foreach ($getitem as $item)
                            @if ($category->id == $item->cat_id)
                            <div class="card mb-3" id="pro-box">
                                <div class="row ">
                                    <div class="col-md-8 col-sm-8 col-auto mb-0">
                                        <div class="card-body ">
                                            <h5 id="itemname" class="card-title ">{{$item->item_name}}</h5>
                                            <p class="card-text text-muted">{{ Str::limit($item->description, 100) }}</p>
                                            <p class="card-text">
                                                @if(count($item['variation']) > 0)
                                                @foreach ($item->variation as $key => $value)
                                                {{Helper::currency_format($value->price,$getrestaurant->id)}}
                                                @break
                                                @endforeach
                                                @else
                                                {{Helper::currency_format($item->item_price,$getrestaurant->id)}}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-auto mb-0">
                                        <div class="d-grid p-3 pt-0 justify-items-center">
                                            <img src="{{asset('storage/app/public/item/'.$item->image)}}" class="img-fluid rounded mb-3" alt="...">
                                            <button class="btn btn-sm m-0 py-1" onclick="GetProductOverview('{{$item->id}}')">{{trans('labels.add_to_cart')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $i += 1; @endphp
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            <div class="col-lg-3 d-none d-lg-block d-xl-block pro-sec pro-top">
                <div class="cart-pro-head">
                    <div class="cat-aside">
                        <div class="cat-aside-wrap">
                            <div class="card py-3">
                                <div class="card-body py-0">

                                    @if ($cartdata->isEmpty())
                                        <p>{{trans('labels.cart_empty')}}</p>
                                    @else
                                    <script type="text/javascript">console.log("{{$cartdata}}");</script>
                                        <?php $total = 0.0; ?>
                                        @foreach($cartdata as $cart)
                                        <?php $sub_total = 0; ?>
                                        <div class="d-flex pb-3 border-bottom mb-3">
                                            <div class="col-8 px-0 ">
                                                <h5 class="card-title card-font mb-0">{{$cart->item_name}}</h5>
                                                <ul class="p-0 text-muted list-font mb-1"><li>
                                                    @if ($cart->variants_id == null)
                                                        {{Helper::currency_format($cart->item_price,$getrestaurant->id)}}
                                                        <?php $sub_total += floatval($cart->item_price); ?>
                                                    @else
                                                        {{$cart->variants_name}} : {{Helper::currency_format($cart->variants_price,$getrestaurant->id)}}<?php $sub_total += floatval($cart->variants_price); ?>
                                                    @endif
                                                    </li></ul>
                                                @if ($cart->extras_id != null)
                                                    <?php $extra_names = explode(",", $cart->extras_name); $extra_prices = explode(",", $cart->extras_price); ?>
                                                    @foreach($extra_names as $key => $name)
                                                    <span class="badge primary-outline">
                                                        {{$name}} : {{Helper::currency_format($extra_prices[$key], $getrestaurant->id)}}<?php $sub_total += floatval($extra_prices[$key]); ?>
                                                    </span>
                                                    @endforeach
                                                @endif

                                            </div>
                                            <div class="col-4 px-0 d-grid justify-items-end">
                                                <i class="fas fa-trash-alt text-danger" onclick="RemoveCart('{{$cart->id}}')"></i>
                                                <div class="number my-2">
                                                    <button class="btn minus" onclick="qtyupdate('{{$cart->id}}','{{$cart->item_id}}','decreaseValue')">-</button>
                                                    <input type="text" id="number_{{$cart->id}}" name="number" value="{{$cart->qty}}" min="1" max="10" readonly="">
                                                    <button class="btn plus" onclick="qtyupdate('{{$cart->id}}','{{$cart->item_id}}','increase')">+</button>
                                                </div>
                                                <p class=""><?php $sub_total *= floatval($cart->qty); $total += $sub_total; ?>{{Helper::currency_format($sub_total, $getrestaurant->id)}}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="d-flex">
                                            <div class="col-8 px-0 ">
                                            <h6 class="mb-0 font-weight-bold text-success">{{trans('labels.sub_total')}}</h6>
                                            <small class="text-muted">{{trans('labels.extra_charge')}}</small>
                                            </div>
                                            <div class="col-4 px-0">
                                                <h6 class="text-success text-right">{{Helper::currency_format($total, $getrestaurant->id)}}</h6>
                                            </div>
                                        </div>
                                        <div class="mt-3 check-btn">
                                            <a href="{{URL::to($getrestaurant->slug.'/cart')}}" class="btn w-100 btn-lg">Checkout
                                                <div class="disply-inline">
                                                    <i class="fas fa-long-arrow-alt-right align-middle"></i>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('front.theme.footer')