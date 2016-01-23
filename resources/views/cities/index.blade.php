<ul>
    @foreach($cities as $city)
        <li><a href="{{ URL::to('cities/' . $city->id) }}">{{ $city->name }} {{ $city->country }}</a></li>
    @endforeach
</ul>