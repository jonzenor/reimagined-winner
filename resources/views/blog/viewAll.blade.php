<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Blogs') }}
        </h2>
    </x-slot>
    
    <div class="grid w-11/12 grid-cols-1 gap-4 mx-auto my-4 xl:grid-cols-2">

        @foreach ($blogs as $blog)
            <div class="shadow-xl card w-10/12 bg-base-300 my-4 mx-auto">
                <div class="card-body">
                    <h2 class="card-title"><a href="{{ route('blogs.view', $blog->slug) }}" class="link link-primary">{{ $blog->title }}</a></h2>
                    <span class="text-sm">{{ date('m/d/Y', strtotime($blog->date)) }}</span>
                    
                    <div class="bg-neutral text-neutral-content p-2 my-4 rounded-lg">
                        {{ substr(strip_tags($blog->html), 0, config('blog.truncate_characters')) }}
                    </div>
                </div>

                <div class="text-right mx-4">
                    <a href="{{ route('blogs.view', $blog->slug) }}" class="btn btn-primary">View Article</a>
                </div>
            </div>
        @endforeach

    </div>
    
</x-app-layout>
