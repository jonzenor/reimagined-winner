<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Blogs') }}
        </h2>
    </x-slot>
    
    <div class="w-10/12 mx-auto my-4">
        <table class="table w-full">
            <thead>
                <tr>
                    <td>Blog Title</td>
                    <td>Date</td>
                    <td>Status</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                <tr>
                    <td>{{ $blog->title }}</td>
                    <td>{{ $blog->date }}</td>
                    <td>{{ ucfirst($blog->status) }}</td>
                    <td><a href="{{ route('blog.edit', $blog->id) }}" class="link link-accent">Edit Blog</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- @foreach ($lifeLogs as $lifeLog)
            <div class="shadow-lg my-4 alert alert-{{ $lifeLog->category->color }} bg-{{ $lifeLog->category->color }} text-{{ $lifeLog->category->color }}-content my-4">
                <div>
                    <i class="{{ $lifeLog->category->icon }} text-xl"></i>
                    <div>
                        <span>{{ $lifeLog->message }}</span>
                        <div class="text-xs">Date: {{ date('m/d/Y', strtotime($lifeLog->date)) }}</div>
                    </div>
                </div>
                <div class="flex-none">
                    <a href="{{ route('lifelog.edit', $lifeLog->id) }}" class="btn btn-sm">{{ __('Edit Life Log') }}</a>
                </div>
            </div>
        @endforeach --}}

        <x-page-buttons :secondaryLink="route('dashboard')" :secondaryText="__('Back to Dashboard')" />
    </div>
    
</x-app-layout>
