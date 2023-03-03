<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Life Log') }}
        </h2>
    </x-slot>
    
    <div class="w-10/12 mx-auto my-4">
        @foreach ($categories as $category)
            <div class="shadow-lg alert alert-{{ $category->color }} bg-{{ $category->color }} text-{{ $category->color }}-content my-4">
                <div>
                    <i class="{{ $category->icon }} text-xl"></i>
                    <div>
                        <span>{{ $category->name }}</span>
                        <div class="text-xs">ID: {{ $category->id }}</div>
                    </div>
                </div>
                <div class="flex-none">
                    <a href="{{ route('lifelogcategory.edit', $category->id) }}" class="btn btn-sm">{{ __('Edit Category') }}</a>
                </div>
            </div>
        @endforeach

        @isset($editCategory)
            <form action="{{ route('lifelogcategory.update', $editCategory->id) }}" method="post">
                @csrf

                <table class="table w-full">
                    <thead>
                        <tr class="bg-accent text-accent-content">
                            <td colspan="3" class="bg-accent">{{ __('Create Life Log Entry') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><x-forms.input-text name="icon" label="Icon Class" :value="$editCategory->icon" /></td>
                            <td><x-forms.input-text name="color" label="Color Class" :value="$editCategory->color" /></td>
                            <td><x-forms.input-text name="name" label="Category Name" :value="$editCategory->name" /></td>
                        </tr>
                        <tr>
                            <td colspan="4"><x-forms.submit-button text="Update Category" /></td>
                        </tr>
                    </tbody>    
                </table>
            </form>
        @else
            <form action="{{ route('lifelogcategory.save') }}" method="post">
                @csrf

                <table class="table w-full">
                    <thead>
                        <tr class="bg-accent text-accent-content">
                            <td colspan="3" class="bg-accent">{{ __('Create Life Log Category') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><x-forms.input-text name="icon" label="Icon Class" /></td>
                            <td><x-forms.input-text name="color" label="Color Class" /></td>
                            <td><x-forms.input-text name="name" label="Category Name" /></td>
                        </tr>
                        <tr>
                            <td colspan="4"><x-forms.submit-button text="Add Category" /></td>
                        </tr>
                    </tbody>    
                </table>
            </form>

        @endisset

        <x-page-buttons :secondaryLink="route('dashboard')" :secondaryText="__('Back to Dashboard')" />
    </div>
    
</x-app-layout>
