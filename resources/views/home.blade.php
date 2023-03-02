<x-app-layout>

  <div class="w-10/12 mx-auto my-4">
    @foreach ($lifeLogs as $lifeLog)
      <div class="my-4 shadow-lg alert bg-primary text-primary-content">
        <div>
          (icon)
          <div>
            <span>{{ $lifeLog->message }}</span><br />
            <div class="text-xs">{{ date('m/d/Y', strtotime($lifeLog->date)) }}</div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

</x-app-layout>
