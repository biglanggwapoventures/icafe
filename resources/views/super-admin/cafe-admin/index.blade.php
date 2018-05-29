@extends('super-admin.layout')

@section('content')
<div class="card mt-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title mb-0">
                    Cafe Admins
                </h4>
            </div>
            <div class="col text-right">
                <a href="{{ MyHelper::resource('create') }}" class="btn btn-primary">New entry</a>
            </div>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Cafe</th>
                <th>Branch</th>
                <th>Admin</th>
                <th>Contact Number</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($resourceList as $row)
                <tr>
                    <td>{{ data_get($row, 'cafeBranch.cafe.name') }}</td>
                    <td>{{ data_get($row, 'cafeBranch.address') }}</td>
                    <td>{{ data_get($row, 'user.name') }}</td>
                    <td>{{ data_get($row, 'user.contact_number') }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('super-admin.cafe-admin.edit', $row->id) }}"><i class="fa fa-pencil"></i> Edit</a>
                    </td>
                </tr>
            @empty
            @endif
        </tbody>
    </table>
</div>
@endsection
