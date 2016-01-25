<h4 class="text-muted text-uppercase" style="font-size: 12px;padding-right: 10px;"
        >Best Restaurants in {{ $city->name }} </h4>
<ul class="list-unstyled categories-list">

    <!-- Selected category at the top -->
    <li class="categories-list-item active">
        <a href="{{ URL::to('cities/' . $city->id . '/categories/' . $category->id) }}">
            <span class="badge pull-right">{{ $category->ranks->where('city_id', $city->id)->count() }}</span>
            {{ $category->name }}
        </a>
    </li>
    <!-- /Selected category at the top -->

    <!-- Other categories -->
    @foreach ($categories as $leftCategory)
        @if($leftCategory->id != $category->id)
        <li class="categories-list-item" style="">
            <a href="{{ URL::to('cities/' . $city->id . '/categories/' . $leftCategory->id) }}">
                <span class="badge pull-right ">{{ $leftCategory->ranks->where('city_id', $city->id)->count() }}</span>
                {{ $leftCategory->name }}
            </a>
        </li>
        @endif
    @endforeach
    <!-- /Other categories -->
</ul>