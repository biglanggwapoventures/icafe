@extends('layouts.app')

@section('body')
<a href="{{ route('login.google') }}">Login using google</a>
<a href="{{ route('login.facebook') }}">Login using facebook</a>
<img src="https://graph.facebook.com/v3.0/106661823557285/picture?type=normal" alt="">
@endsection
