<ul class="list-unstyled">
    @foreach ($ranks as $rank)
        <li style="padding:20px;@if(isset($place) && $rank->place->id == $place->id)
            background-color: #eee
                @endif
                ">

            <div class="media">
                <div class="pull-left" style="font-size:50px;">
                    {{ $rank->rank }}
                </div>
                <div class="media-body">
                    @include('includes.place-summary', ['place' => $rank->place])
                </div>
            </div>


        </li>
    @endforeach
</ul>