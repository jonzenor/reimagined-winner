<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Role -- Edit') }}
        </h2>
    </x-slot>
    
    <div class="w-10/12 mx-auto my-4">

        <form action="{{ route('role.update', $role->id) }}" method="post">
            @csrf

            <div class="my-8">
                <x-forms.labeled-input name="name" label="Name" :value="$role->name" />
            </div>
            
            <div class="my-8">
                <x-forms.labeled-input name="color" label="Color" :value="$role->color" />
            </div>

            <div class="my-8">
                <x-forms.submit-button text="Update Role" />
            </div>
        </form>
    

        <x-page-buttons :secondaryLink="route('role.index')" :secondaryText="__('Back to Roles')" />
    </div>
    
</x-app-layout>
