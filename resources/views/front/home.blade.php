@include('front.theme.header')


<section class="product-prev-sec product-list-sec">
    <div class="container">

        <div class="row product-rev-wrap">

            <div class="col-lg-3 col  pro-sec pro-top">
                <div class="cart-pro-head">
                    <h2 class="sec-head">{{ trans('labels.categories') }}</h2>
                    <div class="cat-aside">
                        <div class="cat-aside-wrap">
                            <a href="{{ URL::to($getrestaurant->slug) }}" class="cat-check border-top-no @if (request()->id == '') active @endif">
                                <p>{{ trans('labels.all') }}</p>
                            </a>
                            @foreach ($getcategory as $category)
                            <a href="{{ URL::to($getrestaurant->slug . '/product/' . $category->id) }}" class="cat-check border-top-no @if (request()->id == $category->id) active @endif">
                                <p>{{ $category->name }}</p>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col mt-6">
                <div class="cart-pro-head pro-fix">
                    <h2 class="sec-head mb-2">{{ trans('labels.our_products') }}</h2>
                </div>
                @foreach ($getitem as $item)
                <div class="justify-content-center">
                    <div class="card mb-3">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-auto">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->item_name }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($item->description, 60) }}</p>
                                    <p class="card-text">
                                        @if (count($item['variation']) > 0)
                                        @foreach ($item->variation as $key => $value)
                                        {{ Helper::currency_format($value->price, $getrestaurant->id) }}
                                        @break
                                        @endforeach
                                        @else
                                        {{ Helper::currency_format($item->item_price, $getrestaurant->id) }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-auto">
                                <div class="d-grid p-3 justify-items-center">
                                    <img src="{{ asset('storage/app/public/item/' . $item->image) }}" class="img-fluid rounded mb-3" alt="...">

                                    <button class="btn btn-success btn-sm py-0 px-3 mb-2">ADD</button>
                                    <a href="#">Customisable</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach

            </div>
            <div class="col-lg-3 cart-sec">
                <div class="pro-sec">
                    <div class="cart-pro-head">
                        <h2 class="sec-head">{{ trans('labels.my_cart') }}</h2>
                    </div>
                    <div class="card py-3">
                        <div class="card-body py-0">
                            <div class="d-flex pb-2 border-bottom mb-3">
                                <div class="col-9 px-0">
                                    <h5 class="card-title card-font mb-0">Butter Locho</h5>
                                    <ul class="p-0 text-muted list-font">
                                        <li>Extra Cheese</li>
                                        <li>Extra Cheese</li>
                                        <li>Extra Cheese</li>
                                    </ul>
                                </div>

                                <div class="col-3 px-0 d-grid justify-items-end">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                    <div class="number my-2">
                                        <button class="btn minus">-</button>
                                        <input type="text" value="1" readonly>
                                        <button class="btn plus">+</button>
                                    </div>
                                    <p>$75</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="col-9 px-0">
                                    <h5 class="mb-0 font-weight-bold text-success">Subtotal</h5>
                                    <small class="text-muted">Extra charges may apply</small>
                                </div>
                                <div class="col-3 px-0">
                                    <h5 class="text-right text-success">$75</h5>
                                </div>
                            </div>
                            <div class="mt-3 check-btn">
                                <button href="#" class="btn btn-success btn-lg">Checkout
                                    <div class="disply-inline">
                                        <i class="fas fa-long-arrow-alt-right align-middle"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('front.theme.footer')