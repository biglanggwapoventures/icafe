@extends('layouts.app')

@section('body')
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-info mb-3">
      <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.credit-history') }}">My Credit Logs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.reservation-history') }}">My Reservation Logs</a>
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
          </li>
        </ul>
      </div>
    </nav>
    <div class="row">
      <div class="col-sm-3">
        <div class="card">
          <img class="card-img-top" src="{{ Auth::user()->display_photo }}" alt="Card image">
          <div class="card-body">
            <h4 class="card-title">{{ Auth::user()->name }}</h4>
            <h6 class="card-subtitle mb-3 text-success"><strong>{{ Auth::user()->remainingCredits() }}</strong> credits remaining</h6>
            <ul class="list-unstyled">
              <li class="text-truncate"><i class="fa fa-phone-square fa-fw"></i> {{ Auth::user()->contact_number ?: 'n/a'  }}</li>
              <li class="text-truncate"><i class="fa fa-home fa-fw"></i> {{ Auth::user()->address ?: 'n/a'  }}</li>
              <li class="text-truncate"><i class="fa fa-envelope fa-fw"></i> {{ Auth::user()->email ?: 'n/a'  }}</li>
            </ul>
            <dl>
              <dt>Member since</dt>
              <dd>{{ date_create(Auth::user()->created_at)->format('F d, Y h:i A') }}</dd>
            </dl>
            <a data-toggle="modal" data-target="#profile-modal" href="#" class="btn btn-outline-primary btn-sm btn-block"><i class="fa fa-pencil"></i> Edit Profile</a>
          </div>
        </div>
      </div>
      <div class="col-sm-9">
        @yield('content')
      </div>
    </div>

</div>
@endsection
