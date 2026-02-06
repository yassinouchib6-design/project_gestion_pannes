<x-app-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4">

            <div class="flex items-start justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Détails intervention #{{ $intervention->id }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Panne: <span class="font-semibold text-gray-700">{{ $intervention->panne->titre ?? '-' }}</span>
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('interventions.index') }}"
                       class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        ← Retour
                    </a>

                    <a href="{{ route('interventions.edit', $intervention->id) }}"
                       class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                        Modifier
                    </a>

                    <form method="POST" action="{{ route('interventions.destroy', $intervention->id) }}">
                        @csrf @method('DELETE')
                        <button class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                onclick="return confirm('Supprimer cette intervention ?')">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-gray-500">Équipement</p>
                        <p class="font-semibold text-gray-900">{{ $intervention->panne->equipement->serie_equipement ?? '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-gray-500">Technicien</p>
                        <p class="font-semibold text-gray-900">{{ $intervention->technicien->name ?? '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-gray-500">Date</p>
                        <p class="font-semibold text-gray-900">{{ $intervention->date_intervention ?? '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-gray-500">Statut après</p>
                        <p class="font-semibold text-gray-900">{{ $intervention->statut_apres ?? '-' }}</p>
                    </div>
                </div>

                <div class="pt-2">
                    <p class="text-sm text-gray-500 mb-1">Description</p>
                    <div class="rounded-xl bg-gray-50 p-4 text-gray-800">
                        {{ $intervention->description ?? '—' }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>