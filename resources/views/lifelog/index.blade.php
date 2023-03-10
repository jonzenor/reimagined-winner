<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Life Log') }}
        </h2>
    </x-slot>
    
    <div class="w-10/12 mx-auto my-4">
        @foreach ($lifeLogs as $lifeLog)
            <div class="shadow-lg my-4 alert alert-{{ $lifeLog->category->color }} bg-{{ $lifeLog->category->color }} text-{{ $lifeLog->category->color }}-content my-4">
                <div>
                    <i class="{{ $lifeLog->category->icon }} text-xl"></i>
                    <div>
                        <span>{{ $lifeLog->message }}</span>
                        <div class="text-xs">Date: {{ date('m/d/Y', strtotime($lifeLog->date)) }}</div>
                    </div>
                </div>
                <div class="flex-none">
                    <a href="{{ route('lifelog.edit', $lifeLog->id) }}" class="btn btn-sm">{{ __('Edit Life Log') }}</a>
                </div>
            </div>
        @endforeach

        @php
            $options = array();
            foreach($categories as $category)
            {
                $options[] = [
                    'value' => $category->id,
                    'text' => $category->name
                ];
            }
        @endphp

        @isset($editLifeLog)
            <form action="{{ route('lifelog.update', $editLifeLog->id) }}" method="post">
                @csrf

                <table class="table w-full">
                    <thead>
                        <tr>
                            <td colspan="3">{{ __('Edit Life Log Entry') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-bottom" colspan="3"><x-forms.labeled-input name="message" label="Message" :value="$editLifeLog->message" /></td>
                        </tr>
                        <tr>
                            <td class="align-bottom"><x-forms.select-dropdown name="category" :options="$options" firstOption="Select a Category" label="Category" :selected="$editLifeLog->category->id" /></td>
                            <td class="align-bottom"><x-forms.input-text name="date" label="Date" :value="date('m/d/Y', strtotime($editLifeLog->date))" /></td>
                            <td class="align-bottom" colspan="3"><x-forms.submit-button text="Update" /></td>
                        </tr>
                    </tbody>    
                </table>
            </form>
        @else
            <form action="{{ route('lifelog.save') }}" method="post">
                @csrf

                <table class="table w-full my-5 table-compact">
                    <thead>
                        <tr>
                            <td colspan="4">{{ __('Create Life Log Entry') }}</td>
                        </tr>
                    </thead>
                    <tbody class="align-bottom">
                        <tr>
                            <td class="align-bottom">
                                <x-forms.select-dropdown name="category" :options="$options" firstOption="Select a Category" label="Category" />
                            </td>
                            <td class="align-bottom"><x-forms.input-text name="date" label="Date" :value="date('m/d/Y')" /></td>
                            <td class="align-bottom"><x-forms.input-text name="message" label="Message" /></td>
                            <td class="align-bottom"><x-forms.submit-button text="Add Life Log" /></td>
                        </tr>
                    </tbody>    
                </table>
            </form>

        @endisset

        <x-page-buttons :secondaryLink="route('dashboard')" :secondaryText="__('Back to Dashboard')" />
    </div>
    
</x-app-layout>
