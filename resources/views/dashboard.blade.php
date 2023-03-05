<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid w-11/12 grid-cols-1 gap-4 mx-auto my-4 md:grid-cols-2 xl:grid-cols-3">
    
        @can('viewAny', App\Models\LifeLog::class)
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
                            <td>{{ $lifeLog['categoryCount'] }}</td>
                            <td><a href="{{ route('lifelogcategory.index') }}" class="link link-accent">Manage</a></td>
                        </tr>
                    </tbody>
                </table>

                <div class="justify-end my-4 card-actions">
                    <a href="{{ route('lifelog.create') }}" class="btn btn-primary">Add Log Entry</a>
                </div>
            </x-info-card>
        @endcan

        @can('viewAny', App\Models\User::class)
            <x-info-card :title="__('User Stats')">
                <table class="table w-full">
                    <tbody>
                        <tr>
                            <td>Users</td>
                            <td>{{ $users['userCount'] }}</td>
                            <td><a href="{{ route('user.index') }}" class="link link-accent">Manage</a></td>
                        </tr>
                        <tr>
                            <td>Roles</td>
                            <td>{{ $users['roleCount'] }}</td>
                            <td><a href="{{ route('role.index') }}" class="link link-accent">Manage</a></td>
                        </tr>
                    </tbody>
                </table>
            </x-info-card>
        @endcan
    </div>
    
</x-app-layout>
