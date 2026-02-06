<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Interventions</h1>
                    <p class="mt-1 text-sm text-gray-500">Liste des interventions enregistrées.</p>
                </div>

                <a href="{{ route('interventions.create') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white
                          shadow-md shadow-blue-600/30 hover:bg-blue-700">
                    + Nouvelle intervention
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr class="text-left">
                            <th class="px-6 py-3">Panne</th>
                            <th class="px-6 py-3">Équipement</th>
                            <th class="px-6 py-3">Technicien</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Statut après</th>
                            <th class="px-6 py-3 text-right">Action</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                        @forelse($interventions as $i)
                            @php
                                $st = $i->statut_apres ?? '-';
                                $stClass = match($st) {
                                    'nouvelle' => 'bg-amber-100 text-amber-700',
                                    'en_cours' => 'bg-blue-100 text-blue-700',
                                    'resolue'  => 'bg-emerald-100 text-emerald-700',
                                    default    => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $i->panne->titre ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $i->panne->equipement->serie_equipement ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $i->technicien->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $i->date_intervention ?? '—' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $stClass }}">
                                        {{ $st === '-' ? '-' : ucfirst(str_replace('_',' ', $st)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <a class="text-indigo-700 font-semibold hover:underline"
                                           href="{{ route('interventions.show', $i->id) }}">
                                            Voir
                                        </a>
                                        <a class="text-emerald-700 font-semibold hover:underline"
                                           href="{{ route('interventions.edit', $i->id) }}">
                                            Modifier
                                        </a>
                                        <form class="inline" method="POST" action="{{ route('interventions.destroy', $i->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 font-semibold hover:underline"
                                                onclick="return confirm('Supprimer cette intervention ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    Aucune intervention pour le moment.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    {{ $interventions->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>