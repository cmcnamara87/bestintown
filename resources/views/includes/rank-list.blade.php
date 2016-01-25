<ul class="list-unstyled" style="background-color: #eee;padding: 20px;margin: -10px -15px">
    @foreach ($ranks as $rank)
        <li class="rank-list-item"
            style="background-color:white;margin-bottom:20px;padding:20px;@if(isset($place) && $rank->place->id == $place->id)
            border-left: 10px solid rgba(255, 219, 0, 1)
                @else
                border-left: 10px solid #bbb;
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