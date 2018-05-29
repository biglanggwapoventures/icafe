@extends('super-admin.layout')

@push('css')
<style type="text/css">
    table .form-group{
        margin-bottom:0px;
    }
</style>
@endpush
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
                        Cafes
                    </h4>
                </div>
                <div class="col text-right">
                    <a href="{{ MyHelper::resource('index') }}" class="btn btn-primary">Back to list</a>
                </div>
            </div>
        </div>
        <div class="card-body border-top">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::inputGroup('text', 'Cafe Name', 'parent[name]', $resourceData->name) !!}
                    </div>
                </div>


        </div>
        <table class="table mb-0 dynamic-table">
            <thead>
                <tr>
                    <th>Branches</th>
                    <th>Contact Number</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($resourceData->branches as $item)
                <tr>
                    <td>
                        {!! Form::inputGroup('text', null, "child[{$loop->index}][address]", $item->address, ['data-name' => 'child[idx][address]', 'class' => 'location']) !!}
                        {!! Form::hidden("child[{$loop->index}][latitude]", $item->latitude, ['data-name' => 'child[idx][latitude]', 'class' => 'keep latitude']) !!}
                        {!! Form::hidden("child[{$loop->index}][longitude]", $item->longitude, ['data-name' => 'child[idx][longitude]', 'class' => 'keep longitude']) !!}
                        {!! Form::hidden("child[{$loop->index}][id]", $item->id) !!}
                    </td>
                    <td>
                        {!! Form::inputGroup('text', null, "child[{$loop->index}][contact_number]", $item->contact_number, ['data-name' => 'child[idx][contact_number]']) !!}
                    </td>
                    <td>
                        <a href="#" class="btn btn btn-danger remove-line"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td>
                        {!! Form::inputGroup('text', null, 'child[0][address]', null, ['data-name' => 'child[idx][address]', 'class' => 'location']) !!}
                        {!! Form::hidden("child[0][latitude]", null, ['data-name' => 'child[idx][latitude]', 'class' => 'keep latitude']) !!}
                        {!! Form::hidden("child[0][longitude]", null, ['data-name' => 'child[idx][longitude]', 'class' => 'keep longitude']) !!}
                    </td>
                    <td>
                        {!! Form::inputGroup('text', null, 'child[0][contact_number]', null, ['data-name' => 'child[idx][contact_number]']) !!}
                    </td>
                    <td>
                        <a href="#" class="btn btn btn-danger remove-line"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><a href="#" class="btn btn-primary add-line"><i class="fa fa-plus"></i> New branch</a></td>
                </tr>
            </tfoot>
        </table>
        <div class="card-body p-0" style="height:300px" id="map">

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection

@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApzL1AXKwyfJT2tT5c5KkxFqnfv2txpQw&libraries=places&callback=initMap&region=PH" async defer></script>
<script type="text/javascript">
    var map;
    $(document).ready(function() {

        var counter = $('.dynamic-table tbody tr').length;

        $('.add-line').click(function () {
            var $tbody = $(this).closest('table').find('tbody'),
                clone = $tbody.find('tr:first').clone();

            clearRow(clone);
            clone.find('input').attr('name', function () {
                return $(this).data('name').replace('idx', counter)
            });

            clone.appendTo($tbody)
            initialize($('.location').last().get(0))

            counter++;

        })

        $('.dynamic-table').on('click', '.remove-line', function () {
            var $tr = $(this).closest('table').find('tbody tr');
            if($tr.length === 1){
                clearRow($tr)
            }else{
                $(this).closest('tr').remove()
            }
        });

        function clearRow(row) {
            row.find('[type=hidden]:not(.keep)').remove();
            row.find('input').val('')
        }
    });
    function initialize(input) {
        var autocomplete = new google.maps.places.Autocomplete(input,{ types: ['geocode', 'establishment'] }),
            marker = null;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace(),
                row = $(input).closest('tr');
            row.find('.latitude').val(place.geometry.location.lat())
            row.find('.longitude').val(place.geometry.location.lng())
            if(marker !== null){
                marker.setMap(null)
            }
            marker = drawPinFrom(row)
        });
    }
    function initMap() {
        var cebuCity = {lat: 10.31672, lng: 123.89071};
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: cebuCity
        });
        $('.location').each(function (i, v) {
            initialize(v)
            drawPinFrom($(v).closest('tr'))
        })
        // drawPins();
    }

    function drawPinFrom(el) {
        var lat = parseFloat(el.find('.latitude').val() || 0),
            lng = parseFloat(el.find('.longitude').val() || 0);
        if(lat && lng){
           return new google.maps.Marker({
                position: {
                    lat: lat,
                    lng: lng
                },
                map: map
            });
        }
    }
</script>
@endpush
