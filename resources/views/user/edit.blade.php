<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('User -- Edit') }}
        </h2>
    </x-slot>
    
    <div class="w-10/12 mx-auto my-4">

        <form action="{{ route('user.update', $user->id) }}" method="post">
            @csrf

            <div class="my-8">
                <x-forms.labeled-input name="name" label="Name" :value="$user->name" />
            </div>
            
            <div class="my-8">
                <x-forms.labeled-input name="email" label="Email" :value="$user->email" />
            </div>

            @php
                $options[] = [
                    'value' => 0,
                    'text' => "Remove Role",
                ];

                foreach ($roles as $role) {
                    $options[] = [
                        'value' => $role->id,
                        'text' => $role->name,
                    ];
                }
            @endphp

            <div class="my-8">
                <x-forms.labeled-dropdown name="role" label="Role" :options="$options" firstOption="Select Role" :selected="$user->role_id" />
            </div>
            
            <div class="my-8">
                <x-forms.submit-button text="Update User" />
            </div>
        </form>
    

        <x-page-buttons :secondaryLink="route('user.index')" :secondaryText="__('Back to Users')" />
    </div>
    
</x-app-layout>
