<!-- Place -->
<div>
    <h2>
        <a target="_blank"
           href="{{ $place->external_url  }}">
            {{ $place->name }}
        </a>
    </h2>

    <!-- address -->
    <div>
        {{ $place->address }}
    </div>
    <!-- /address -->

    {{ $place->description }}

    <!-- Ranks -->
    <ul>
        @foreach($place->ranks as $placeRank)
            <li>
                            <span class="label label-info" style="font-size: 14px;">
                            #{{ $placeRank->rank }} {{ $placeRank->category->name }}
                            </span>

            </li>
        @endforeach
    </ul>
    <!-- /Ranks -->
    @include('includes.place-map', ['place' => $place, 'ranks' => $ranks])
</div>
<!-- /Place -->