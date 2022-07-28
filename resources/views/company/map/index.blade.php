@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/map.css') }}" type="text/css" />
@endpush
@section('content')
<style>
    body{ overflow: hidden; }
    .main-panel > .content {
        min-height: calc(100vh - 40px);
    }
</style>
<div id="map" class="m-0" style="position: absolute; overflow: hidden; top: 0; left: 3px; height: 100%; z-index: 1050;"></div>

                <div class="card vehicles">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">@lang('geolocation.vehicles')</h4>
                    </div>
                    <div class="card-body position-relative" style="overflow-y: auto;">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button id="poiSearch" class="btn btn-success" style="width: 100%;"><i class="material-icons">search</i>  @lang('form.search') Poi</button>
                                        <div class="togglebutton">
                                            <label>
                                            <input type="checkbox" id="update">
                                            <span class="toggle"></span>
                                            Aggiornamento automatico
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                            <input type="checkbox" id="active">
                                            <span class="toggle"></span>
                                            @lang('fleet.vehicles') @lang('geolocation.nolocator')
                                            </label>
                                        </div>
                                    </div>
                                </div><br>
                            </div>
                            <div class="col-md-12">
                                @foreach ($positions as $position)
                                    <div onclick="zoom({{ $position->vehicle->id }})" class="row border pb-2 pt-2" style="cursor: pointer;">
                                        <div class="col-md-2 mt-2">
                                            <img id="icon_{{ $position->vehicle->id }}" src="{{ asset('img/events/'.$position->event->icon) }}" title="{{ $position->event->name }}" width="100%" />
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                <span class="mr-4"><b style="color: green;">{{ $position->name }}</b></span>
                                            </div>
                                            <div class="row">
                                                <span class="mr-4" id="{{ $position->id }}">@lang('geolocation.last_position'): {{ $position->date->setTimezone('Europe/Rome')->format('d/m/Y H:i:s') }} </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
@endsection

@push('scripts')


<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.key') }}&libraries=&v=weekly"></script>
<script src="https://unpkg.com/@googlemaps/markerclustererplus/dist/index.min.js"></script>


<script>
    let map;
    let infowindows = [];
    let vehicleMarkers = [];
    let automatic = true;
    let open_marker = null;

    function closeInfowindows() {
        infowindows.forEach(element => {
            element.close();
        });
        open_marker = null;
    }

    

    

    function zoom(id){
        closeInfowindows();
        let marker = vehicleMarkers[id];
        if(marker) {
            map.setCenter(marker.position);
            map.setZoom(17);
            openInfowindow(id);
        }
    }

    function loadPoi(){
        $.ajax({
            url: "{{ route('company.map.pois') }}",
            type: 'GET',
            success: function(result) {
                const markers = result.map((poi, i) => {
                    var myLatLng = { lat: parseFloat(poi.latitude), lng: parseFloat(poi.longitude) };
                    return new google.maps.Marker({
                        position: myLatLng,
                        title: poi.name,
                    });
                });
                const markerCluster = new MarkerClusterer(map, markers, {
                    imagePath:
                    "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
                });
            },
            error: function () {
                $.notify({title: "Ops!", message: "Si è verificato un errore imprevisto."}, {type: "danger"});
            }
        });
    }

    
    

    $(document).ready(function () {
       

        //Map load
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 41.902782, lng: 12.496366 },
            zoom: 7,
            gestureHandling: 'greedy',
            streetViewControl: false,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_BOTTOM,
            },
        });

        //Close all infowindows when click on map
        google.maps.event.addListener(map, "click", function (event) {
            closeInfowindows();
        });

        //Load Point of Interests
        loadPoi();

        //Load Geofences
       // loadFences();

        //Lad Vehicles on Map
       // loadVehicles();

        
        //Automatic refresh of the map (30sec)
        setInterval(function(){
            if(automatic)
                updateMap();
        }, 30000)
    });

    $(document).on('click', '#poiSearch', function(e) {

        $.ajax({
            url: "{{ route('company.map.pois') }}",
            type: 'GET',
            success: function(result) {
                    var html = "<div class='form-group bmd-form-group'><select type='select' required id='poi' data-live-search='true' title='@lang('form.select') poi' data-style='select-with-transition' data-width='100%'>";

                    result.forEach(poi => {
                        html += "<option value='"+poi.latitude+","+poi.longitude+"'>"+poi.name+"</option>";
                    });

                    html += "</select></div>";


                    Swal.fire({
                        title: 'Ricerca POI',
                        html: html,
                        showCancelButton: true,
                        cancelButtonColor: 'red',
                        cancelButtonText: 'Annulla',
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerca',
                        onBeforeOpen(){
                            $('#poi').selectpicker('render');
                        },
                    }).then((result) => {
                        if (result.value == true) {
                            var poi = $('#poi').val();
                            if(poi != ""){
                                var coordinates = poi.split(",");
                                var myLatLng = { lat: parseFloat(coordinates[0]), lng: parseFloat(coordinates[1]) };
                                map.setCenter(myLatLng);
                                map.setZoom(17);
                            }
                            else{
                                Swal.fire(
                                    'Errore!',
                                    'Devi selezionare un Poi dalla lista!',
                                    'error'
                                )
                            }
                        }
                    });
            },
            error: function () {
                $.notify({title: "Ops!", message: "Si è verificato un errore imprevisto."}, {type: "danger"});
            }
        });
    });

</script>

@endpush
