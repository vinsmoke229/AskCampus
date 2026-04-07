<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Bienvenue, {{ auth()->user()->name }} !</h1>
            <p class="text-gray-600 mt-1">Voici un aperçu de votre activité sur AskCampus</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Reputation Card -->
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg shadow-lg p-8 text-white mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-semibold opacity-90">Score de réputation</h2>
                            <div class="flex items-baseline mt-2">
                                <span class="text-5xl font-bold">{{ auth()->user()->reputation ?? 0 }}</span>
                                <span class="ml-2 text-xl opacity-75">points</span>
                            </div>
                        </div>
                        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    @php
                        $currentRep = auth()->user()->reputation ?? 0;
                        $nextLevel = ceil(($currentRep + 1) / 100) * 100;
                        $previousLevel = floor($currentRep / 100) * 100;
                        $progress = $nextLevel > $previousLevel ? (($currentRep - $previousLevel) / ($nextLevel - $previousLevel)) * 100 : 0;
                    @endphp

                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span>Niveau actuel</span>
                            <span>Prochain niveau: {{ $nextLevel }} points</span>
                        </div>
                        <div class="w-full bg-white bg-opacity-20 rounded-full h-3">
                            <div class="bg-white rounded-full h-3 transition-all duration-500" style="width: {{ $progress }}%"></div>
                        </div>
                        <p class="text-sm mt-2 opacity-90">
                            Plus que {{ $nextLevel - $currentRep }} points pour atteindre le niveau suivant !
                        </p>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Questions posées</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ auth()->user()->questions->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Réponses données</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ auth()->user()->answers->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Réponses acceptées</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ auth()->user()->answers->where('is_accepted', true)->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Questions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Vos questions récentes</h3>
                    <div class="space-y-3">
                        @forelse(auth()->user()->questions()->latest()->take(5)->get() as $question)
                            <a href="{{ route('questions.show', $question) }}" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $question->title }}</h4>
                                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                                            <span>{{ $question->answers->count() }} réponses</span>
                                            <span>{{ $question->views }} vues</span>
                                            <span>{{ $question->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    @if($question->is_solved)
                                        <span class="ml-4 px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">
                                            Résolu
                                        </span>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-600 text-center py-8">Vous n'avez pas encore posé de question.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Achievements -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Badges & Réalisations</h3>
                    <div class="space-y-3">
                        @if((auth()->user()->reputation ?? 0) >= 100)
                            <div class="flex items-center space-x-3 p-3 bg-yellow-50 rounded-lg">
                                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Contributeur</p>
                                    <p class="text-xs text-gray-600">100+ points de réputation</p>
                                </div>
                            </div>
                        @endif

                        @if(auth()->user()->questions->count() >= 5)
                            <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                                <div class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Curieux</p>
                                    <p class="text-xs text-gray-600">5+ questions posées</p>
                                </div>
                            </div>
                        @endif

                        @if(auth()->user()->answers->where('is_accepted', true)->count() >= 1)
                            <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg">
                                <div class="w-10 h-10 bg-green-400 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Résolveur</p>
                                    <p class="text-xs text-gray-600">Première réponse acceptée</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Actions rapides</h3>
                    <div class="space-y-2">
                        <a href="{{ route('questions.create') }}" class="block w-full px-4 py-3 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition font-medium">
                            Poser une question
                        </a>
                        <a href="{{ route('questions.index') }}" class="block w-full px-4 py-3 bg-gray-100 text-gray-700 text-center rounded-lg hover:bg-gray-200 transition font-medium">
                            Parcourir les questions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
