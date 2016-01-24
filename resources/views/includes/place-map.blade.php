<!-- Map -->
<div id="map"></div>
<!-- /Map -->

<script>
    var map;
    function initMap() {

        var bounds = new google.maps.LatLngBounds();
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13
        });

        @foreach($ranks as $rank)
        var place{{ $rank->rank }} = new google.maps.LatLng({{ $rank->place->latitude }}, {{ $rank->place->longitude }});

        var marker = new google.maps.Marker({
            position: place{{ $rank->rank }},
            map: map,
            title: '{{ $rank->place->name }}'
        });
        bounds.extend(place{{ $rank->rank }});
        @if(!isset($place))
        map.fitBounds(bounds);
        @endif

        @if(isset($place) && $rank->place->id == $place->id)
        marker.setIcon('http://maps.google.com/intl/en_us/mapfiles/ms/micons/purple.png');
        @endif
        @endforeach

        @if(isset($place))
        var myLatLng = {lat: {{ $place->latitude }}, lng: {{ $place->longitude }} };
        map.setCenter(myLatLng);
        map.setZoom(13);
        @endif;
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GEO_API_KEY') }}&signed_in=true&callback=initMap"
        async
        defer>
</script>
