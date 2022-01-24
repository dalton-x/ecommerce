<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        @if (request()->routeIs('dashboard'))
            {{ __('Dashboard') }}
        @else
            {{ __('Ajouter un produit') }}
        @endif
        </h2>
    </x-slot>

    @if (request()->routeIs('dashboard'))
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    @else
        @yield('dashboard')
    @endif


</x-app-layout>
