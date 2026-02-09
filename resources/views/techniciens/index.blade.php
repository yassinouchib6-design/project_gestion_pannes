<x-app-layout>
    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Techniciens</h1>
                    <p class="text-sm text-gray-500">Créer et gérer les comptes techniciens.</p>
                </div>

                <a href="{{ route('techniciens.create') }}"
                   class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    + Nouveau technicien
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr class="text-left">
                                <th class="py-3 px-6 font-semibold">Nom</th>
                                <th class="px-6 font-semibold">Email</th>
                                <th class="px-6 font-semibold">Role</th>
                                <th class="px-6 font-semibold text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($techniciens as $t)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-6 font-medium text-gray-900">
                                        {{ $t->user->name ?? $t->nom }}
                                    </td>
                                    <td class="px-6 text-gray-700">
                                        {{ $t->user->email ?? '-' }}
                                    </td>
                                    <td class="px-6">
                                        <span class="inline-flex rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">
                                            technicien
                                        </span>
                                    </td>
                                    <td class="px-6 text-right">
                                        <form method="POST" action="{{ route('techniciens.destroy', $t->id) }}"
                                              onsubmit="return confirm('Supprimer ce technicien ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-gray-500">
                                        Aucun technicien.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    {{ $techniciens->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>