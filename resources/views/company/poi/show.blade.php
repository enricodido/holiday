@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card ">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">edit</i>
                </div>
                <h4 class="card-title">@lang('form.detail') Poi</h4>
            </div>
            <div class="card-body ">
                <form action="{{ route('company.poi.update',$poi->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-static">@lang('fleet.name')*</label>
                                    <input type="text" required class="form-control" name="name" autofocus value="{{$poi->name}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-static">@lang('fleet.description')</label>
                                    <textarea class="form-control" name="description">{{$poi->description}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-static">@lang('geolocation.latitude')</label>
                                    <input type="text" required class="form-control" id="lat" readonly value="{{$poi->latitude}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-static">@lang('geolocation.longitude')</label>
                                    <input type="text" required class="form-control" id="lng" readonly value="{{$poi->longitude}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="visible" @if ($poi->visible)
                                            checked
                                        @endif> @lang('geofence.visible')
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary">@lang('form.save')</button>
                                <a href="{{route('company.poi.index')}}" class="btn btn-default">@lang('form.back')</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">map</i>
                    </div>
                    <h4 class="card-title">@lang('geolocation.map')</h4>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div id="map" class="m-0" style="height:70vh;"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.key') }}&callback=initMap&libraries=places&v=weekly" async defer></script>


<script>
    let map;

    function addMarker(){
        var myLatLng = { lat: parseFloat($('#lat').val()), lng: parseFloat($('#lng').val()) };
        new google.maps.Marker({
            position: myLatLng,
            map,
            title: "POI",
        });
    }

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: parseFloat($('#lat').val()), lng: parseFloat($('#lng').val()) },
            zoom: 12,
        });
        addMarker();
    }

</script>

@endpush
