@extends('layouts.app')

@section('body')
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
      <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('super-admin.cafe.index') }}">Cafes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('super-admin.cafe-admin.index') }}">Cafe Admins</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Reports
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('super-admin.reports.top-cafes') }}">Top Cafes</a>
              <a class="dropdown-item" href="{{ route('super-admin.reports.credit-points-list') }}">Credit Points List</a>
              <a class="dropdown-item" href="{{ route('super-admin.reports.personal-usage-history') }}">Personal Usage History</a>
              <a class="dropdown-item" href="{{ route('super-admin.reports.users-list') }}">List of Users</a>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-user"></i> Superadmin
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item logout" href="#" class=""><i class="fa fa-sign-out fa-fw"></i> Log out</a>
              {!! Form::open(['url' => url('logout'), 'method' => 'POST', 'id' => 'logout-form']) !!}
              {!! Form::close() !!}
          </li>
        </ul>
      </div>
    </nav>
    @yield('content')
</div>
@endsection
