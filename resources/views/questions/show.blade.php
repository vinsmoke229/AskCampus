<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Question Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-8">
                <!-- Question Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $question->title }}</h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span>Posée {{ $question->created_at->diffForHumans() }}</span>
                        <span>•</span>
                        <span>{{ $question->views }} vues</span>
                        @if($question->is_solved)
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Résolu
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex gap-6">
                    <!-- Vote Buttons -->
                    <div class="flex flex-col items-center space-y-2">
                        <form action="{{ route('vote') }}" method="POST">
                            @csrf
                            <input type="hidden" name="votable_type" value="App\Models\Question">
                            <input type="hidden" name="votable_id" value="{{ $question->id }}">
                            <input type="hidden" name="value" value="1">
                            <button type="submit" class="p-2 rounded-lg hover:bg-gray-100 transition">
                                <svg class="w-8 h-8 text-gray-600 hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </button>
                        </form>

                        <div class="text-2xl font-bold text-gray-700">
                            {{ $question->votes->sum('value') }}
                        </div>

                        <form action="{{ route('vote') }}" method="POST">
                            @csrf
                            <input type="hidden" name="votable_type" value="App\Models\Question">
                            <input type="hidden" name="votable_id" value="{{ $question->id }}">
                            <input type="hidden" name="value" value="-1">
                            <button type="submit" class="p-2 rounded-lg hover:bg-gray-100 transition">
                                <svg class="w-8 h-8 text-gray-600 hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Question Content -->
                    <div class="flex-1">
                        <div class="prose max-w-none text-gray-700 mb-6">
                            {{ $question->body }}
                        </div>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($question->tags as $tag)
                                <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" 
                                   class="px-3 py-1 bg-blue-50 text-blue-700 text-sm rounded-full hover:bg-blue-100 transition">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Author Info -->
                        <div class="flex justify-end">
                            <div class="bg-blue-50 rounded-lg p-4 w-64">
                                <div class="text-xs text-gray-600 mb-2">Posée par</div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ substr($question->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $question->user->name }}</div>
                                        <div class="text-sm text-gray-600">Réputation: {{ $question->user->reputation ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Answers Section -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                {{ $question->answers->count() }} {{ Str::plural('Réponse', $question->answers->count()) }}
            </h2>

            <div class="space-y-4">
                @foreach($question->answers as $answer)
                    <div class="bg-white rounded-lg shadow-sm border {{ $answer->is_accepted ? 'border-green-300 bg-green-50' : 'border-gray-200' }}">
                        <div class="p-6">
                            <div class="flex gap-6">
                                <!-- Vote Buttons -->
                                <div class="flex flex-col items-center space-y-2">
                                    <form action="{{ route('vote') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="votable_type" value="App\Models\Answer">
                                        <input type="hidden" name="votable_id" value="{{ $answer->id }}">
                                        <input type="hidden" name="value" value="1">
                                        <button type="submit" class="p-2 rounded-lg hover:bg-gray-100 transition">
                                            <svg class="w-8 h-8 text-gray-600 hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        </button>
                                    </form>

                                    <div class="text-2xl font-bold text-gray-700">
                                        {{ $answer->votes->sum('value') }}
                                    </div>

                                    <form action="{{ route('vote') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="votable_type" value="App\Models\Answer">
                                        <input type="hidden" name="votable_id" value="{{ $answer->id }}">
                                        <input type="hidden" name="value" value="-1">
                                        <button type="submit" class="p-2 rounded-lg hover:bg-gray-100 transition">
                                            <svg class="w-8 h-8 text-gray-600 hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </form>

                                    @if($question->user_id === auth()->id() && !$answer->is_accepted)
                                        <form action="{{ route('answers.accept', $answer) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-2 rounded-lg hover:bg-green-100 transition" title="Accepter cette réponse">
                                                <svg class="w-8 h-8 text-gray-400 hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    @if($answer->is_accepted)
                                        <div class="mt-2 p-2 bg-green-500 rounded-lg">
                                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Answer Content -->
                                <div class="flex-1">
                                    @if($answer->is_accepted)
                                        <div class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-sm font-semibold rounded-full mb-3">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Réponse acceptée
                                        </div>
                                    @endif

                                    <div class="prose max-w-none text-gray-700 mb-4">
                                        {{ $answer->body }}
                                    </div>

                                    <!-- Author Info -->
                                    <div class="flex justify-end">
                                        <div class="bg-gray-50 rounded-lg p-4 w-64">
                                            <div class="text-xs text-gray-600 mb-2">Répondu {{ $answer->created_at->diffForHumans() }}</div>
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                                    {{ substr($answer->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900">{{ $answer->user->name }}</div>
                                                    <div class="text-sm text-gray-600">Réputation: {{ $answer->user->reputation ?? 0 }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Answer Form -->
        @auth
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Votre réponse</h3>
                <form action="{{ route('answers.store', $question) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <textarea 
                            name="body" 
                            rows="6" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Écrivez votre réponse ici..."
                            required
                        ></textarea>
                        @error('body')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Publier votre réponse
                    </button>
                </form>
            </div>
        @else
            <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 text-center">
                <p class="text-gray-700">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Connectez-vous</a> 
                    ou 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">inscrivez-vous</a> 
                    pour répondre à cette question.
                </p>
            </div>
        @endauth
    </div>
</x-app-layout>
