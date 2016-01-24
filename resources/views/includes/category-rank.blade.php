<a href="{{ URL::to('cities/' . $city->id . '/categories/' . $rank->category->id . '/places/' . $place->id ) }}"
   class="label label-info"
   style="font-size: 14px;">#{{ $rank->rank }} {{ $rank->category->name }}
</a>