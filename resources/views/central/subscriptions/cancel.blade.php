<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pago Cancelado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                <div class="mb-6">
                    <svg class="w-20 h-20 text-yellow-500 mx-auto" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h3 class="text-3xl font-bold text-gray-900 mb-4">Pago Cancelado</h3>
                <p class="text-gray-600 mb-8">
                    El proceso de pago fue cancelado. No se realizó ningún cargo.
                </p>

                <div class="space-y-3">
                    <a href="{{ route('subscriptions.index', $tenant) }}"
                        class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded">
                        Intentar de Nuevo
                    </a>
                    <br>
                    <a href="{{ route('tenants.index') }}"
                        class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded">
                        Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>