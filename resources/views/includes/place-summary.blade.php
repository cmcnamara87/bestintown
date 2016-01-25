<!-- Place -->
<div>
    <!-- Stars -->
    <div class="stars pull-right">
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
    <h4 class="rank-list-item__title">
        <a href="{{ URL::to('cities/' . $city->id . '/categories/' . $category->id . '/places/' . $place->id ) }}">
            {{ $place->name }}
        </a>
    </h4>


    <!-- /Stars -->

    <!-- address -->
    <div class="rank-list-item__address">
        <small>{{ $place->address }}</small>
    </div>
    <!-- /address -->

    <div style="margin-bottom: 10px;">
        {{  str_limit($place->description, 90, '...')  }}
    </div>

    <!-- Ranks -->
    <ul class="list-inline">
        @foreach($place->ranks as $placeRank)
            <li>
                @include('includes.category-rank', ["rank" => $placeRank, "place" => $place])
            </li>
        @endforeach
    </ul>
    <!-- /Ranks -->

</div>
<!-- /Place -->