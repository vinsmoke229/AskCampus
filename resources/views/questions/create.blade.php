<x-app-layout>
<style>
    .create-wrap  { display:flex; gap:20px; align-items:flex-start; }
    .create-form  { flex:1; min-width:0; }
    .create-aside { width:280px; flex-shrink:0; position:sticky; top:calc(52px + 24px); }

    .form-step {
        background:#fff; border:1px solid #e5e7eb; border-radius:12px;
        margin-bottom:14px; overflow:hidden;
        transition:box-shadow .15s, border-color .15s;
    }
    .form-step:focus-within {
        border-color:#5046e5;
        box-shadow:0 0 0 3px rgba(80,70,229,.1);
    }
    .form-step-head {
        display:flex; align-items:center; gap:8px;
        padding:12px 16px; background:#f9fafb;
        border-bottom:1px solid #e5e7eb;
        font-size:13px; font-weight:700; color:#374151;
    }
    .form-step-num {
        width:22px; height:22px; border-radius:50%;
        background:linear-gradient(135deg,#5046e5,#7c3aed);
        color:#fff; font-size:11px; font-weight:800;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0;
    }
    .form-step-body { padding:16px; }

    .form-label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px; }
    .form-hint  { font-size:12px; color:#9ca3af; margin-top:5px; }
    .form-error { font-size:12px; color:#dc2626; margin-top:5px; font-weight:600; }

    .form-input, .form-textarea, .form-select {
        display:block; width:100%; padding:10px 12px;
        font-size:13px; color:#111827;
        border:1.5px solid #e5e7eb; border-radius:9px;
        background:#fff; outline:none; box-sizing:border-box;
        transition:border-color .15s, box-shadow .15s;
        font-family:inherit;
    }
    .form-input:focus, .form-textarea:focus, .form-select:focus {
        border-color:#5046e5;
        box-shadow:0 0 0 3px rgba(80,70,229,.12);
    }
    .form-input::placeholder, .form-textarea::placeholder { color:#9ca3af; }
    .form-textarea { resize:vertical; line-height:1.6; }
    .form-select   { cursor:pointer; }

    /* Tag checkboxes */
    .tag-grid { display:flex; flex-wrap:wrap; gap:8px; }
    .tag-check { display:none; }
    .tag-check + label {
        display:inline-flex; align-items:center;
        padding:5px 12px; border-radius:20px;
        font-size:12px; font-weight:600; color:#5046e5;
        background:#eef2ff; border:1.5px solid #c7d2fe;
        cursor:pointer; transition:all .12s;
        user-select:none;
    }
    .tag-check + label:hover { background:#e0e7ff; }
    .tag-check:checked + label {
        background:#5046e5; color:#fff; border-color:#5046e5;
    }

    /* Similar questions alert */
    .similar-alert {
        background:#fffbeb; border:1.5px solid #fde68a; border-radius:10px;
        padding:12px 14px; margin-top:10px; display:none;
    }
    .similar-alert.visible { display:block; }
    .similar-alert h4 { font-size:13px; font-weight:700; color:#92400e; margin:0 0 6px; }
    .similar-alert li  { font-size:12px; color:#78350f; padding:3px 0; }
    .similar-alert a   { color:#1d4ed8; }
    .similar-alert a:hover { color:#1e40af; }

    /* Aside widgets */
    .aside-widget {
        background:#fff; border:1px solid #e5e7eb; border-radius:12px;
        margin-bottom:14px; overflow:hidden;
    }
    .aside-widget-head {
        display:flex; align-items:center; gap:7px;
        padding:11px 14px; background:#fefce8; border-bottom:1.5px solid #fde68a;
        font-size:12px; font-weight:700; color:#92400e;
    }
    .aside-widget-body { padding:14px; }
    .tip-item { display:flex; gap:10px; margin-bottom:12px; }
    .tip-item:last-child { margin-bottom:0; }
    .tip-num {
        width:20px; height:20px; border-radius:50%;
        background:#eef2ff; color:#5046e5; font-size:10px;
        font-weight:800; display:flex; align-items:center; justify-content:center;
        flex-shrink:0; margin-top:1px;
    }
    .tip-item p { font-size:12px; color:#374151; margin:0; line-height:1.5; }
    .tip-item strong { color:#1f2937; font-size:13px; display:block; margin-bottom:2px; }
    .rule-item { display:flex; align-items:flex-start; gap:7px; padding:5px 0; font-size:12px; color:#374151; }
    .rule-item svg { flex-shrink:0; margin-top:1px; }
</style>

<div class="create-wrap">

    {{-- ── Main Form ── --}}
    <div class="create-form">

        <div style="margin-bottom:20px;">
            <h1 style="font-size:22px;font-weight:800;color:#111827;margin:0 0 4px;">Poser une question</h1>
            <p style="font-size:13px;color:#9ca3af;margin:0;">
                Partagez votre problème avec la communauté AskCampus 🎓
            </p>
        </div>

        <form action="{{ route('questions.store') }}" method="POST">
            @csrf

            {{-- Step 1 – Title --}}
            <div class="form-step">
                <div class="form-step-head">
                    <span class="form-step-num">1</span>
                    Titre de votre question
                </div>
                <div class="form-step-body">
                    <label for="title" class="form-label">
                        Titre <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" id="title" name="title" class="form-input"
                           value="{{ old('title') }}"
                           placeholder="Ex : Comment implémenter l'authentification JWT en Laravel ?"
                           required autocomplete="off">
                    @error('title')
                        <p class="form-error">{{ $message }}</p>
                    @else
                        <p class="form-hint">Soyez précis et concis. Imaginez poser la question à un collègue.</p>
                    @enderror

                    {{-- Similar Questions --}}
                    <div id="similar-questions" class="similar-alert">
                        <h4>⚠️ Questions similaires trouvées</h4>
                        <p style="font-size:12px;color:#78350f;margin:0 0 6px;">Vérifiez si votre question n'a pas déjà une réponse :</p>
                        <ul id="similar-questions-list" style="margin:0;padding-left:16px;list-style:none;"></ul>
                    </div>
                </div>
            </div>

            {{-- Step 2 – Body --}}
            <div class="form-step">
                <div class="form-step-head">
                    <span class="form-step-num">2</span>
                    Détails de votre question
                </div>
                <div class="form-step-body">
                    <label for="body" class="form-label">
                        Description <span style="color:#dc2626;">*</span>
                    </label>
                    <textarea id="body" name="body" class="form-textarea" rows="12"
                              required
                              placeholder="Décrivez votre problème en détail…&#10;&#10;• Le contexte et ce que vous essayez d'accomplir&#10;• Ce que vous avez déjà essayé&#10;• Les messages d'erreur le cas échéant&#10;• Le code pertinent">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Step 3 – Tags --}}
            <div class="form-step">
                <div class="form-step-head">
                    <span class="form-step-num">3</span>
                    Tags
                    <span style="font-size:11px;font-weight:400;color:#9ca3af;">— facultatif, max 5</span>
                </div>
                <div class="form-step-body">
                    <div class="tag-grid">
                        @foreach(\App\Models\Tag::orderBy('name')->get() as $tag)
                            <div>
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                       id="tag_{{ $tag->id }}" class="tag-check"
                                       {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                <label for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('tags')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <a href="{{ route('questions.index') }}"
                   style="font-size:13px;color:#9ca3af;text-decoration:none;display:flex;align-items:center;gap:4px;"
                   onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#9ca3af'">
                    ← Annuler
                </a>
                <button type="submit"
                        style="display:inline-flex;align-items:center;gap:7px;padding:11px 22px;
                               font-size:14px;font-weight:700;color:#fff;border:none;border-radius:10px;
                               background:linear-gradient(135deg,#5046e5,#7c3aed);
                               box-shadow:0 4px 12px rgba(80,70,229,.35);cursor:pointer;line-height:1;"
                        onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                    <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Publier la question
                </button>
            </div>

        </form>
    </div>

    {{-- ── Right sidebar ── --}}
    <aside class="create-aside">

        {{-- Tips --}}
        <div class="aside-widget">
            <div class="aside-widget-head">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Comment poser une bonne question
            </div>
            <div class="aside-widget-body">
                <div class="tip-item">
                    <span class="tip-num">1</span>
                    <p><strong>Titre explicite</strong>Résumez votre problème en une phrase claire et précise</p>
                </div>
                <div class="tip-item">
                    <span class="tip-num">2</span>
                    <p><strong>Contexte complet</strong>Expliquez ce vous essayez d'accomplir et le contexte</p>
                </div>
                <div class="tip-item">
                    <span class="tip-num">3</span>
                    <p><strong>Code et erreurs</strong>Incluez le code pertinent et les messages d'erreur</p>
                </div>
                <div class="tip-item">
                    <span class="tip-num">4</span>
                    <p><strong>Vos tentatives</strong>Mentionnez ce que vous avez déjà essayé</p>
                </div>
            </div>
        </div>

        {{-- Rules --}}
        <div class="aside-widget">
            <div class="aside-widget-head" style="background:#f0fdf4;border-color:#bbf7d0;color:#166534;">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Règles de la communauté
            </div>
            <div class="aside-widget-body">
                <div class="rule-item">
                    <svg style="width:13px;height:13px;color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    Soyez respectueux et courtois
                </div>
                <div class="rule-item">
                    <svg style="width:13px;height:13px;color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    Vérifiez les doublons avant de poster
                </div>
                <div class="rule-item">
                    <svg style="width:13px;height:13px;color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    Acceptez la meilleure réponse reçue
                </div>
                <div class="rule-item">
                    <svg style="width:13px;height:13px;color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    Utilisez des tags pertinents
                </div>
            </div>
        </div>

    </aside>
</div>

{{-- Script détection doublons --}}
<script>
    const titleInput = document.getElementById('title');
    const similarDiv  = document.getElementById('similar-questions');
    const similarList = document.getElementById('similar-questions-list');
    let searchTimeout;

    titleInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const title = this.value.trim();

        searchTimeout = setTimeout(() => {
            if (title.length >= 10) {
                fetch(`{{ route('questions.similar') }}?title=${encodeURIComponent(title)}`)
                    .then(r => r.json())
                    .then(questions => {
                        if (questions.length > 0) {
                            similarList.innerHTML = questions.map(q => `
                                <li style="display:flex;align-items:flex-start;gap:6px;padding:4px 0;">
                                    <span style="flex-shrink:0;margin-top:2px;">${q.is_solved ? '✅' : '🔵'}</span>
                                    <a href="${q.url}" target="_blank"
                                       style="color:#1d4ed8;font-size:12px;line-height:1.4;"
                                       onmouseover="this.style.color='#1e40af'" onmouseout="this.style.color='#1d4ed8'">
                                        ${q.title}
                                    </a>
                                </li>
                            `).join('');
                            similarDiv.classList.add('visible');
                        } else {
                            similarDiv.classList.remove('visible');
                        }
                    })
                    .catch(() => similarDiv.classList.remove('visible'));
            } else {
                similarDiv.classList.remove('visible');
            }
        }, 500);
    });

    // Limit tag selection to 5
    document.querySelectorAll('.tag-check').forEach(cb => {
        cb.addEventListener('change', function() {
            const checked = document.querySelectorAll('.tag-check:checked');
            if (checked.length > 5) {
                this.checked = false;
            }
        });
    });
</script>
</x-app-layout>
