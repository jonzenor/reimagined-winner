<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Create Blog') }}
        </h2>
    </x-slot>
    
    @php
        $today = date('m/d/Y');
    @endphp

    <div class="w-10/12 mx-auto my-4">

        <div class="w-1/2 my-4">
            <form method="post" action="{{ route('blog.store') }}">
                @csrf

                <div class="my-4">
                    <x-forms.labeled-input name="title" label="Title" :value="$blog->title"/>
                </div>

                <div class="my-4">
                    <x-forms.labeled-input name="slug" label="Slug" :value="$blog->slug" />
                </div>

                <div class="my-4">
                    <x-forms.labeled-input name="date" label="Date" :value="date('m/d/Y', strtotime($blog->date))"/>
                </div>

                <div class="my-4">
                    @php 
                        $options[] = ['value' => 'draft', 'text' => 'Draft'];
                        $options[] = ['value' => 'published', 'text' => 'Published'];
                    @endphp

                    <x-forms.labeled-dropdown name="status" label="Status" :options="$options" :selected="$blog->status"/>
                </div>

                <div class="form-control">
                    <textarea name="text" class="textarea textarea-primary textarea-md" >{{ $blog->text }}</textarea>
                </div>

                <div class="my-4">
                    <x-forms.submit-button text="Save" />
                </div>
            </form>
        </div>


        <x-page-buttons :secondaryLink="route('dashboard')" :secondaryText="__('Back to Dashboard')" />
    </div>
</x-app-layout>
