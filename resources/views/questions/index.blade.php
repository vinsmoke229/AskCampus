<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Toutes les questions</h1>
                <p class="text-gray-600 mt-1">{{ $questions->total() }} questions</p>
            </div>
            <a href="{{ route('questions.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                Poser une question
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('questions.index') }}" class="px-4 py-2 rounded-lg {{ !request('tag') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition">
                    Toutes
                </a>
                <a href="{{ route('questions.index', ['filter' => 'unsolved']) }}" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Non résolues
                </a>
                <a href="{{ route('questions.index', ['filter' => 'solved']) }}" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Résolues
                </a>
            </div>
        </div>

        <!-- Questions List -->
        <div class="space-y-4">
            @forelse($questions as $question)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex gap-6">
                            <!-- Stats Sidebar -->
                            <div class="flex flex-col items-center space-y-4 text-center min-w-[80px]">
                                <div>
                                    <div class="text-2xl font-bold text-gray-700">
                                        {{ $question->votes->sum('value') }}
                                    </div>
                                    <div class="text-xs text-gray-500">votes</div>
                                </div>
                                <div class="{{ $question->is_solved ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }} px-3 py-1 rounded-lg">
                                    <div class="text-xl font-bold">
                                        {{ $question->answers->count() }}
                                    </div>
                                    <div class="text-xs">réponses</div>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-gray-600">
                                        {{ $question->views }}
                                    </div>
                                    <div class="text-xs text-gray-500">vues</div>
                                </div>
                            </div>

                            <!-- Question Content -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <a href="{{ route('questions.show', $question) }}" class="text-xl font-semibold text-blue-600 hover:text-blue-800 transition">
                                            {{ $question->title }}
                                        </a>
                                        
                                        @if($question->is_solved)
                                            <span class="ml-2 inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Résolu
                                            </span>
                                        @endif

                                        <p class="text-gray-600 mt-2 line-clamp-2">
                                            {{ Str::limit(strip_tags($question->body), 200) }}
                                        </p>

                                        <!-- Tags -->
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            @foreach($question->tags as $tag)
                                                <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" 
                                                   class="px-3 py-1 bg-blue-50 text-blue-700 text-sm rounded-full hover:bg-blue-100 transition">
                                                    {{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Author Info -->
                                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                        <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                            {{ substr($question->user->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium">{{ $question->user->name }}</span>
                                        <span class="text-gray-400">•</span>
                                        <span>{{ $question->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Aucune question trouvée</h3>
                    <p class="mt-2 text-gray-600">Soyez le premier à poser une question !</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $questions->links() }}
        </div>
    </div>
</x-app-layout>
