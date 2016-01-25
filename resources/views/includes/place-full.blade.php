<!-- Place -->
<div style="padding:20px;">
    <div style="margin-bottom: 40px;">
        {{--<h2 class="pull-left" style="margin-right: 20px;">3</h2>--}}
        @include('includes.place-summary')
    </div>

    <div style="margin-bottom: 40px;">
        <img style="width:200px;height:200px;"
             src="https://igcdn-photos-b-a.akamaihd.net/hphotos-ak-xpf1/t51.2885-15/e15/12558693_179183985772025_2119645602_n.jpg"
             alt=""/>

        <img style="width:200px;height:200px;"
             src="https://igcdn-photos-d-a.akamaihd.net/hphotos-ak-xfa1/t51.2885-15/e15/12424555_1074134705971579_73871988_n.jpg"
             alt=""/>

        <img style="width:200px;height:200px;"
             src="https://igcdn-photos-h-a.akamaihd.net/hphotos-ak-xtp1/t51.2885-15/e15/11363716_1687395061498183_510518064_n.jpg"
             alt=""/>

    </div>
    <!-- /Ranks -->
    @include('includes.place-map', ['place' => $place, 'ranks' => $ranks])
</div>
<!-- /Place -->