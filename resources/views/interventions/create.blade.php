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

                    {{-- PANNE --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Panne <span class="text-red-500">*</span></label>
                        <select name="panne_id" class="w-full rounded-lg border-gray-300" required>
                            <option value="">-- Choisir une panne --</option>
                            @foreach($pannes as $p)
                                <option value="{{ $p->id }}"
                                    {{ (old('panne_id', $selectedPanneId ?? null) == $p->id) ? 'selected' : '' }}>
                                    #{{ $p->id }} — {{ $p->titre }} ({{ $p->equipement->serie_equipement ?? '—' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TECHNICIEN (admin فقط) --}}
                    @if(($role ?? '') === 'admin')
<div class="md:col-span-2">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Technicien <span class="text-red-500">*</span>
    </label>

    <select name="technicien_id" class="w-full rounded-lg border-gray-300" required>
        <option value="">-- Choisir un technicien --</option>

        @foreach($techniciens as $t)
            <option value="{{ $t->id }}" @selected(old('technicien_id')==$t->id)>
                {{ $t->user->name ?? ($t->nom.' '.$t->prenom) }}
                @if($t->user?->email) ({{ $t->user->email }}) @endif
            </option>
        @endforeach
    </select>
</div>
@endif

                    {{-- DATES --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                        <input type="date" name="date_debut" value="{{ old('date_debut') }}"
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                        <input type="date" name="date_fin" value="{{ old('date_fin') }}"
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    {{-- STATUT --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut <span class="text-red-500">*</span></label>
                        <select name="statut" class="w-full rounded-lg border-gray-300" required>
                            <option value="planifiee" @selected(old('statut','planifiee')==='planifiee')>Planifiée</option>
                            <option value="en_cours"   @selected(old('statut')==='en_cours')>En cours</option>
                            <option value="terminee"   @selected(old('statut')==='terminee')>Terminée</option>
                        </select>
                    </div>

                    {{-- RAPPORT --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rapport d'intervention</label>
                        <textarea name="rapport_intervention" rows="5"
                                  class="w-full rounded-lg border-gray-300"
                                  placeholder="Décrivez l'intervention...">{{ old('rapport_intervention') }}</textarea>
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