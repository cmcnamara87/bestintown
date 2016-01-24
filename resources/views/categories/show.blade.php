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
                @include('includes.category-list', ['city' => $city, 'categories' => $categories, 'category' => $category])
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
                                    @include('includes.place-summary', ['place' => $rank->place])
                                </div>
                            </div>




                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-6">
                @include('includes.place-map', ['ranks' => $ranks])
            </div>
        </div>
    </div>

@stop
