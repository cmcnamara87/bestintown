<!-- Place -->
<div>
    <h2>
        <a
                href="{{ URL::to('cities/' . $city->id . '/categories/' . $category->id . '/places/' . $place->id ) }}">
            {{ $place->name }}
        </a>
    </h2>

    <!-- Stars -->
    <div>
        @for($i = 0; $i < floor($place->rating); $i++)
            <i class="fa fa fa-star"></i>
        @endfor
        @if($place->rating * 2 % 2 == 1)
                <i class="fa fa fa-star-half-o"></i>
        @endif
        @for($i = 0; $i < 5 - ceil($place->rating); $i++)
            <i class="fa fa fa-star-o"></i>
        @endfor
    </div>
    <!-- /Stars -->

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