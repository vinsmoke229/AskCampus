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

                        <!-- Similar Questions Alert (Anti-doublon) -->
                        <div id="similar-questions" class="hidden mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-yellow-800 mb-2">
                                        Questions similaires trouvées
                                    </h3>
                                    <p class="text-sm text-yellow-700 mb-3">
                                        Avant de poster, vérifiez si votre question n'a pas déjà été posée :
                                    </p>
                                    <ul id="similar-questions-list" class="space-y-2"></ul>
                                </div>
                            </div>
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

    <!-- Script pour la détection de doublons -->
    <script>
        const titleInput = document.getElementById('title');
        const similarQuestionsDiv = document.getElementById('similar-questions');
        const similarQuestionsList = document.getElementById('similar-questions-list');
        let searchTimeout;

        // Recherche de questions similaires lors de la saisie du titre
        titleInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const title = this.value;

            // Attendre que l'utilisateur arrête de taper
            searchTimeout = setTimeout(() => {
                if (title.length >= 10) {
                    fetch(`{{ route('questions.similar') }}?title=${encodeURIComponent(title)}`)
                        .then(response => response.json())
                        .then(questions => {
                            if (questions.length > 0) {
                                // Afficher les questions similaires
                                similarQuestionsList.innerHTML = questions.map(q => `
                                    <li class="text-sm">
                                        <a href="${q.url}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                            ${q.is_solved ? '<svg class="w-4 h-4 text-green-600 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>' : ''}
                                            ${q.title}
                                        </a>
                                    </li>
                                `).join('');
                                similarQuestionsDiv.classList.remove('hidden');
                            } else {
                                similarQuestionsDiv.classList.add('hidden');
                            }
                        });
                } else {
                    similarQuestionsDiv.classList.add('hidden');
                }
            }, 500); // Attendre 500ms après la dernière frappe
        });
    </script>
</x-app-layout>
