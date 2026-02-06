<x-app-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4">

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Nouvelle intervention</h1>
                    <p class="text-sm text-gray-500 mt-1">Ajoutez une intervention liée à une panne.</p>
                </div>

                <a href="{{ route('interventions.index') }}"
                   class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    ← Retour
                </a>
            </div>

            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                    <p class="font-semibold mb-2">Veuillez corriger les erreurs :</p>
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('interventions.store') }}"
                  class="bg-white rounded-2xl shadow-md border border-gray-100">
                @csrf

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Panne <span class="text-red-500">*</span></label>
                        <select name="panne_id" required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Choisir une panne --</option>
                            @foreach($pannes as $p)
                                <option value="{{ $p->id }}"
                                    @selected(old('panne_id', $selectedPanneId)==$p->id)>
                                    #{{ $p->id }} — {{ $p->titre }} ({{ $p->equipement->serie_equipement ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if((auth()->user()->role ?? '') === 'admin')
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Technicien</label>
                            <select name="technicien_id"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Auto (admin) --</option>
                                @foreach($techniciens as $t)
                                    <option value="{{ $t->id }}" @selected(old('technicien_id')==$t->id)>
                                        {{ $t->name }} ({{ $t->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date intervention</label>
                        <input type="date" name="date_intervention" value="{{ old('date_intervention') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut après</label>
                        <select name="statut_apres"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Ne pas changer --</option>
                            <option value="nouvelle" @selected(old('statut_apres')==='nouvelle')>Nouvelle</option>
                            <option value="en_cours" @selected(old('statut_apres')==='en_cours')>En cours</option>
                            <option value="resolue"  @selected(old('statut_apres')==='resolue')>Résolue</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="5"
                                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Décrivez l'intervention...">{{ old('description') }}</textarea>
                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 border-t bg-gray-50 px-6 py-4 rounded-b-2xl">
                    <a href="{{ route('interventions.index') }}"
                       class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                        Annuler
                    </a>

                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white
                                   shadow-md shadow-blue-600/30 hover:bg-blue-700">
                        Enregistrer
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>