@extends('layouts.default')
@section('title', "Best Places in {$city->name}")
@section('content')

    <div class="jumbotron">
        <h1 class="text-center">Best Places
            in {{ $city->name }}</h1>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-2">
                @include('includes.category-list', ['city' => $city, 'categories' => $categories, 'category' => $category])
            </div>
            <div class="col-sm-4">
                <p class="text-muted">
                    <i class="fa fa-arrow-right"></i> Select a Category
                </p>
            </div>
        </div>
    </div>

@stop
