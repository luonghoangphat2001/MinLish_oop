<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">{{ __("You're logged in!") }}</p>
                    
                    <a href="{{ route('learning.session') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-white hover:bg-indigo-700 transition shadow-md">
                        Bắt đầu học ngay 🚀
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>