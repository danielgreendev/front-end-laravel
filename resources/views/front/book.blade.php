@include('front.theme.header')

<section class="product-prev-sec product-list-sec">
    <div class="container">
        <h2 class="sec-head text-center">{{trans('labels.book_table')}}</h2>
        @if (\Session::has('success'))
            <div class="alert alert-success">
                {!! \Session::get('success') !!}
            </div>
        @endif
        <form class="get-quote" action="{{URL::to($getrestaurant->slug.'/tablebook/')}}" method="post">
            @csrf
            <input type="hidden" name="restaurant" id="restaurant" class="form-control" value="{{$getrestaurant->id}}">
            
            <div class="form-row">
                <div class="{{session()->get('direction') == '2' ? 'text-right' : ''}} form-group col-md-6">
                    <label for="type_of_event">{{trans('labels.type_of_event')}}</label>
                    <input type="text" name="type_of_event" id="type_of_event" placeholder="{{trans('labels.type_of_event')}}" class="form-control" required="">
                </div>
                <div class="{{session()->get('direction') == '2' ? 'text-right' : ''}} form-group col-md-6">
                    <label for="no_of_people">{{trans('labels.no_of_people')}}</label>
                    <input type="text" name="no_of_people" id="no_of_people" placeholder="{{trans('labels.no_of_people')}}" class="form-control" required="">
                </div>
            </div>

            <div class="form-row">
                <div class="{{session()->get('direction') == '2' ? 'text-right' : ''}} form-group col-md-6">
                    <label for="date_of_event">{{trans('labels.date_of_event')}}</label>
                    <input type="date" name="date_of_event" id="date_of_event" placeholder="{{trans('labels.date_of_event')}}" class="form-control" required="">
                </div>
                <div class="{{session()->get('direction') == '2' ? 'text-right' : ''}} form-group col-md-6">
                    <label for="time_required">{{trans('labels.time_required')}}</label>
                    <input type="time" name="time_required" id="time_required" placeholder="{{trans('labels.time_required')}}" class="form-control" required="">
                </div>
            </div>

            <div class="{{session()->get('direction') == '2' ? 'text-right' : ''}} form-group">
                <label for="fullname">{{trans('labels.fullname')}}</label>
                <input type="text" name="fullname" id="fullname" placeholder="{{trans('labels.fullname')}}" class="form-control" required="">
            </div>

            <div class="{{session()->get('direction') == '2' ? 'text-right' : ''}} form-group">
                <label for="mobile">{{trans('labels.mobile')}}</label>
                <input type="text" name="mobile" id="mobile" placeholder="{{trans('labels.mobile')}}" class="form-control" required="">
            </div>

            <div class="{{session()->get('direction') == '2' ? 'text-right' : ''}} form-group">
                <label for="email">{{trans('labels.email')}}</label>
                <input type="email" name="email" id="email" placeholder="{{trans('labels.email')}}" class="form-control" required="">
            </div>

            <div class="{{session()->get('direction') == '2' ? 'text-right' : ''}} form-group">
                <label for="additional_requests">{{trans('labels.additional_requests')}}</label>
                <textarea class="form-control" name="additional_requests" id="additional_requests" placeholder="{{trans('labels.additional_requests')}}"></textarea>
            </div>

            <button class="btn text-center" type="submit">{{trans('labels.book')}}</button>
        </form>
    </div>
</section>

@include('front.theme.footer')