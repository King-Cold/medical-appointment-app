
@if (count($breadcrumbs))
<nav class="mb-2 block">
  <ol class="flex flex-wrap text-slate-700 text-sm">
    @foreach ($breadcrumbs as $item)
      <li class="flex items-center">

        @unless ($loop->first)
          <span class="px-2 text-gray-400">/</span>
        @endunless

        @isset($item['href'])
          <a href="{{ $item['href'] }}" class="text-gray-400 hover:text-gray-700 transition">
            {{ $item['name'] }}
          </a>
        @else
          <span class="text-gray-700 font-medium">
            {{ $item['name'] }}
          </span>
        @endisset

      </li>
    @endforeach
  </ol>

  @if (count($breadcrumbs) > 1)
    <h6 class="font-bold mt-2">
      {{ end($breadcrumbs)['name'] }}
    </h6>
  @endif
</nav>
@endif