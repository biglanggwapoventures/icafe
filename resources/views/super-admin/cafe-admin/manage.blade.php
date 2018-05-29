@extends('super-admin.layout')

@section('content')
@if($resourceData->id)
{!! Form::model($resourceData, ['url' => MyHelper::resource('update', ['id' => $resourceData->id]), 'class' => 'ajax', 'method' => 'patch']) !!}
@else
{!! Form::open(['url' => MyHelper::resource('store'), 'method' => 'post', 'class' => 'ajax', 'data-next-url' => MyHelper::resource('index')]) !!}
@endif
<div class="card mt-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title mb-0">
                    Cafe Admins
                </h4>
            </div>
            <div class="col text-right">
                <a href="{{ MyHelper::resource('index') }}" class="btn btn-primary"><i class="fa fa-chevron-left"></i> Back to list</a>
            </div>
        </div>
    </div>
    <div class="card-body border-top">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::selectGroup('Select a cafe', null, $cafes->prepend('* SELECT *', ''), optional($resourceData->cafeBranch)->cafe_id, ['class' => 'cafe']) !!}
                @if($resourceData->id)
                    {!! Form::hidden('user[id]', data_get($resourceData, 'user.id')) !!}
                @endif
            </div>
            <div class="col-sm-5">
                {!! Form::selectGroup('Branch', 'cafe_branch_id', [], null, ['class' => 'branch', 'data-default' => $resourceData->cafe_branch_id]) !!}
            </div>
        </div>
    </div>
    <div class="card-body border-top">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title mb-0">
                    User and Account Information
                </h4>
            </div>
        </div>
    </div>
    <div class="card-body border-top">
        <div class="form-row">
            <div class="col-sm-6">
                {!! Form::inputGroup('text', 'Name', 'user[name]') !!}
            </div>
            <div class="col-sm-4">
                {!! Form::inputGroup('number', 'Mobile Number', 'user[contact_number]', null, ['placeholder' => 'ie: 09XXXXXXXXX']) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-4">
                {!! Form::inputGroup('email', 'Email', 'user[email]') !!}
            </div>
            <div class="col-sm-6">
                {!! Form::inputGroup('text', 'Address', 'user[address]') !!}
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-5">
                {!! Form::passwordGroup('Password', 'user[password]') !!}
            </div>
            <div class="col-sm-5">
                {!! Form::passwordGroup('Password Confirmation', 'user[password_confirmation]') !!}
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success">Save</button>
    </div>
</div>
{!! Form::close() !!}
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        var branches = @json($branches);
        $('.cafe').change(function () {
            var $this = $(this);
            $('.branch').html(function () {
                var options = '<option>* SELECT *</option>',
                    defaultValue = $(this).data('default');
                $.each(branches[$this.val()], function (i, v) {
                    var selected = (defaultValue == i ? 'selected="selected"': '');
                    options += '<option value="'+i+'" '+selected+'>'+v+'</option>'
                });
                return options;
            });
        }).trigger('change')
    });
</script>
@endpush
