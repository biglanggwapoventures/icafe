@extends('super-admin.layout')

@section('content')
<div class="card mt-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title mb-0">
                    <span class="text-primary">{{ $cafe->name }}</span> Admins
                </h4>
            </div>
            <div class="col text-right">
                <a data-target="#admin-modal" data-toggle="modal" href="#" class="btn btn-primary" data-action="create">New admin</a>
            </div>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Action(s)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cafe->admins as $row)
                <tr>

                </tr>
            @empty
            @endif
        </tbody>
    </table>
</div>
@endsection

@push('modals')
<div class="modal fade" id="admin-modal" tabindex="-1" role="dialog" aria-labelledby="admin-modal-label" aria-hidden="true">
      <div class="modal-dialog role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="admin-modal-label"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {!! Form::open(['data-store' => route('super-admin.cafe.admins.store', ['cafe' => $cafe]), 'data-update-url' => route('super-admin.cafe.admins.update', ['id' => 'idx', 'cafe' => $cafe]), 'class' => 'ajax', 'role' => 'form']) !!}
          <div class="modal-body">
            {!! Form::inputGroup('text', 'Name', 'name') !!}
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::inputGroup('email', 'Email', 'email') !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::inputGroup('text', 'Contact Number', 'contact_number', null, ['placeholder' => 'ex: 09199128517']) !!}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::passwordGroup('Password', 'password') !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::passwordGroup('Password, Again', 'password_confirmation') !!}
                </div>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          {!! Form::close() !!}
        </div>

      </div>
    </div>

@endpush


@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#admin-modal').on('show.bs.modal', function (e) {
            var $this = $(this),
                btn = $(e.relatedTarget);

            if(btn.data('action')){
                $this.find('.modal-title').text('Create new admin')
                $this.find('form').attr('action', function () {
                    return $(this).data('store-url');
                });
            }

        })
    });
</script>
@endpush
