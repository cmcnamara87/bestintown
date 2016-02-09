@extends('layouts.default')
@section('title', "Best Places in {$city->name}")
@section('content')

    <div class="jumbotron">
        <h1 class="text-center">Best Places
            in {{ $city->name }}</h1>
    </div>

    <div class="container">

        <p class="lead" style="margin:30px 0;font-weight: normal;">
            Find Top Ten lists for {{ $city->name }} in any of our categories, from Pizza to Accountants, its all here. Select a category below to get started.
        </p>



        <!-- Other categories -->
        <?php $count = 0; ?>
        <div class="row">
            <div class="col-sm-4">
                @foreach ($categoriesByLetter as $letter => $categories)
                    <?php $count += 1; ?>
                    @if ($count % (count($categoriesByLetter) / 3) == 0)
                        </div><div class="col-sm-4">
                    @endif
                    <h4>{{ $letter }}</h4>
                    <ul class="list-unstyled" style="margin-bottom:30px;">
                    @foreach($categories as $category)
                    <li class="categories-list-item">
                        <a href="{{ url("{$city->slug}/{$category->slug}") }}">
                            {{ $category->name }}
                            <span class="badge">{{ $category->ranks->where('city_id', $city->id)->count() }}</span>
                        </a>
                    </li>
                    @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </div>

@stop
