<x-app-layout>

  <div class="w-10/12 mx-auto my-4">
    @foreach ($lifeLogs as $lifeLog)
      <div class="shadow-lg my-4 alert alert-{{ $lifeLog->category->color }} bg-{{ $lifeLog->category->color }} text-{{ $lifeLog->category->color }}-content my-4">
        <div>
          <i class="{{ $lifeLog->category->icon }} text-xl"></i>
          <div>
            <span class="text-lg font-bold">{{ $lifeLog->message }}</span>
            <div class="text-xs">Date: {{ date('m/d/Y', strtotime($lifeLog->date)) }}</div>
          </div>
        </div>
        <div class="flex-none">
            @can('update', $lifeLog)<a href="{{ route('lifelog.edit', $lifeLog->id) }}" class="btn btn-sm">{{ __('Edit Life Log') }}</a>@endcan
        </div>
      </div>
    @endforeach
  </div>

</x-app-layout>
