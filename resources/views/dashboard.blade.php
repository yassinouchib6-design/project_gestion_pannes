<x-app-layout>
    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4">

            {{-- HEADER --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-7">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        @if(($role ?? '') === 'technicien')
                            Dashboard Technicien
                        @else
                            Tableau de bord
                        @endif
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Bienvenue {{ $user->name ?? 'Utilisateur' }}
                    </p>
                </div>

                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('pannes.index') }}"
                       class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Voir les pannes
                    </a>

                    @if(($role ?? '') === 'utilisateur')
                        <a href="{{ route('pannes.create') }}"
                           class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                            + Nouvelle panne
                        </a>
                    @endif

                    @if(in_array(($role ?? ''), ['admin','technicien']))
                        <a href="{{ route('interventions.index') }}"
                           class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                            Interventions
                        </a>
                    @endif

                    {{-- ✅ ADMIN فقط: زر Techniciens --}}
                    @if(($role ?? '') === 'admin')
   <a href="{{ route('techniciens.index') }}"
      class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
        Techniciens
   </a>
@endif
                </div>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <p class="text-sm text-gray-500">
                        @if(($role ?? '') === 'technicien') Pannes assignées @else Total des pannes @endif
                    </p>
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

            {{-- TECHNICIEN: Latest interventions --}}
            @if(($role ?? '') === 'technicien')
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
                    <div class="p-6 pb-3">
                        <h2 class="text-lg font-bold text-gray-900">Mes dernières interventions</h2>
                        <p class="text-sm text-gray-500">Les 5 dernières interventions réalisées.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                            <tr class="text-left">
                                <th class="py-3 px-6 font-semibold">Panne</th>
                                <th class="px-6 font-semibold">Équipement</th>
                                <th class="px-6 font-semibold">Date</th>
                                <th class="px-6 font-semibold text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            @forelse(($latestInterventions ?? collect()) as $itv)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-6 font-medium text-gray-900">
                                        {{ $itv->panne->titre ?? '-' }}
                                    </td>
                                    <td class="px-6 text-gray-700">
                                        {{ $itv->panne->equipement->serie_equipement ?? '-' }}
                                    </td>
                                    <td class="px-6 text-gray-700">
                                        {{ optional($itv->created_at)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 text-right">
                                        @if($itv->panne)
                                            <a href="{{ route('pannes.show', $itv->panne->id) }}"
                                               class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-black">
                                                Voir panne
                                            </a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-gray-500">
                                        Aucune intervention pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 pt-4 flex justify-end">
                        <a href="{{ route('interventions.index') }}"
                           class="text-sm font-semibold text-gray-700 hover:text-gray-900">
                            Voir tout
                        </a>
                    </div>
                </div>
            @endif

            {{-- Latest pannes --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6 pb-3">
                    <h2 class="text-lg font-bold text-gray-900">
                        @if(($role ?? '') === 'technicien')
                            Dernières pannes assignées
                        @else
                            Mes dernières pannes
                        @endif
                    </h2>
                    <p class="text-sm text-gray-500">Les 5 dernières pannes.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                        <tr class="text-left">
                            <th class="py-3 px-6 font-semibold">Titre</th>
                            <th class="px-6 font-semibold">Équipement</th>
                            <th class="px-6 font-semibold">Priorité</th>
                            <th class="px-6 font-semibold">Statut</th>
                            <th class="px-6 font-semibold text-right">Action</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                        @forelse(($latestPannes ?? collect()) as $p)
                            @php
                                $stat = strtolower($p->statut ?? 'nouvelle');
                                $statClass = match($stat) {
                                    'nouvelle' => 'bg-amber-100 text-amber-700',
                                    'en_cours' => 'bg-blue-100 text-blue-700',
                                    'resolue'  => 'bg-emerald-100 text-emerald-700',
                                    default    => 'bg-gray-100 text-gray-700'
                                };

                                $prio = strtolower($p->priorite ?? 'medium');
                                $prioClass = match($prio) {
                                    'low'    => 'bg-gray-100 text-gray-700',
                                    'medium' => 'bg-amber-100 text-amber-700',
                                    'high'   => 'bg-red-100 text-red-700',
                                    default  => 'bg-gray-100 text-gray-700'
                                };
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 font-medium text-gray-900">{{ $p->titre }}</td>
                                <td class="px-6 text-gray-700">{{ $p->equipement->serie_equipement ?? '-' }}</td>

                                <td class="px-6">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $prioClass }}">
                                        {{ ucfirst($p->priorite ?? '-') }}
                                    </span>
                                </td>

                                <td class="px-6">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $statClass }}">
                                        {{ ucfirst(str_replace('_',' ', $p->statut ?? '-')) }}
                                    </span>
                                </td>

                                <td class="px-6 text-right">
                                    <a href="{{ route('pannes.show', $p->id) }}"
                                       class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-black">
                                        Détails
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-500">
                                    Aucune panne.
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