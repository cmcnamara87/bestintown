<h4>{{ $city->name }}, {{ $city->country }}</h4>
<ul class="list-unstyled">

    <!-- Selected category at the top -->
    <li style="background-color: #eee">
        <a href="{{ URL::to('cities/' . $city->id . '/categories/' . $category->id) }}">{{ $category->name }} Restaurants</a>
    </li>
    <!-- /Selected category at the top -->

    <!-- Other categories -->
    @foreach ($categories as $leftCategory)
        @if($leftCategory->id != $category->id)
        <li>
            <a href="{{ URL::to('cities/' . $city->id . '/categories/' . $leftCategory->id) }}">{{ $leftCategory->name }} Restaurants</a>
        </li>
        @endif
    @endforeach
    <!-- /Other categories -->
</ul>