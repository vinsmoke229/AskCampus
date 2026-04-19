<x-guest-layout>
    <h2 class="text-2xl font-extrabold text-center text-gray-900 mb-2">Rejoignez AskCampus 🎓</h2>
    <p class="text-sm font-medium text-center text-gray-500 mb-8">Créez votre compte et commencez à apprendre avec la communauté</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nom complet</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="Prénom Nom"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-gray-50 hover:bg-white text-gray-900 shadow-sm placeholder:text-gray-400">
            @error('name')
                <p class="text-red-500 text-xs font-bold mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Adresse email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}" required autocomplete="username"
                   placeholder="vous@universite.com"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-gray-50 hover:bg-white text-gray-900 shadow-sm placeholder:text-gray-400">
            @error('email')
                <p class="text-red-500 text-xs font-bold mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Mot de passe</label>
            <input id="password" type="password" name="password"
                   required autocomplete="new-password"
                   placeholder="Minimum 8 caractères"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-gray-50 hover:bg-white text-gray-900 shadow-sm placeholder:text-gray-400">
            @error('password')
                <p class="text-red-500 text-xs font-bold mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password"
                   name="password_confirmation" required autocomplete="new-password"
                   placeholder="Répétez votre mot de passe"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-gray-50 hover:bg-white text-gray-900 shadow-sm placeholder:text-gray-400">
            @error('password_confirmation')
                <p class="text-red-500 text-xs font-bold mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 mt-2">
            Créer mon compte
        </button>
    </form>

    <div class="text-center text-sm font-medium text-gray-500 mt-8">
        Déjà inscrit ?
        <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:text-indigo-800 hover:underline transition-colors ml-1">Se connecter</a>
    </div>
</x-guest-layout>
