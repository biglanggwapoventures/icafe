@extends('user.layout')
@push('css')
<style type="text/css">
    table.layout{
        table-layout: fixed;
    }

    .table.layout td:hover{
        background: #eee;
        color:white;
        cursor: pointer;;
    }

    .table.layout td{
        text-align: center;
        vertical-align: middle!important;
        height:50px;
        padding: 0;
    }

</style>
@endpush

@section('content')
<h4 class="text-center border-bottom pb-1">

    {{ $cafeBranch->cafe->name }}
    <small class="d-block text-muted">{{ $cafeBranch->address }}</small>
</h4>
<div class="row">
    <div class="col">
        <ul class="list-inline text-center  mb-0">
            <li class="list-inline-item"><strong>Legend:</strong></li>
              <li class="list-inline-item text-success"><i class="fa fa-desktop"></i> Available</li>
              <li class="list-inline-item text-danger"><i class="fa fa-desktop"></i> Unavailable</li>
        </ul>
        <ul class="list-inline mt-0 clearfix">
              <li class="list-inline-item float-left"><a href="{{ route('user.') }}"><i class="fa fa-arrow-left"></i> Go back to cafe list</a></li>
              <li class="list-inline-item float-right"><i class="fa fa-mouse-pointer"></i> Click on a computer to start</li>
        </ul>
    </div>
</div>
<table class="table layout table-bordered">
    <tbody>
        @foreach(range(1,20) AS $row)
            <tr data-y="{{ $row }}">
                @foreach(range(1,20) AS $column)
                    @php $pc = optional($coordinates->get($row))->get($column) @endphp
                    <td
                        data-status="{{ optional($pc)->status }}"
                        data-number="{{ optional($pc)->name }}"
                        data-x="{{ $column }}"
                        data-pk="{{ optional($pc)->id }}"
                        class="{{ optional($pc)->status === 'unavailable' ? 'text-danger' : 'text-success' }} reserve">
                        @if($pc)
                            <span class="d-block">{{ $pc->name }}</span>
                            <i class="fa fa-desktop"></i>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@push('modals')
<div class="modal fade" id="reservation-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-get-reservations="{{ route('pc-reservations', ['pc' => '__IDX__']) }}">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    {!! Form::open(['url' => route('user.cafe.reserve', compact('cafeBranchId')), 'method' => 'post', 'class' => 'ajax']) !!}
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-3">
                    {!! Form::inputGroup('date', 'Reservation Date', 'reservation_date', now()->format('Y-m-d'), ['min' => now()->format('Y-m-d')]) !!}
                    {!! Form::inputGroup('time', 'Reservation Time', 'reservation_time') !!}
                    {!! Form::inputGroup('number', 'Duration (in hours)', 'duration_in_hours') !!}
                    {!! Form::hidden('floor_plan_id', null, ['id' => 'floor-plan-id']) !!}
                </div>
                <div class="col-sm-9" id="reservations-section">

                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit reservation</button>
      </div>
    {!! Form::close() !!}
    </div>
  </div>
</div>
@endpush


@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.reserve').click(function () {
            var $this = $(this),
                modal = $('#reservation-form');
            if($this.data('status') !== 'available') {
                alert('Cannot make reservation on an unavailable PC')
                return;
            }
            modal.find('.modal-title').html(function () {
                return 'PC # ' + $this.data('number');
            })
            modal.modal('show')
            modal.find('#floor-plan-id').val($this.data('pk'))
            modal.find('#reservations-section').html('<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading reservations</div>')
            $.get(modal.data('get-reservations').replace('__IDX__', $this.data('pk')))
                .done(function (table) {
                    modal.find('#reservations-section').html(table)
                })
        })
    });
</script>
@endpush
