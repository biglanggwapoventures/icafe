@extends('user.layout')

@section('content')
{!! Form::open(['url' => url()->current(), 'method' => 'GET']) !!}
<div class="form-row">
    <div class="col-10">
        <div class="form-group">
            {!! Form::text('q', request()->q, ['class' => 'form-control-lg', 'placeholder' => 'Search for an internet cafe...']) !!}
        </div>
    </div>
    <div class="col-2">
        <button type="submit" class="btn btn-lg btn-success btn-block"><i class="fa fa-search"></i> Go</button>
    </div>
</div>
{!! Form::close() !!}
<ul class="list-group">
    @forelse($cafeBranches as $branch)
        <li class="list-group-item list-group-item-action flex-column align-items-start" style="border-left:5px solid">
            <div class="row align-items-center">
                <div class="col-sm-9">
                    <h4 class="mb-2 text-primary">{{ data_get($branch, 'cafe.name') }}</h4>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-map-marker fa-fw"></i> {{ $branch->address }}</li>
                        <li><i class="fa fa-phone-square fa-fw"></i> {{ $branch->contact_number }}</li>
                    </ul>
                </div>
                <div class="col-sm-3 h-100">
                    <a href="{{ route('user.cafe.view', ['cafeBranchId' => $branch->id]) }}"  class="btn-block btn-outline-primary btn"><i class="fa fa-chevron-right"></i> Visit</a>
                </div>
            </div>
        </li>
    @empty
        No data to show
    @endforelse
</ul>
@endsection
