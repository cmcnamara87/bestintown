<ul class="list-unstyled" style="background-color: #eee;padding: 20px;margin: -10px -15px">
    @foreach ($ranks as $rank)
        <li style="background-color:white;margin-bottom:20px;padding:20px;@if(isset($place) && $rank->place->id == $place->id)
            border-top: 10px solid yellow
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