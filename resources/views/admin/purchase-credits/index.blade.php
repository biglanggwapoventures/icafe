@extends('admin.layout')

@section('content')
@if($message = session('load-success'))
  <div class="alert alert-success mb-0 mt-2"><i class="fa fa-check"></i> {{ $message }}</div>
@endif
<div class="card mt-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title mb-0">
                    Purchase Credit
                </h4>
            </div>
            <div class="col text-right">
                <a href="#" data-toggle="modal" data-target="#purchase-credit-modal" class="btn btn-primary">New purchase</a>
            </div>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Client</th>
                <th>Admin</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resourceList as $row)
              <tr>
                <td>{{ date_create($row->created_at)->format('M d, Y h:i A') }}</td>
                <td>{{ $row->client->name }}</td>
                <td>{{ $row->admin->name }}</td>
                <td class="text-right">{{ number_format($row->credit, 2) }}</td>
              </tr>
            @empty
            @endif
        </tbody>
    </table>
</div>
@endsection

@push('modals')
<div class="modal fade" id="purchase-credit-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add credits</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(['url' => route('admin.purchase-credits.store'), 'class' =>'ajax']) !!}
        <div class="modal-body">
              {!! Form::selectGroup('Select user', 'client_id', $userList->prepend('* SELECT *', ''), null, ['class' => 'user-list'])!!}
              {!! Form::inputGroup('number', 'Amount', 'credit' ,null, ['min' => '0', 'step' => '1'])!!}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">OK</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
@endpush

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
      $('.user-list').css({
        'width': '100%'
      }).select2();
    });
</script>
@endpush
