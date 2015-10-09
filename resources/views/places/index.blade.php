<div>
    <a href="/categories">Back to categories</a>
</div>
<h1>Nearby</h1>

<ul>
    @foreach ($places as $place)
        <li>
            <h2>{{ $place->name }} {{ $place->distance }} KM</h2>
            <ul>
                @foreach ($place->ranks as $rank)
                    <li>
                        <a href="/categories/{{ $rank->category->id }}">
                            <strong>{{ $rank->category->name }} #{{ $rank->rank }}</strong>
                        </a>
                    </li>
                @endforeach
            </ul>
            <p></p>


            <p>
                {{ $place->rating }}/5
            </p>
            <p><a target="_blank" href="http://google.com/maps?q={{ $place->address }}">{{ $place->address }}</a></p>
        </li>
    @endforeach
</ul>
