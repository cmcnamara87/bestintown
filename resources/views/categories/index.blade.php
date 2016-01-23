<div>
    <a href="{{ URL::to('cities') }}">Change Cities</a>
</div>
<h1>Best in {{ $city->name }} {{ $city->country }}</h1>

<h2>
    Categories
</h2>
<ul>
    @foreach ($categories as $category)
        <li>
            <a href="categories/{{ $category->id }}">
                {{ $category->name }}
            </a>
        </li>
    @endforeach
</ul>