@extends('layouts.app')

@section('body')
<nav class="navbar navbar-expand-lg navbar-dark bg-info">
      <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.floor-layout') }}">Floor Layout</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.purchase-credits.index') }}">Purchase Credits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.reservation.index') }}">Reservations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link">Reports</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-user"></i> {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item logout" href="#" class=""><i class="fa fa-sign-out fa-fw"></i> Log out</a>
              {!! Form::open(['url' => url('logout'), 'method' => 'POST', 'id' => 'logout-form']) !!}
              {!! Form::close() !!}
            </div>
          </li>
        </ul>
      </div>
    </nav>
<div class="container-fluid">

    @yield('content')
</div>
@endsection
