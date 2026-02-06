<x-app-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4">

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Modifier la panne</h1>
                    <p class="text-sm text-gray-500 mt-1">Mettez à jour les informations puis enregistrez.</p>
                </div>

                <a href="{{ route('pannes.show', $panne->id) }}"
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

            <form method="POST" action="{{ route('pannes.update', $panne->id) }}"
                  class="bg-white rounded-2xl shadow-md border border-gray-100">
                @csrf
                @method('PUT')

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Équipement <span class="text-red-500">*</span>
                        </label>
                        <select name="equipement_id" required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @foreach($equipements as $e)
                                <option value="{{ $e->id }}" @selected(old('equipement_id', $panne->equipement_id)==$e->id)>
                                    {{ $e->serie_equipement ?? ('Équipement #' . $e->id) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Titre <span class="text-red-500">*</span>
                        </label>
                        <input name="titre" required
                               value="{{ old('titre', $panne->titre) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('description', $panne->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de la panne</label>
                        <input type="date" name="date_panne"
                               value="{{ old('date_panne', $panne->date_panne) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact</label>
                        <input name="contact"
                               value="{{ old('contact', $panne->contact) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Priorité <span class="text-red-500">*</span>
                        </label>
                        <select name="priorite" required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="low" @selected(old('priorite', $panne->priorite)=='low')>Faible</option>
                            <option value="medium" @selected(old('priorite', $panne->priorite)=='medium')>Moyenne</option>
                            <option value="high" @selected(old('priorite', $panne->priorite)=='high')>Élevée</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type de panne</label>
                        <input name="type_panne"
                               value="{{ old('type_panne', $panne->type_panne) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 border-t bg-gray-50 px-6 py-4 rounded-b-2xl">
                    <a href="{{ route('pannes.show', $panne->id) }}"
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