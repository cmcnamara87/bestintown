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
                @include('includes.category-list', ['city' => $city, 'categories' => $categories])
            </div>
            <div class="col-sm-4" style="border-right: 1px solid #eee;">
                @include('includes.rank-list')
            </div>
            <div class="col-sm-6" style="position:relative;">
                @include('includes.place-full', ['place' => $place])
            </div>
        </div>
    </div>

@stop
