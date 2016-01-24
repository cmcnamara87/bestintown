<!-- Place -->
<div>
    <h2>
        <a
                href="{{ URL::to('cities/' . $city->id . '/categories/' . $category->id . '/places/' . $place->id ) }}">
            {{ $place->name }}
        </a>
    </h2>

    <!-- Ranks -->
    <ul class="list-inline">
        @foreach($place->ranks as $placeRank)
            <li>
                @include('includes.category-rank', ["rank" => $placeRank, "place" => $place])
            </li>
        @endforeach
    </ul>
    <!-- /Ranks -->


    <!-- address -->
    <div>
        {{ $place->address }}
    </div>
    <!-- /address -->

    {{ $place->description }}
</div>
<!-- /Place -->