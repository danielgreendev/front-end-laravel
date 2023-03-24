@include('front.theme.header')

<section class="product-prev-sec product-list-sec">
    <div class="container">
    <h2 class="sec-head text-center">{{trans('labels.privacypolicy')}}</h2>
        <div class="product-rev-wrap">
            {!!@$privacypolicy->privacypolicy_content!!}
        </div>
    </div>
</section>

@include('front.theme.footer')