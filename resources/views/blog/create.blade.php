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
                    <x-forms.labeled-input name="title" label="Title"/>
                </div>

                <div class="my-4">
                    <x-forms.labeled-input name="slug" label="Slug"/>
                </div>

                <div class="my-4">
                    <x-forms.labeled-input name="date" label="Date" :value="$today"/>
                </div>

                <div class="my-4">
                    @php 
                        $options[] = ['value' => 'draft', 'text' => 'Draft'];
                        $options[] = ['value' => 'published', 'text' => 'Published'];
                    @endphp

                    <x-forms.labeled-dropdown name="status" label="Status" :options="$options" selected="draft" />
                </div>

                <div class="form-control">
                    <textarea name="markdown" class="textarea textarea-primary textarea-md" ></textarea>
                </div>

                <div class="my-4">
                    <x-forms.submit-button text="Save" />
                </div>
            </form>
        </div>


        <x-page-buttons :secondaryLink="route('dashboard')" :secondaryText="__('Back to Dashboard')" />
    </div>
</x-app-layout>
