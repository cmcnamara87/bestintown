<a href="{{ URL::to('cities/' . $city->id . '/categories/' . $rank->category->id . '/places/' . $place->id ) }}"
   class="category-rank">#{{ $rank->rank }} {{ $rank->category->name }}
</a>