@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card ">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">add</i>
                </div>
                <h4 class="card-title">@lang('form.add') Poi</h4>
            </div>
            <div class="card-body ">
                <form action="{{ route('company.poi.store') }}" method="POST">
                    @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-static">@lang('fleet.name')*</label>
                                    <input type="text" required class="form-control" name="name" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-static">@lang('fleet.description')</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-static">@lang('geolocation.latitude')</label>
                                    <input type="text" required class="form-control" name="latitude" id="lat" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-static">@lang('geolocation.longitude')</label>
                                    <input type="text" required class="form-control" name="longitude" id="lng" readonly>
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
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <input type="text" required class="form-control" name="address" id="address" placeholder="Digita un indirizzo...">
                            </div>
                        </div>
                        <div id="map" class="m-0" style="height:70vh;"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.key') }}&callback=initAutocomplete&libraries=places&v=weekly" async defer></script>


<script>
    let map;
    let markers = [];

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 41.902, lng: 12.496 },
            zoom: 6,
        });
    }

    let autocomplete;


    function initAutocomplete(){
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('address'),
            {
                types: ['geocode'],
                componentRestrictions: {'country': ['IT','DE','FR','UK']},
            }
        );
        autocomplete.addListener('place_changed', onPlaceChanged);
        initMap()
    }

    function setMapOnAll(map) {
        for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }


    function onPlaceChanged(){
        var place = autocomplete.getPlace();

        if(!place.geometry){
            document.getElementById('address').placeholder = 'Digita un indirizzo...';
        }
        else{
            $('#lat').val(place.geometry.location.lat());
            $('#lng').val(place.geometry.location.lng());
            var myLatLng = { lat: place.geometry.location.lat(), lng: place.geometry.location.lng() };
            setMapOnAll(null);
            markers = [];
            const marker = new google.maps.Marker({
                position: myLatLng,
                map,
                title: "POI",

            });
            markers.push(marker);
            map.setCenter(myLatLng);
            map.setZoom(12);
            map.panTo(currentmarker.position);
        }
    }

</script>

@endpush
