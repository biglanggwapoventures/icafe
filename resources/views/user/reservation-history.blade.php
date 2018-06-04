@extends('user.layout')
@push('css')
<style type="text/css">
    .table td{
        vertical-align: middle!important;
    }
</style>
@endpush
@section('content')
<h4 class="mb-3"><i class="fa fa-coin"></i> Your Reservation History</h4>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Date</th>
            <th>Cafe</th>
            <th>Start</th>
            <th>End</th>
            <th class="text-right">Credits Used</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $row)
            <tr>
                <td>{{ date_create($row->reservation_date)->format('M d, Y') }}</td>
                <td>
                    <p class="lead mb-0">PC {{ $row->pc->name }}</p>
                    <strong class="d-block mb-0">{{ $row->pc->cafeBranch->cafe->name }}</strong>
                    <small>{{ $row->pc->cafeBranch->address }}</small>
                </td>
               <td>{{ date_create_from_format('H:i:s', $row->reservation_time)->format('h:i a') }}</td>
               <td>{{ $row->reservation_ends_at->format('h:i a') }}</td>
                <td class="text-primary text-right"><p class="lead mb-0">{{ number_format($row->credit, 1) }}</p></td>
            </tr>
        @empty
            <tr colspan="5" class="text-center text-info"><i class="fa fa-info-circle">No logs to show</i></tr>
        @endforelse
    </tbody>
</table>
@endsection
