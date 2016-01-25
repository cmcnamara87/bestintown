<ul class="list-unstyled rank-list">
    @foreach ($ranks as $rank)
        <li class="rank-list-item">
            <div class="rank-list-item__rank @if(isset($place) && $rank->place->id == $place->id) active @endif">
                #{{ $rank->rank }}
            </div>
            <div class="rank-list-item__place">
                @include('includes.place-summary', ['place' => $rank->place])
            </div>
        </li>
    @endforeach
</ul>