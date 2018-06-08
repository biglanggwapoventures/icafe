@extends('super-admin.layout')

@section('content')
<div class="card mt-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title mb-0">
                    Top Cafe Reports
                </h4>
            </div>
        </div>
    </div>
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Cafe</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <p class="lead mb-0">PC {{ $branches->get($row->id)->cafe->name }}</p>
                        <small class="d-block mb-0">{{ $branches->get($row->id)->address }}</small>
                    </td>
                    <td>
                        <p class="lead mb-0 text-right">
                            {{ number_format($row->total_sales, 2) }}
                        </p>
                    </td>
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
