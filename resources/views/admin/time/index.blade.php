@extends('admin.layout.main')

@section('page_title',trans('labels.working_hours'))

@section('content')
   <section id="basic-form-layouts">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title" id="horz-layout-colored-controls">{{trans('labels.working_hours')}}</h4>
               </div>
               <div class="card-body">
                  <div class="px-3">
    	               <form action="{{URL::to('vendor/working-hours/edit')}}" method="post">
    	                	@csrf
                        <div class="form-row">
    	                		<label class="col-sm-2 col-form-label"></label>
    	                	   <div class="form-group col-md-3 text-center"><label class="font-weight-bold" >{{trans('labels.opening_time')}}</label></div>
    	                	   <div class="form-group col-md-3 text-center"><label class="font-weight-bold" >{{trans('labels.closing_time')}}</label></div>
                           <div class="form-group col-md-3 text-center"><label class="font-weight-bold" >{{trans('labels.always_closed')}}</label></div>
    	                	</div>
                        @foreach($timingdata as $time)
                           <div class="form-row">
                              <label class="col-sm-2 form-label text-center font-weight-bold">
                                 @if ($time->day == "Monday")
                                    {{ trans('labels.monday') }}
                                 @endif
                                 @if ($time->day == "Tuesday")
                                    {{ trans('labels.tuesday') }}
                                 @endif
                                 @if ($time->day == "Wednesday")
                                    {{ trans('labels.wednesday') }}
                                 @endif
                                 @if ($time->day == "Thursday")
                                    {{ trans('labels.thursday') }}
                                 @endif
                                 @if ($time->day == "Friday")
                                    {{ trans('labels.friday') }}
                                 @endif
                                 @if ($time->day == "Saturday")
                                    {{ trans('labels.saturday') }}
                                 @endif
                                 @if ($time->day == "Sunday")
                                    {{ trans('labels.sunday') }}
                                 @endif
                              </label>
                              <input type="hidden" name="day[]" value="{{$time->day}}">
                              <div class="form-group col-md-3">
                                 <input type="text" class="form-control pickatime" placeholder="Opening time" id="open{{$time->day}}" name="open_time[]" @if ($time->is_always_close == '2') value="{{$time->open_time}}" @else value="{{trans('labels.closed')}}" readonly="" @endif>
                              </div>
                              <div class="form-group col-md-3">
                                 <input type="text" class="form-control pickatime" placeholder="Closing Time" id="close{{$time->day}}" name="close_time[]" @if ($time->is_always_close == '2') value="{{$time->close_time}}" @else value="{{trans('labels.closed')}}" readonly="" @endif>
                              </div>
                              <div class="form-group col-md-3">
                                 <select class="form-control" name="is_always_close[]" id="is_always_close{{$time->day}}">
                                    <option value="" disabled >{{ trans('labels.select') }}</option>
                                    <option value="1" @if ($time->is_always_close == '1') selected @endif>{{ trans('messages.yes') }}</option>
                                    <option value="2" @if ($time->is_always_close == '2') selected @endif>{{ trans('messages.no') }}</option>
                                 </select>
                              </div>
                           </div>
                        @endforeach
                        <div class="col-sm-2 form-label text-center">
                           @if (env('Environment') == 'sandbox')
                              <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                           @else
                              <button type="submit" class="btn btn-primary btn-raised"><i class="ft-edit"></i> {{trans('labels.update')}}</button>
                           @endif
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
<script src="{{asset('storage/app/public/admin-assets/js/jquery.timepicker.js')}}" defer></script>
<script type="text/javascript">
   $(document).ready(function () {
     $("#openMonday").timepicker();
     $("#closeMonday").timepicker();
     $("#openTuesday").timepicker();
     $("#closeTuesday").timepicker();
     $("#openWednesday").timepicker();
     $("#closeWednesday").timepicker();
     $("#openThursday").timepicker();
     $("#closeThursday").timepicker();
     $("#openFriday").timepicker();
     $("#closeFriday").timepicker();
     $("#openSaturday").timepicker();
     $("#closeSaturday").timepicker();
     $("#openSunday").timepicker();
     $("#closeSunday").timepicker();
   });
</script>
@endsection