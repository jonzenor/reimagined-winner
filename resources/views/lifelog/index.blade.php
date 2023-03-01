<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Life Log') }}
        </h2>
    </x-slot>
    
    <div class="w-10/12 mx-auto my-4">
        <table class="table table-zebra">

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
                        <td><a href="{{ route('lifelog.edit', $lifeLog->id) }}" class="link link-accent">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @isset($editLifeLog)
            <form action="{{ route('lifelog.update', $editLifeLog->id) }}" method="post">
                @csrf

                <table class="table w-full">
                    <thead>
                        <tr>
                            <td colspan="2">{{ __('Edit Life Log Entry') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><x-forms.labeled-input name="date" label="Date" :value="date('m/d/Y', strtotime($editLifeLog->date))" /></td>
                            <td><x-forms.labeled-input name="message" label="Message" :value="$editLifeLog->message" /></td>
                            <td><x-forms.submit-button text="Update" /></td>
                        </tr>
                    </tbody>    
                </table>
            </form>
        @endisset

        <x-page-buttons :secondaryLink="route('dashboard')" :secondaryText="__('Back to Dashboard')" />
    </div>
    
</x-app-layout>
