<x-app-layout>
    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">Tableau de bord</h1>
                    <p class="mt-1 text-sm text-gray-500">Bienvenue {{ $user->name ?? 'Utilisateur' }}</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('pannes.index') }}"
                       class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                        Voir les pannes
                    </a>

                    <a href="{{ route('pannes.create') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                        + Nouvelle panne
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Total des pannes</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['pannes'] ?? 0 }}</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Nouvelles</p>
                    <p class="mt-2 text-3xl font-bold text-amber-600">{{ $stats['nouvelles'] ?? 0 }}</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">En cours</p>
                    <p class="mt-2 text-3xl font-bold text-indigo-600">{{ $stats['en_cours'] ?? 0 }}</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Résolues</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $stats['resolues'] ?? 0 }}</p>
                </div>
            </div>

            {{-- Latest pannes --}}
            <div class="mt-6 rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="flex items-start justify-between gap-4 p-6">
                    <div>
                        <h2 class="text-base font-bold text-gray-900">Mes dernières pannes</h2>
                        <p class="mt-1 text-sm text-gray-500">Les 5 dernières pannes enregistrées.</p>
                    </div>

                    <a href="{{ route('pannes.index') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-700">
                        Voir tout
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                            <tr class="text-left">
                                <th class="px-6 py-3">Titre</th>
                                <th class="px-6 py-3">Équipement</th>
                                <th class="px-6 py-3">Priorité</th>
                                <th class="px-6 py-3">Statut</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($latestPannes as $p)
                                @php
                                    $prio = strtolower($p->priorite ?? '');
                                    $stat = strtolower($p->statut ?? '');
                                    $prioClass = match($prio) {
                                        'high' => 'bg-red-50 text-red-700',
                                        'medium' => 'bg-amber-50 text-amber-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                    $statClass = match($stat) {
                                        'en_cours' => 'bg-indigo-50 text-indigo-700',
                                        'resolue' => 'bg-emerald-50 text-emerald-700',
                                        default => 'bg-amber-50 text-amber-700'
                                    };
                                @endphp

                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $p->titre }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $p->equipement->serie_equipement ?? '-' }}</td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $prioClass }}">
                                            {{ ucfirst($p->priorite ?? '-') }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statClass }}">
                                            {{ ucfirst(str_replace('_',' ', $p->statut ?? '-')) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('pannes.show', $p->id) }}"
                                           class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-2 text-xs font-semibold text-white hover:bg-gray-800">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        Aucune panne enregistrée.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4"></div>
            </div>

        </div>
    </div>
</x-app-layout>