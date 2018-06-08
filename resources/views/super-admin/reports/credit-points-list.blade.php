@extends('super-admin.layout')

@section('content')
<div class="card mt-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title mb-0">
                    Credit Points List
                </h4>
            </div>
        </div>
    </div>

        <div class="card-body p-0">
            <div class="row">
                <div class="col-sm-4 pr-0">
                    <div class="list-group">
                        @foreach($branches as $branch)
                          <a href="{{ route('super-admin.reports.credit-points-list', ['branch_id' => $branch->id]) }}" class="list-group-item list-group-item-action flex-column align-items-start  {{ request()->branch_id == $branch->id ? 'active' : '' }}">
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
                                <th>Date</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $row)
                                <tr>
                                    <td>{{ $row->client->name }}</td>
                                    <td>{{ date_create($row->created_at)->format('m/d/Y h:ia') }}</td>
                                    <td class="text-right">{{ number_format($row->credit, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">{{ request()->branch_id ? 'No data' : 'Select a cafe' }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

@endsection
