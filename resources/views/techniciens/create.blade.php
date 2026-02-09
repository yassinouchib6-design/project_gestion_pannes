<x-app-layout>
    <div class="py-10">
        <div class="max-w-xl mx-auto px-4">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Créer un technicien</h1>
                <p class="text-sm text-gray-500">Admin كيعطي login و password للتقني.</p>
            </div>

            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('techniciens.store') }}"
                  class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-4">
                @csrf

                <div>
                    <label class="text-sm font-semibold text-gray-700">Nom</label>
                    <input name="name" value="{{ old('name') }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                           required />
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                           required />
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Mot de passe</label>
                    <input type="password" name="password"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                           required />
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Confirmer mot de passe</label>
                    <input type="password" name="password_confirmation"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                           required />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('techniciens.index') }}"
                       class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                        ← Retour
                    </a>

                    <button type="submit"
                            class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        Enregistrer
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>