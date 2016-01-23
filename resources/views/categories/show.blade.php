@extends('layouts.default')
{{--@section('title', $cinema->location . ' - What\'s Good at the Movies - MoviesOwl')--}}
@section('content')

    <div class="jumbotron">
        <h1 class="text-center">Best {{ $category->name }}
            in {{ $city->name }} {{ $city->country }}</h1>
    </div>
    
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-2">
                <h4>{{ $city->name }}, {{ $city->country }}</h4>
                <ul>
                    @foreach ($categories as $leftCategory)
                        <li>
                            <a href="{{ URL::to('cities/' . $city->id . '/categories/' . $leftCategory->id) }}">{{ $leftCategory->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-4">
                <ul class="list-unstyled">
                    @foreach ($ranks as $rank)
                        <li>
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
            <div class="col-sm-6">
            </div>
        </div>
    </div>

@stop
