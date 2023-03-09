<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Blogs') }}
        </h2>
    </x-slot>
    
    <div class="w-10/12 mx-auto my-4">

        <div class="shadow-xl card w-10/12 bg-base-300 my-4 mx-auto">
            <div class="card-body">
                <h2 class="card-title">{{ $blog->title }}</h2>
                <span class="text-sm">{{ date('m/d/Y', strtotime($blog->date)) }}</span>
                
                <div class="bg-neutral text-neutral-content p-2 my-4 rounded-lg">
                    {!! $blog->html !!}
                </div>
            </div>

        </div>

    </div>
    
</x-app-layout>
