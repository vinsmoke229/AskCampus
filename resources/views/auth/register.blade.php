<x-guest-layout>
    <h2>Rejoignez AskCampus 🎓</h2>
    <p class="auth-sub">Créez votre compte et commencez à apprendre avec la communauté</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="field">
            <label for="name">Nom complet</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name') }}" required autofocus
                   placeholder="Prénom Nom">
            @error('name')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="email">Adresse email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}" required
                   placeholder="vous@universite.com">
            @error('email')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="campus">Université / Campus <span style="font-size:12px; font-weight:normal; color:#6a737c;">(Optionnel)</span></label>
            <input id="campus" type="text" name="campus"
                   value="{{ old('campus') }}"
                   placeholder="Ex: EPITECH, Sorbonne, AskCampus Univ...">
            @error('campus')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password"
                   required autocomplete="new-password"
                   placeholder="Minimum 8 caractères">
            @error('password')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password"
                   name="password_confirmation" required
                   autocomplete="new-password"
                   placeholder="Répétez votre mot de passe">
            @error('password_confirmation')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-submit">
            Créer mon compte
        </button>
    </form>

    <div class="auth-footer">
        Déjà inscrit ?
        <a href="{{ route('login') }}">Se connecter</a>
    </div>
</x-guest-layout>
