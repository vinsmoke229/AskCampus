<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-2xl font-extrabold text-center text-gray-900 mb-2">Bon retour ! 👋</h2>
    <p class="text-sm font-medium text-center text-gray-500 mb-8">Connectez-vous à votre compte AskCampus</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Adresse email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}" required autofocus
                   placeholder="vous@exemple.com"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-gray-50 hover:bg-white text-gray-900 shadow-sm placeholder:text-gray-400">
            @error('email')
                <p class="text-red-500 text-xs font-bold mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-bold text-gray-700">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 hover:underline transition-colors">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   placeholder="••••••••"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-gray-50 hover:bg-white text-gray-900 shadow-sm placeholder:text-gray-400">
            @error('password')
                <p class="text-red-500 text-xs font-bold mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition-colors cursor-pointer">
            <label for="remember_me" class="ml-2 text-sm font-medium text-gray-600 cursor-pointer select-none">
                Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
            Se connecter
        </button>
    </form>

    <div class="text-center text-sm font-medium text-gray-500 mt-8">
        Pas encore inscrit ?
        <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:text-indigo-800 hover:underline transition-colors ml-1">Créer un compte</a>
    </div>
</x-guest-layout>
