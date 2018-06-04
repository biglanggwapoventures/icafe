@extends('admin.layout')
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
<div class="row">
    <div class="col">
        <ul class="list-inline mt-3 mb-3 clearfix">
            <li class="list-inline-item"><strong>Legend:</strong></li>
              <li class="list-inline-item text-success"><i class="fa fa-desktop"></i> Available</li>
              <li class="list-inline-item text-danger"><i class="fa fa-desktop"></i> Unavailable</li>
              <li class="list-inline-item float-right">Click on a computer to view reservations</li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <table class="table layout table-bordered" id="cafe" data-get-reservations="{{ route('pc-reservations', ['pc' => '__IDX__']) }}">
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
    </div>
    <div class="col-sm-4" >
        <div class="card">
            <div class="card-header">Reservations</div>
            <div class="card-body p-0" id="reservations-section">

            </div>
        </div>
    </div>
@endsection


@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.reserve').click(function () {
            var $this = $(this),
                cafe = $('#cafe'),
                section = $('#reservations-section');

            if($this.data('status') !== 'available') {
                return;
            }

            section.html('<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading reservations</div>');
            $.get(cafe.data('get-reservations').replace('__IDX__', $this.data('pk')))
                .done(function (table) {
                    section.html(table)
                })

        })
    });
</script>
@endpush
