@extends('admin.layout')
@push('css')
<style type="text/css">
    table.layout{
        table-layout: fixed;
    }

    .table.layout td:hover{
        background: #eee;
        color:white;
    }

    .table.layout td{
        text-align: center;
        vertical-align: middle!important;
        height:50px;
        padding: 0;
    }

</style>
@endpush

@section('content')
<table class="table layout table-bordered" data-post-url="{{ route('admin.floor-layout.create') }}">
    <tbody>
        @foreach(range(1,20) AS $row)
            <tr data-y="{{ $row }}">
                @foreach(range(1,20) AS $column)
                    @php $pc = optional($coordinates->get($row))->get($column) @endphp
                    <td data-status="{{ optional($pc)->status }}" data-number="{{ optional($pc)->name }}" data-x="{{ $column }}" data-pk="{{ optional($pc)->id }}" class="{{ optional($pc)->status === 'unavailable' ? 'text-danger' : 'text-success' }}">
                        @if($pc)
                            <span class="d-block">{{ $pc->name }}</span>
                            <i class="fa fa-desktop"></i>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@push('modals')
<div class="modal fade" id="pc-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    {!! Form::open(['url' => route('admin.floor-layout.update'), 'method' => 'patch', 'class' => 'ajax']) !!}
      <div class="modal-body">
            {!! Form::inputGroup('text', 'PC #', 'name', null, ['id' => 'pc']) !!}
            {!! Form::selectGroup('Select pc status', 'status', ['' => '* SELECT *', 'available' => 'Available', 'unavailable' => 'Unavailable', 'removed' => 'Removed'], null) !!}
            {!! Form::hidden('id', null) !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    {!! Form::close() !!}
    </div>
  </div>
</div>
@endpush


@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.layout tbody td').click(function (e) {
            var $this = $(this);
            if($.trim($this.html())){
                showModal($this);
            }else{
                var num = assignNumber($this);
                if(num !== false){
                    savePosition($this);
                }
            }
        })

        function assignNumber(td) {
            var num = prompt('Input pc number');
            if(!num){
                td.removeAttr('data-number');
                return false;
            }
            if($('td[data-number='+num+']').length){
                alert('Number already in use');
                return assignNumber(td);
            }else{
                td.attr('data-number', num);
                return num;
            }
        }

        function savePosition(td) {
            var url = $('.layout').data('post-url'),
                request = $.post(url, {
                    x: td.data('x'),
                    y: td.closest('tr').data('y'),
                    name: td.data('number')
                });

            request.done(function (res) {
                window.location.reload();
            })

        }

        function showModal (td) {
            var $this = $('#pc-modal'),
                name = td.find('span.d-block').text()
            $this.find('.modal-title').html(function () {
                return 'PC # <span class="text-success">' + name + '</span> status';
            });
            $this.find('input[name=id]').val(td.data('pk'))
            $this.modal('show')
            $('input#pc').val(name)
            $('select[name=status]').val(td.data('status'))
        }
    });
</script>
@endpush
