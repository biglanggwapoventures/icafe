@extends('user.layout')
@push('css')
<style type="text/css">
    .table td{
        vertical-align: middle!important;
    }
</style>
@endpush
@section('content')
<h4 class="mb-3"><i class="fa fa-coin"></i> Your Credit History</h4>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Date</th>
            <th>Cafe</th>
            <th class="text-right">Loaded</th>
            <th class="text-right">Spent</th>
            <th class="text-right">Balance</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $row)
            <tr>
                <td>{{ date_create($row->created_at)->format('M d, Y h:i a') }}</td>
                <td><strong class="d-block mb-0">{{ $row->cafeBranch->cafe->name }}</strong><small>{{ $row->cafeBranch->address }}</small></td>
                <td class="text-success text-right"><p class="lead mb-0">{{ $row->credit ? number_format($row->credit, 1) : '' }}</p></td>
                <td class="text-danger text-right"><p class="lead mb-0">{{ $row->debit ? number_format($row->debit, 1) : '' }}</p></td>
                <td class="text-primary text-right"><p class="lead mb-0">{{ number_format($row->running_balance, 1) }}</p></td>
            </tr>
        @empty
            <tr colspan="4" class="text-center text-info"><i class="fa fa-info-circle">No logs to show</i></tr>
        @endforelse
    </tbody>
</table>
@endsection
