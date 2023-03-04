<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Roles') }}
        </h2>
    </x-slot>
    
    <div class="w-10/12 mx-auto my-4">

        <table class="table w-full mx-auto table-compact table-zebra">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Action</td>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td><div class="badge badge-{{ $role->color }}">{{ $role->name }}</div></td>
                        <td><a href="{{ route('role.edit', $role->id) }}" class="link link-accent"><i class="fa-regular fa-file-pen"></i> Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <x-page-buttons :secondaryLink="route('dashboard')" :secondaryText="__('Back to Dashboard')" />
    </div>
    
</x-app-layout>
