<x-app-layout>
    <x-slot name="header">
        {{ $header ?? '' }}
    </x-slot>

    <div class="min-h-screen bg-slate-50 dark:bg-slate-950" style="background-image: url('/images/background1.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
