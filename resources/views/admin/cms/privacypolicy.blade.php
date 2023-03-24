@extends('admin.layout.main')

@section('page_title',trans('labels.privacypolicy'))

@section('content')

    <section id="basic-form-layouts">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title" id="horz-layout-colored-controls">{{trans('labels.privacypolicy')}}</h4>
               </div>
               <div class="card-body">
                  <div class="px-3">
    	               <form name="privacypolicy" id="privacypolicy" method="post" action="{{ URL::to('/vendor/privacypolicy/update')}}">
                            @csrf
                            <textarea class="form-control" id="ckeditor" name="privacypolicy">{{@$getprivacypolicy->privacypolicy_content}}</textarea>
                            @if (env('Environment') == 'sandbox')
                                <button type="button" class="btn btn-primary mt-3" onclick="myFunction()">{{ trans('labels.update') }}</button>
                            @else
                                <button type="submit" class="btn btn-primary mt-3">{{ trans('labels.update') }}</button>
                            @endif
                        </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'ckeditor');
    CKEDITOR.config.extraPlugins=['colorbutton','justify'];
</script>
@endsection