@include('front.theme.header')

<section class="product-prev-sec product-list-sec pt-3">
    <div class="container">
        <div class="product-rev-wrap">
            <div class="cat-aside cat-aside-theme1">
                <div class="cat-aside-wrap">
                    @foreach ($getcategory as $key => $category)
                    <a href="#{{ $category->slug }}" class="cat-check border-top-no {{$key==0?'active':''}}" data-cat-type="{{$key==0?'first':''}}">
                        <p>{{ $category->name }}</p>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="cat-product px-4">
                @foreach ($getcategory as $key => $category)
                    @if ($key != 0)
                    <hr>
                    @endif
                    <div class="card-header bg-transparent px-0" id="{{ $category->slug }}">
                        <h4 class="{{session()->get('direction') == 2 ? 'text-right' : '' }}">{{ $category->name }}</h4>
                    </div>
                    <div class="row recipe-card">
                        @if(!$getcategory->isEmpty())
                            @php $i = 0; @endphp
                            @foreach ($getitem as $item)
                                @if ($category->id == $item->cat_id)
                                <div class="col-xl-4 col-md-6 mb-3" id="pro-box">
                                    <div class="pro-box">
                                        <div class="pro-img">
                                            <img src="{{asset('storage/app/public/item/'.$item->image)}}" alt="">
                                        </div>
                                        <div class="product-details-wrap">
                                            <div class="product-details">

                                                <h4 id="itemname" onclick="GetProductOverview('{{$item->id}}')"  class="{{session()->get('direction') == 2 ? 'text-right' : '' }}">{{$item->item_name}}</h4>

                                                <p class="pro-pricing">

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

                                            <div class="product-details">
                                                <p class=" px-0 mb-0 {{ session()->get('direction') == '2' ? 'pl-2 pr-0 text-right' : '' }}">{{ Str::limit($item->description, 100) }}</p>
                                            </div>
                                            <div class="product-details">
                                                <button class="btn btn-sm m-0 py-1 col-sm-12 height-fit-content" onclick="GetProductOverview('{{$item->id}}')">{{trans('labels.add_to_cart')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php $i += 1; @endphp
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@include('front.theme.footer')