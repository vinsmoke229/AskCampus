<x-guest-layout>
    <x-auth-session-status class="alert-info" :status="session('status')" />

    <h2>Bon retour ! 👋</h2>
    <p class="auth-sub">Connectez-vous à votre compte AskCampus</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <label for="email">Adresse email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}" required autofocus
                   placeholder="vous@exemple.com">
            @error('email')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="password">
                Mot de passe
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                @endif
            </label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   placeholder="••••••••">
            @error('password')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="check-row">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Se souvenir de moi</label>
        </div>

        <button type="submit" class="btn-submit">
            Se connecter
        </button>
    </form>

    <div class="auth-footer">
        Pas encore inscrit ?
        <a href="{{ route('register') }}">Créer un compte</a>
    </div>
</x-guest-layout>
