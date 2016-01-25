<!-- Place -->
<div style="padding:20px;">
    <div style="margin-bottom: 40px;">
        {{--<h2 class="pull-left" style="margin-right: 20px;">3</h2>--}}
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
            <h2 class="rank-list-item__title" style="margin-top:0;margin-bottom:20px;color:#586475;">
                <a style="color:inherit;" href="{{ $place->external_url }}" target="_blank">
                    {{ $place->name }} <small><i class="fa fa-external-link"></i></small>
                </a>
            </h2>
            <!-- /Stars -->

            <!-- address -->
            <div class="rank-list-item__address" style="margin-bottom: 20px;">
                <small>{{ $place->address }}</small>
            </div>
            <!-- /address -->

            <div class="panel panel-default" style="margin-bottom: 20px;">
                <div class="panel-body">
                    <div class="media">
                        <div class="pull-left">
                            <div style="width:40px;height:40px;background-color:#ddd;border-radius: 100px;text-align: center;line-height:40px;">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <div class="media-body">
                            <h5 style="margin-top:0;">Anonymous User</h5>
                            {{  $place->description  }} <a href="{{ $place->external_url }}" target="_blank">read more on Yelp</a>
                        </div>
                    </div>
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
    </div>

    {{--<div style="margin-bottom: 40px;">--}}
        {{--<img style="width:200px;height:200px;"--}}
             {{--src="https://igcdn-photos-b-a.akamaihd.net/hphotos-ak-xpf1/t51.2885-15/e15/12558693_179183985772025_2119645602_n.jpg"--}}
             {{--alt=""/>--}}

        {{--<img style="width:200px;height:200px;"--}}
             {{--src="https://igcdn-photos-d-a.akamaihd.net/hphotos-ak-xfa1/t51.2885-15/e15/12424555_1074134705971579_73871988_n.jpg"--}}
             {{--alt=""/>--}}

        {{--<img style="width:200px;height:200px;"--}}
             {{--src="https://igcdn-photos-h-a.akamaihd.net/hphotos-ak-xtp1/t51.2885-15/e15/11363716_1687395061498183_510518064_n.jpg"--}}
             {{--alt=""/>--}}

    {{--</div>--}}
    <!-- /Ranks -->
    @include('includes.place-map', ['place' => $place, 'ranks' => $ranks])
</div>
<!-- /Place -->