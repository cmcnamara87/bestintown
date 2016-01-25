<!-- Place -->
<div>
    <!-- Stars -->
    <div style="margin-right: 20px;" class="pull-right">
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
    <h4 style="margin:0;margin-bottom: 10px;">
        <a
                href="{{ URL::to('cities/' . $city->id . '/categories/' . $category->id . '/places/' . $place->id ) }}">
            {{ $place->name }}
        </a>
    </h4>


    <!-- /Stars -->

    <!-- address -->
    <div class="text-capitalize text-muted" style="margin-bottom: 10px;">
        <small>{{ $place->address }}</small>
    </div>
    <!-- /address -->

    <div class="media" style="margin-bottom: 10px;">
        {{--<div class="pull-left">--}}
            {{--<div style="width:40px;height:40px;background-color:#ddd;border-radius:40px;text-align:center;line-height:40px;" class="text-muted">--}}
                {{--<i class="fa fa-user"></i>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="media-body">
            {{--<h5>John Smith</h5>--}}
            {{  str_limit($place->description, 90, '...')  }}
        </div>
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