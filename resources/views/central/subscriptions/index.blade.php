<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Suscripción') }} - {{ $tenant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($tenant->subscribed('default'))
                <!-- Tenant tiene suscripción activa -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Suscripción Activa</h3>
                            <p class="text-gray-600 mt-2">Plan: <span
                                    class="font-semibold text-indigo-600">{{ ucfirst($tenant->plan) }}</span></p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('subscriptions.portal', $tenant) }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Gestionar Suscripción
                            </a>
                        </div>
                    </div>

                    @if($tenant->subscription('default')->onGracePeriod())
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                            Tu suscripción está programada para cancelarse el
                            {{ $tenant->subscription('default')->ends_at->format('d/m/Y') }}.
                            <form action="{{ route('subscriptions.resume-subscription', $tenant) }}" method="POST"
                                class="inline">
                                @csrf
                                <button type="submit" class="underline font-semibold">Reanudar suscripción</button>
                            </form>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Estado</p>
                            <p class="text-lg font-semibold text-green-600">Activa</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Plan</p>
                            <p class="text-lg font-semibold">{{ ucfirst($tenant->plan) }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Próximo pago</p>
                            <p class="text-lg font-semibold">
                                @if($tenant->subscription('default')->onGracePeriod())
                                    Cancelada
                                @else
                                                    {{ $tenant->subscription('default')->asStripeSubscription()->current_period_end ?
                                    \Carbon\Carbon::createFromTimestamp($tenant->subscription('default')->asStripeSubscription()->current_period_end)->format('d/m/Y') :
                                    'N/A' }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Tenant NO tiene suscripción -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Selecciona un Plan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Plan Basic -->
                        <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-indigo-500 transition">
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Basic</h4>
                            <p class="text-3xl font-bold text-indigo-600 mb-4">$29<span
                                    class="text-sm text-gray-600">/mes</span></p>
                            <ul class="space-y-2 mb-6">
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Hasta 100 productos
                                </li>
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    1 usuario
                                </li>
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Soporte por email
                                </li>
                            </ul>
                            <form action="{{ route('subscriptions.checkout', $tenant) }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="basic">
                                <button type="submit"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Seleccionar
                                </button>
                            </form>
                        </div>

                        <!-- Plan Pro -->
                        <div class="border-2 border-indigo-500 rounded-lg p-6 relative">
                            <div
                                class="absolute top-0 right-0 bg-indigo-500 text-white px-3 py-1 text-sm font-semibold rounded-bl-lg rounded-tr-lg">
                                Popular
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Pro</h4>
                            <p class="text-3xl font-bold text-indigo-600 mb-4">$79<span
                                    class="text-sm text-gray-600">/mes</span></p>
                            <ul class="space-y-2 mb-6">
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Productos ilimitados
                                </li>
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Hasta 5 usuarios
                                </li>
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Soporte prioritario
                                </li>
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Reportes avanzados
                                </li>
                            </ul>
                            <form action="{{ route('subscriptions.checkout', $tenant) }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="pro">
                                <button type="submit"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Seleccionar
                                </button>
                            </form>
                        </div>

                        <!-- Plan Enterprise -->
                        <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-indigo-500 transition">
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Enterprise</h4>
                            <p class="text-3xl font-bold text-indigo-600 mb-4">$199<span
                                    class="text-sm text-gray-600">/mes</span></p>
                            <ul class="space-y-2 mb-6">
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Todo de Pro
                                </li>
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Usuarios ilimitados
                                </li>
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Soporte 24/7
                                </li>
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    API personalizada
                                </li>
                            </ul>
                            <form action="{{ route('subscriptions.checkout', $tenant) }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="enterprise">
                                <button type="submit"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Seleccionar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>