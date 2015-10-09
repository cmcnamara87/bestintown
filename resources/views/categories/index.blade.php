<h1>Categories</h1>

<div>
    <a href="/nearby">Nearby</a>
</div>
<ul>
    @foreach ($categories as $category)
        <li>
            <a href="categories/{{ $category->id }}">
                {{ $category->name }}
            </a>
        </li>
    @endforeach
</ul>