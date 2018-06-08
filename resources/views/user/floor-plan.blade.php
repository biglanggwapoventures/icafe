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

    .form-row .form-group{
        margin-bottom: 0px;
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
              <li class="list-inline-item text-warning"><i class="fa fa-desktop"></i> Reserved</li>
              <li class="list-inline-item text-danger"><i class="fa fa-desktop"></i> Unavailable</li>
        </ul>
        <ul class="list-inline mt-0 mb-1 text-center">
              <li class="list-inline-item "><a href="{{ route('user.') }}"><i class="fa fa-chevron-left"></i> Go back to cafe list</a></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card bg-info text-white mb-2">
            <div class="card-body pt-2 pb-3 d-flex justify-content-center">
                {!! Form::open(['url' => url()->current(), 'method' => 'get']) !!}
                    <div class="form-row ">
                        <div class="col-4">Reservation Date</div>
                        <div class="col-3">Reservation Time</div>
                        <div class="col-3">Duration in hours</div>
                    </div>
                    <div class="form-row align-items-center">
                        <div class="col-4">
                            {!! Form::inputGroup('date', null, 'reservation_date', $reservationDate, ['min' => now()->format('Y-m-d')]) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::inputGroup('time', null, 'reservation_time', $reservationTime) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::inputGroup('number', null, 'duration_in_hours', $duration) !!}
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-default btn-block"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<table class="table layout table-bordered">
    <tbody>
        @foreach(range(1,20) AS $row)
            <tr data-y="{{ $row }}">
                @foreach(range(1,20) AS $column)
                    @php $pc = optional($coordinates->get($row))->get($column) @endphp
                    @if($pc && $pc->is('unavailable'))
                        <td class="text-danger">
                            <span class="d-block">{{ $pc->name }}</span>
                            <i class="fa fa-desktop"></i>
                        </td>
                    @elseif($pc && $pc->is('available'))
                        <td data-name="{{ $pc->name }}" data-pk="{{ $pc->id }}" class="{{ $pc->conflicts ? 'text-warning' : 'text-success' }} reserve" data-conflicts="{{ intval($pc->conflicts) }}">
                            <span class="d-block">{{ $pc->name }}</span>
                            <i class="fa fa-desktop"></i>
                        </td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@push('modals')
<div class="modal fade" id="reservation-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    {!! Form::open(['url' => route('user.cafe.reserve', compact('cafeBranchId')), 'method' => 'post', 'class' => 'ajax']) !!}
      <div class="modal-body p-0">
        <table class="table">
            <thead>
                <tr>
                    <th>PC #</th>
                    <th>Date</th>
                    <th>Duration</th>
                    <th>Credits</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="pc"></td>
                    <td>
                        {{ date_create($reservationDate)->format('M d, Y')  }}
                        {!! Form::hidden('reservation_date', $reservationDate) !!}
                    </td>
                    <td>
                        {{ date_create($reservationTime)->format('h:i a')  }}
                        &mdash;
                        {{ date_create($reservationTime)->modify("+{$duration} hours")->format('h:i a')  }}
                        <br>
                        <strong>{{ "{$duration} hour(s)" }}</strong>
                        {!! Form::hidden('reservation_time', $reservationTime) !!}
                        {!! Form::hidden('duration_in_hours', $duration) !!}
                        {!! Form::hidden('floor_plan_id', null, ['id' => 'floor-plan-id']) !!}
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
           {{--  <div class="row">
                <div class="col-sm-3">
                    {!! Form::inputGroup('date', 'Reservation Date', 'reservation_date', now()->format('Y-m-d'), ['min' => now()->format('Y-m-d')]) !!}
                    {!! Form::inputGroup('time', 'Reservation Time', 'reservation_time') !!}
                    {!! Form::inputGroup('number', 'Duration (in hours)', 'duration_in_hours') !!}
                    {!! Form::hidden('floor_plan_id', null, ['id' => 'floor-plan-id']) !!}
                </div>
                <div class="col-sm-9" id="reservations-section">

                </div>
            </div> --}}
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
        $('[data-conflicts=0].reserve').click(function () {
            $('#reservation-form .table tbody .pc').text($(this).data('name'))
            $('#reservation-form .table tbody #floor-plan-id').val($(this).data('pk'))
            $('#reservation-form').modal('show')
        })
    });
</script>
@endpush
