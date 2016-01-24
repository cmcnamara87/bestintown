<!-- Place -->
<div>
    <h2>
        <a
                href="{{ URL::to('cities/' . $city->id . '/categories/' . $category->id . '/places/' . $place->id ) }}">
            {{ $place->name }}
        </a>
    </h2>

    <!-- Stars -->
    <div style="margin-bottom: 20px;">
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
    <ul class="list-inline" style="margin-bottom: 20px;">
        @foreach($place->ranks as $placeRank)
            <li>
                @include('includes.category-rank', ["rank" => $placeRank, "place" => $place])
            </li>
        @endforeach
    </ul>
    <!-- /Ranks -->


    <!-- address -->
    <div class="text-capitalize text-muted" style="margin-bottom: 20px;">
        <small>{{ $place->address }}</small>
    </div>
    <!-- /address -->

    <div class="media">
        <div class="pull-left">
            <div style="width:40px;height:40px;background-color:#ddd;border-radius:40px;text-align:center;line-height:40px;" class="text-muted">
                <i class="fa fa-user"></i>
            </div>
        </div>
        <div class="media-body">
            <h5>John Smith</h5>
            {{ $place->description }}
        </div>
    </div>
    
</div>
<!-- /Place -->