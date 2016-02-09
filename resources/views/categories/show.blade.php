@extends('layouts.default')
@section('title', "Best {$category->name} in {$city->name}")
@section('content')

    <div class="jumbotron">
        <h1 class="text-center">Best {{ $category->name }}
            in {{ $city->name }}</h1>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-2">
                @include('includes.category-list', ['city' => $city, 'categories' => $categories, 'category' => $category])
            </div>
            <div class="col-sm-4">
                @include('includes.rank-list')
            </div>
            <div class="col-sm-6">
                @include('includes.place-map', ['ranks' => $ranks])
            </div>
        </div>
    </div>

@stop
