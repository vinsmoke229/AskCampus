<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Poser une question</h1>

                    <form action="{{ route('questions.store') }}" method="POST">
                        @csrf

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                Titre de votre question
                            </label>
                            <input 
                                type="text" 
                                id="title"
                                name="title" 
                                value="{{ old('title') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Ex: Comment implémenter l'authentification JWT en Laravel ?"
                                required
                            >
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-600">
                                Soyez précis et imaginez que vous posez la question à une autre personne.
                            </p>
                        </div>

                        <!-- Body -->
                        <div class="mb-6">
                            <label for="body" class="block text-sm font-semibold text-gray-700 mb-2">
                                Détails de votre question
                            </label>
                            <textarea 
                                id="body"
                                name="body" 
                                rows="10"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Décrivez votre problème en détail. Incluez ce que vous avez déjà essayé et les messages d'erreur si applicable."
                                required
                            >{{ old('body') }}</textarea>
                            @error('body')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="mb-6">
                            <label for="tags" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tags (optionnel)
                            </label>
                            <select 
                                name="tags[]" 
                                id="tags"
                                multiple
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                @foreach(\App\Models\Tag::all() as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-600">
                                Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs tags.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('questions.index') }}" class="text-gray-600 hover:text-gray-900">
                                Annuler
                            </a>
                            <button 
                                type="submit" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm"
                            >
                                Publier la question
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-blue-50 rounded-lg border border-blue-200 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Conseils pour une bonne question
                    </h3>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                1
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-1">Titre clair</h4>
                                <p class="text-sm text-gray-700">Résumez votre problème en une phrase concise et descriptive.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                2
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-1">Contexte complet</h4>
                                <p class="text-sm text-gray-700">Expliquez ce que vous essayez de faire et pourquoi.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                3
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-1">Code et erreurs</h4>
                                <p class="text-sm text-gray-700">Incluez le code pertinent et les messages d'erreur complets.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                4
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-1">Tentatives</h4>
                                <p class="text-sm text-gray-700">Mentionnez ce que vous avez déjà essayé pour résoudre le problème.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                5
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-1">Tags appropriés</h4>
                                <p class="text-sm text-gray-700">Utilisez des tags pertinents pour aider les autres à trouver votre question.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-blue-200">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">💡 Astuce:</span> Une question bien formulée obtient généralement une réponse en moins de 30 minutes !
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
