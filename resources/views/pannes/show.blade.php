<x-app-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4">

            @php
                $role = auth()->user()->role ?? 'utilisateur';
                $canEdit = ($role !== 'utilisateur') || ($panne->utilisateur_id === auth()->id());

                $st = $panne->statut ?? 'nouvelle';
                $badge = match($st) {
                    'nouvelle' => 'bg-amber-100 text-amber-700',
                    'en_cours' => 'bg-blue-100 text-blue-700',
                    'resolue'  => 'bg-green-100 text-green-700',
                    default    => 'bg-gray-100 text-gray-700'
                };
            @endphp

            <div class="flex items-start justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $panne->titre }}</h1>
                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $badge }}">
                            {{ str_replace('_',' ', ucfirst($st)) }}
                        </span>

                        @php($prio = $panne->priorite ?? 'medium')
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold
                            @if($prio==='low') bg-emerald-100 text-emerald-700
                            @elseif($prio==='high') bg-rose-100 text-rose-700
                            @else bg-amber-100 text-amber-700 @endif">
                            Priorité: {{ ucfirst($prio) }}
                        </span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('pannes.index') }}"
                       class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        ← Retour
                    </a>

                    @if($canEdit)
                        <a href="{{ route('pannes.edit', $panne->id) }}"
                           class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                            Modifier
                        </a>

                        <form method="POST" action="{{ route('pannes.destroy', $panne->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                    onclick="return confirm('Supprimer ?')">
                                Supprimer
                            </button>
                        </form>
                    @endif
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
                        <p class="font-semibold text-gray-900">{{ $panne->equipement->serie_equipement ?? '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-gray-500">Contact</p>
                        <p class="font-semibold text-gray-900">{{ $panne->contact ?? '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-gray-500">Date de la panne</p>
                        <p class="font-semibold text-gray-900">{{ $panne->date_panne ?? '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-gray-500">Type</p>
                        <p class="font-semibold text-gray-900">{{ $panne->type_panne ?? '-' }}</p>
                    </div>
                </div>

                <div class="pt-2">
                    <p class="text-sm text-gray-500 mb-1">Description</p>
                    <div class="rounded-xl bg-gray-50 p-4 text-gray-800">
                        {{ $panne->description ?? '—' }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>