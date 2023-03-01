<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Life Log') }}
        </h2>
    </x-slot>
    
    @php
        $today = date('m/d/Y');
    @endphp

    <div class="w-10/12 mx-auto my-4">

        <div class="w-1/2 my-4">
            <form method="post" action="{{ route('lifelog.save') }}">
                @csrf

                <x-forms.labeled-input name="date" label="Date" :value="$today"/>
                <x-forms.labeled-input name="message" label="Text"/>
                <x-forms.submit-button text="Save" />
            </form>
        </div> 

        <x-page-buttons :secondaryLink="route('dashboard')" :secondaryText="__('Back to Dashboard')" />
    </div>
</x-app-layout>
