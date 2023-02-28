<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Life Log') }}
        </h2>
    </x-slot>
    
    <div class="w-10/12 mx-auto my-4">
        <table class="table table-compact table-zebra">

            <thead>
                <tr>
                    <td>ID</td>
                    <td>Date</td>
                    <td>Message</td>
                    <td>Action</td>
                </tr>
            </thead>

            <tbody>
                @foreach ($lifeLogs as $lifeLog)
                    <tr>
                        <td>{{ $lifeLog->id }}</td>
                        <td>{{ date('m/d/Y', strtotime($lifeLog->date)) }}</td>
                        <td>{{ $lifeLog->message }}</td>
                        <td>&nbsp;</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <x-page-buttons :secondaryLink="route('dashboard')" :secondaryText="__('Back to Dashboard')" />

    </div>
    
</x-app-layout>
