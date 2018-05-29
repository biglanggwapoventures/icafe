@extends('super-admin.layout')

@section('content')
<div class="card mt-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title mb-0">
                    Cafes
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
                <th>Name</th>
                <th>Location</th>
                <th>Action(s)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resourceList as $row)
                <tr data-admins="{{ $row->admins->toJson() }}">
                    <td class="cafe-name">{{ $row->name }}</td>
                    <td>{{ $row->location }}</td>
                    <td>
                        <a  data-toggle="modal" data-target="#admins-modal" href="#" class="btn btn-primary btn-sm">View Admins</a>
                        <a href="{{ route('super-admin.cafe.edit', $row->id) }}" class="btn btn-info btn-sm">Edit</a>
                        <a href="#" data-href="{{ route('super-admin.cafe.destroy', $row->id) }}" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            @empty
            @endif
        </tbody>
    </table>
</div>
@endsection

@push('modals')
<div class="modal fade" id="admins-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Admin</th>
                    <th>Admin Contact</th>
                    <th>Branch</th>
                    <th>Branch Contact</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endpush

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#admins-modal').on('show.bs.modal', function (e) {
            var btn = $(e.relatedTarget),
                admins = btn.closest('tr').data('admins'),
                editUrl = '{{ route('super-admin.cafe-admin.edit', ['id' => '__IDX__']) }}';
            $(this).find('.modal-title').html(function () {
                return 'Viewing admins for: <strong>' + btn.closest('td').siblings('.cafe-name').text() +'</strong>'
            })
            $(this).find('.table tbody').html(function () {
                var content = '';
                $.each(admins, function (i, v) {
                    content += '<tr><td><a target="_blank" href="'+editUrl.replace('__IDX__', v['cafe_admin_id'])+'">'+v['user']['name']+'</a></td>'
                    content += '<td>'+v['user']['contact_number']+'</td>'
                    content += '<td>'+v['cafe_branch']['address']+'</td>'
                    content += '<td>'+v['cafe_branch']['contact_number']+'</td></tr>'
                })
                return content;
            })
        })
    });
</script>
@endpush
