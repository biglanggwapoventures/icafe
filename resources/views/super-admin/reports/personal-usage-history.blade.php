@extends('super-admin.layout')

@section('content')
<div class="card mt-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title mb-0">
                    Personal Usage History
                </h4>
            </div>
        </div>
    </div>

        <div class="card-body p-0">
            <div class="row">
                <div class="col-sm-4 pr-0">
                    <div class="list-group">
                        @foreach($branches as $branch)
                          <a href="{{ route('super-admin.reports.personal-usage-history', ['branch_id' => $branch->id]) }}" class="list-group-item list-group-item-action flex-column align-items-start  {{ request()->branch_id == $branch->id ? 'active' : '' }}">
                            <div class="d-flex w-100 justify-content-between">
                              <h5 class="mb-1">{{ $branch->cafe->name }}</h5>
                            </div>
                            <p class="mb-1">{{ $branch->address }}</p>
                          </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-8 pl-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>PC #</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $row)
                                <tr>
                                    <td>{{ $row->client->name }}</td>
                                    <td>{{ $row->reservation->pc->name }}</td>
                                    <td>{{ date_create($row->reservation_date)->format('m/d/Y h:i a') }}</td>
                                    <td>
                                        {{ date_create_from_format('H:i:s', $row->reservation->reservation_time)->format('h:i a') }}
                                        &mdash;
                                        {{ date_create_from_format('H:i:s', $row->reservation->reservation_time)->modify("+ {$row->reservation->duration_in_hours} hours")->format('h:i a') }}
                                    </td>
                                    <td class="text-right">{{ number_format($row->debit, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">{{ request()->branch_id ? 'No data' : 'Select a cafe' }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

@endsection
