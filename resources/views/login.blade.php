@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('body')
<div class="container pt-5">
    <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Login</h4>
                    {!! Form::open(['url' => url('login'), 'method' => 'post', 'class' => 'ajax']) !!}
                        {!! Form::inputGroup('email', 'Email Address', 'email') !!}
                        {!! Form::passwordGroup('Password', 'password') !!}
                        <button type="submit" class="btn btn-outline-success btn-block">Submit</button>
                        <hr>
                        <a href="{{ route('login.facebook') }}" class="btn btn-primary btn-block">Login using Facebook</a>
                        <a href="{{ route('login.google') }}" class="btn btn-danger btn-block">Login using Google</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
