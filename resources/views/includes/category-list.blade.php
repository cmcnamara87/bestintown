<h4 class="text-muted text-uppercase">
    <small>Best Restaurants in {{ $city->name }}</small>
</h4>
<ul class="list-unstyled categories-list">

    <!-- Selected category at the top -->
    @if (isset($category))
    <li class="categories-list-item active">
        <a href="{{ url("{$city->slug}/{$category->slug}") }}">
            <span class="badge pull-right">{{ $category->ranks->count() }}</span>
            {{ $category->name }}
        </a>
    </li>
    @endif (isset($category))
    <!-- /Selected category at the top -->

    <!-- Other categories -->
    @foreach ($categories as $leftCategory)
        @if(!isset($category) || $leftCategory->id != $category->id)
        <li class="categories-list-item" style="">
            <a href="{{ url("{$city->slug}/{$leftCategory->slug}") }}">
                <span class="badge pull-right ">{{ $leftCategory->ranks->count() }}</span>
                {{ $leftCategory->name }}
            </a>
        </li>
        @endif
    @endforeach
    <!-- /Other categories -->
</ul>