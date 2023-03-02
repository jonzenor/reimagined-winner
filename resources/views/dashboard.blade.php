<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-10/12 mx-auto my-4">
    
        <x-info-card :title="__('Life Log Stats')">
            
            <table class="table w-full">
                <tbody>
                    <tr>
                        <td>Log Entries</td>
                        <td>{{ $lifeLog['messageCount'] }}</td>
                        <td><a href="{{ route('lifelog.index') }}" class="link link-accent">Manage</a></td>
                    </tr>
                    <tr>
                        <td>Categories</td>
                        <td>###</td>
                        <td><a href="{{ route('lifelogcategory.index') }}" class="link link-accent">Manage</a></td>
                    </tr>
                </tbody>
            </table>

            <div class="justify-end my-4 card-actions">
                <a href="{{ route('lifelog.create') }}" class="btn btn-primary">Add Log Entry</a>
            </div>
        </x-info-card>
    </div>
    
</x-app-layout>
