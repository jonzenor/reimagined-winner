<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Users') }}
        </h2>
    </x-slot>
    
    <div class="w-10/12 mx-auto my-4">

        <table class="table w-full mx-auto table-compact table-zebra">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Role</td>
                    <td>Action</td>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if ($user->role)
                                <div class="badge badge-{{ $user->role->color }}">{{ $user->role->name }}</div>
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td><a href="{{ route('user.edit', $user->id) }}" class="link link-accent"><i class="fa-solid fa-user-pen"></i> Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <x-page-buttons :secondaryLink="route('dashboard')" :secondaryText="__('Back to Dashboard')" />
    </div>
    
</x-app-layout>
