<div>
    <a href="{{ URL::to('cities/' . $city->id) }}">Back to {{ $city->name }} {{ $city->country }}</a>
</div>
<h1>Best {{ $category->name }} in {{ $city->name }} {{ $city->country }}</h1>

<ul>
    @foreach ($ranks as $rank)
        <li>
            {{ $rank->rank }}

            <!-- Place -->
            <div>
                <h2>
                    <img src="{{ $rank->place->image_url }}" alt="Best food at {{ $rank->place->name }} in {{ $city->name }} {{ $city->country }}"/>

                    <a target="_blank" href="{{ $rank->place->external_url }}">{{ $rank->place->name }}</a>
                </h2>

                <!-- address -->
                <div>
                    {{ $rank->place->address }}
                </div>
                <!-- /address -->

                {{ $rank->place->description }}

                <!-- Ranks -->
                <ul>
                    @foreach($rank->place->ranks as $placeRank)
                        <li>
                            {{ $placeRank->rank }} {{ $placeRank->category->name }}
                        </li>
                    @endforeach
                </ul>
                <!-- /Ranks -->
            </div>
            <!-- /Place -->

        </li>
    @endforeach
</ul>
