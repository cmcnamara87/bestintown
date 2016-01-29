@extends('layouts.default')
@section('title', "The Best Places in your City")
@section('content')

    <div class="jumbotron">
        <h1 class="text-center">The Best Places in Your City</h1>
    </div>

    <div class="container-fluid">
        @foreach($cities as $city)
            <li><a href="{{ url($city->slug) }}">{{ $city->name }} {{ $city->country }}</a></li>
        @endforeach
    </div>

@stop

