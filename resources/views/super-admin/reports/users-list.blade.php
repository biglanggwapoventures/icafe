@extends('super-admin.layout')

@section('content')
<div class="card mt-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title mb-0">
                    List of Users
                </h4>
            </div>
        </div>
    </div>
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date Joined</th>
                <th class="text-right">Current Credit Balance</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ date_create($row->created_at)->format('m/d/y h:i a') }}</td>
                    <td class="text-right">{{ number_format($row->remainingCredits(), 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No data to show</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
