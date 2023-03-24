<table class="table table-striped table-bordered zero-configuration dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
    <thead>
        <tr role="row">
            <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 88.5469px;">#</th>
            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 263.641px;">{{trans('labels.name')}}</th>
            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 193.422px;">{{trans('labels.status')}}</th>
            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 189.391px;">{{trans('labels.action')}}</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($payments) && count($payments)>0)
        @foreach($payments as $key => $rdata)
        @if($rdata->payment_name == "RazorPay" || $rdata->payment_name == "Stripe")
            @continue
        @endif
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$rdata->payment_name}}</td>
            <td>
                @if (env('Environment') == 'sandbox')
                    @if($rdata->status == 1)
                        <a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
                    @else
                        <a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
                    @endif
                @else
                    @if($rdata->status == 1)
                        <a class="success p-0" onclick="status('{{$rdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/payments/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
                    @else
                        <a class="danger p-0" onclick="status('{{$rdata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('admin/payments/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
                    @endif
                @endif
            </td>
            <td>
                @if($rdata->payment_name != "COD")
                    <a href="{{ URL::to('admin/payments/edit-'.$rdata->_id) }}">
                        <span class="badge badge-warning">{{trans('labels.view')}}</span>
                    </a>
                @endif
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>