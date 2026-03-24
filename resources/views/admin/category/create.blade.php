<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            
            {{-- TITLE --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Category') }}
            </h2>

            {{-- BACK BUTTON --}}
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center gap-2 rounded-md bg-gray-700 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-600 transition">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 19l-7-7 7-7" />
                </svg>

                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                    @csrf

                    {{-- NAME --}}
                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" type="text"
                            class="mt-1 block w-full"
                            required
                            value="{{ old('name') }}" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- DESCRIPTION --}}
                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description"
                            class="mt-1 block w-full border-gray-300 rounded-md dark:bg-gray-900 dark:text-gray-100">
                            {{ old('description') }}
                        </textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- ACTIONS --}}
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.categories.index') }}"
                           class="text-sm text-gray-600 hover:underline dark:text-gray-300">
                            Cancel
                        </a>

                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>