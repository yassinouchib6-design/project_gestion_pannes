<x-app-layout>
    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4">

            {{-- HEADER --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-7">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Tableau de bord</h1>
                    <p class="text-sm text-gray-500 mt-1">Bienvenue {{ $user->name ?? 'Utilisateur' }}</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('pannes.index') }}"
                       class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Voir les pannes
                    </a>

                    <a href="{{ route('pannes.create') }}"
                       class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        + Nouvelle panne
                    </a>
                </div>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Total des pannes</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['pannes'] ?? 0 }}</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Nouvelles</p>
                    <p class="text-3xl font-extrabold text-amber-600 mt-2">{{ $stats['nouvelles'] ?? 0 }}</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <p class="text-sm text-gray-500">En cours</p>
                    <p class="text-3xl font-extrabold text-blue-600 mt-2">{{ $stats['en_cours'] ?? 0 }}</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Résolues</p>
                    <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $stats['resolues'] ?? 0 }}</p>
                </div>
            </div>

            {{-- LATEST PANNES TABLE --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6 pb-3">
                    <h2 class="text-lg font-bold text-gray-900">Mes dernières pannes</h2>
                    <p class="text-sm text-gray-500">Les 5 dernières pannes enregistrées.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="py-3 px-6 font-semibold">TITRE</th>
                            <th class="px-6 font-semibold">EQUIPEMENT</th>
                            <th class="px-6 font-semibold">PRIORITE</th>
                            <th class="px-6 font-semibold">STATUT</th>
                            <th class="px-6 font-semibold text-right">ACTION</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                        @forelse(($latestPannes ?? collect()) as $p)
                            @php
                                $prio = strtolower($p->priorite ?? 'medium');
                                $prioLabel = $p->priorite ?? '-';

                                $stat = strtolower($p->statut ?? 'nouvelle');
                                $statLabel = $p->statut ?? '-';

                                $statClass = match($stat) {
                                    'nouvelle' => 'bg-amber-100 text-amber-700',
                                    'en_cours' => 'bg-blue-100 text-blue-700',
                                    'resolue'  => 'bg-emerald-100 text-emerald-700',
                                    default    => 'bg-gray-100 text-gray-700'
                                };

                                $prioClass = match($prio) {
                                    'low'    => 'bg-gray-100 text-gray-700',
                                    'medium' => 'bg-amber-100 text-amber-700',
                                    'high'   => 'bg-red-100 text-red-700',
                                    default  => 'bg-gray-100 text-gray-700'
                                };
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 font-medium text-gray-900">
                                    {{ $p->titre }}
                                </td>

                                <td class="px-6 text-gray-700">
                                    {{ $p->equipement->serie_equipement ?? '-' }}
                                </td>

                                <td class="px-6">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $prioClass }}">
                                        {{ ucfirst($prioLabel) }}
                                    </span>
                                </td>

                                <td class="px-6">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $statClass }}">
                                        {{ ucfirst($statLabel) }}
                                    </span>
                                </td>

                                <td class="px-6 text-right">
                                    <a href="{{ route('pannes.show', $p->id) }}"
                                       class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-black">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-500">
                                    Aucune panne enregistrée.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6 pt-4 flex justify-end">
                    <a href="{{ route('pannes.index') }}"
                       class="text-sm font-semibold text-gray-700 hover:text-gray-900">
                        Voir tout
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>