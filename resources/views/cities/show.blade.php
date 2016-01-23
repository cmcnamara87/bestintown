<div>
    <a href="{{ URL::to('cities') }}">Change Cities</a>
</div>
    
<div>
    <h1>Best Food in {{ $city->name }} {{ $city->country }}</h1>
    <ul>
        @foreach($categories as $category)
            <li><a href="{{ URL::to('cities/' . $city->id . '/categories/' . $category->id) }}">{{ $category->name }}</a></li>
        @endforeach
    </ul>
</div>
