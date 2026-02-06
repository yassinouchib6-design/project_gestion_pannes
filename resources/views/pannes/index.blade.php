<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Mes pannes</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Retrouvez ici toutes vos pannes (style carte professionnel).
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}"
                       class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        ← Dashboard
                    </a>

                    <a href="{{ route('pannes.create') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white
                              shadow-md shadow-blue-600/30 hover:bg-blue-700">
                        + Nouvelle panne
                    </a>
                </div>
            </div>

            {{-- Success --}}
            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Grid Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @forelse($pannes as $p)
                    @php
                        $role = auth()->user()->role ?? 'utilisateur';
                        $canEdit = ($role !== 'utilisateur') || ($p->utilisateur_id === auth()->id());

                        $st = $p->statut ?? 'nouvelle';
                        $stBadge = match($st) {
                            'nouvelle' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'en_cours' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'resolue'  => 'bg-green-100 text-green-700 border-green-200',
                            default    => 'bg-gray-100 text-gray-700 border-gray-200',
                        };

                        $prio = $p->priorite ?? 'medium';
                        $prioBadge = match($prio) {
                            'low'    => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'high'   => 'bg-rose-100 text-rose-700 border-rose-200',
                            default  => 'bg-amber-100 text-amber-700 border-amber-200',
                        };
                    @endphp

                    <div class="rounded-2xl bg-white shadow-md border border-gray-100 overflow-hidden">
                        {{-- Top bar --}}
                        <div class="p-5 border-b bg-gray-50">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h2 class="text-lg font-bold text-gray-900 leading-snug">
                                        {{ $p->titre }}
                                    </h2>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Équipement: <span class="font-semibold text-gray-700">
                                            {{ $p->equipement->serie_equipement ?? '-' }}
                                        </span>
                                    </p>
                                </div>

                                <span class="shrink-0 inline-flex items-center rounded-full border px-3 py-1 text-xs font-bold {{ $stBadge }}">
                                    {{ str_replace('_',' ', ucfirst($st)) }}
                                </span>
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="p-5 space-y-4">

                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-bold {{ $prioBadge }}">
                                    Priorité: {{ ucfirst($prio) }}
                                </span>

                                @if(!empty($p->date_panne))
                                    <span class="inline-flex items-center rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-700">
                                        Date: {{ $p->date_panne }}
                                    </span>
                                @endif

                                @if(!empty($p->type_panne))
                                    <span class="inline-flex items-center rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-700">
                                        Type: {{ $p->type_panne }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-sm text-gray-600 line-clamp-3">
                                {{ $p->description ?? '—' }}
                            </p>
                        </div>

                        {{-- Actions --}}
                        <div class="px-5 py-4 border-t bg-white flex items-center justify-between">
                            <a href="{{ route('pannes.show', $p->id) }}"
                               class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-black">
                                Détails
                            </a>

                            @if($canEdit)
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('pannes.edit', $p->id) }}"
                                       class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                                        Modifier
                                    </a>

                                    <form method="POST" action="{{ route('pannes.destroy', $p->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                                onclick="return confirm('Supprimer cette panne ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="rounded-2xl bg-white shadow border border-gray-100 p-10 text-center">
                            <p class="text-gray-700 font-semibold">Aucune panne pour le moment.</p>
                            <p class="text-sm text-gray-500 mt-1">Cliquez sur “Nouvelle panne” pour en ajouter une.</p>

                            <a href="{{ route('pannes.create') }}"
                               class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white
                                      shadow-md shadow-blue-600/30 hover:bg-blue-700">
                                + Nouvelle panne
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $pannes->links() }}
            </div>

        </div>
    </div>
</x-app-layout>