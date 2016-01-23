@extends('layouts.default')
{{--@section('title', $cinema->location . ' - What\'s Good at the Movies - MoviesOwl')--}}
@section('content')


    <div class="jumbotron">
        <h1 class="text-center">Best {{ $category->name }}
            in {{ $city->name }} {{ $city->country }}</h1>
    </div>

    <div class="container-fluid">


        <div class="row">
            <div class="col-sm-2" style="border-right: 1px solid #eee;">
                <h4>{{ $city->name }}, {{ $city->country }}</h4>
                <ul>
                    @foreach ($categories as $leftCategory)
                        <li>
                            <a href="{{ URL::to('cities/' . $city->id . '/categories/' . $leftCategory->id) }}">{{ $leftCategory->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-4" style="border-right: 1px solid #eee;">
                <ul class="list-unstyled">
                    @foreach ($ranks as $rank)
                        <li @if($rank->place->id == $place->id)
                            style="background-color: #eee"
                            @endif
 >
                            <div class="media">
                                <div class="pull-left" style="font-size:50px;">
                                    {{ $rank->rank }}
                                </div>
                                <div class="media-body">
                                    <!-- Place -->
                                    <div>
                                        <h2>
                                            <a
                                                    href="{{ URL::to('cities/' . $city->id . '/categories/' . $category->id . '/places/' . $rank->place->id ) }}">
                                                {{ $rank->place->name }}
                                            </a>
                                        </h2>

                                        <!-- address -->
                                        <div>
                                            {{ $rank->place->address }}
                                        </div>
                                        <!-- /address -->

                                        {{ $rank->place->description }}

                                        <!-- Ranks -->
                                        <ul>
                                            @foreach($rank->place->ranks as $placeRank)
                                                <li>
                            <span class="label label-info" style="font-size: 14px;">
                            #{{ $placeRank->rank }} {{ $placeRank->category->name }}
                            </span>

                                                </li>
                                            @endforeach
                                        </ul>
                                        <!-- /Ranks -->
                                    </div>
                                    <!-- /Place -->
                                </div>
                            </div>


                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-6" style="position:relative;">
                <!-- Place -->
                <div>
                    <h2>
                        <a target="_blank"
                           href="{{ $place->external_url  }}">
                            {{ $place->name }}
                        </a>
                    </h2>

                    <!-- address -->
                    <div>
                        {{ $place->address }}
                    </div>
                    <!-- /address -->

                    {{ $place->description }}

                    <!-- Ranks -->
                    <ul>
                        @foreach($place->ranks as $placeRank)
                            <li>
                            <span class="label label-info" style="font-size: 14px;">
                            #{{ $placeRank->rank }} {{ $placeRank->category->name }}
                            </span>

                            </li>
                        @endforeach
                    </ul>
                    <!-- /Ranks -->
                    <style>
                        #map {
                            height: 400px;
                            width: 100%;
                        }
                    </style>


                    <!-- Map -->
                    <div id="map"></div>
                    <!-- /Map -->

                    <script>
                        var map;
                        function initMap() {

                            var myLatLng = {lat: {{ $place->latitude }}, lng: {{ $place->longitude }} };
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 13,
                                center: myLatLng
                            });

                            @foreach($ranks as $rank)
                            var place{{ $rank->rank }} = {lat: {{ $rank->place->latitude }}, lng: {{ $rank->place->longitude }} };

                            var marker = new google.maps.Marker({
                                position: place{{ $rank->rank }},
                                map: map,
                                title: '{{ $rank->place->name }}'
                            });
                            @if($rank->place->id == $place->id)
                            marker.setIcon('http://maps.google.com/intl/en_us/mapfiles/ms/micons/purple.png');
                            @endif
                            @endforeach
                        }
//                    </script>
                    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GEO_API_KEY') }}&signed_in=true&callback=initMap"
                            async
                            defer>
                    </script>

                </div>
                <!-- /Place -->

            </div>
        </div>
    </div>

@stop
