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

    /* Barre d'outils d'édition */
    .editor-tab {
        padding: 10px 16px; font-size: 13px; font-weight: 600;
        background: #f8f9fa; color: #6a737c; border: none;
        border-bottom: 2px solid transparent; cursor: pointer;
        transition: all .15s;
    }
    .editor-tab:hover {
        background: #e3e6e8; color: #232629;
    }
    .editor-tab.active {
        background: #fff; color: #0074cc;
        border-bottom-color: #0074cc;
    }
    
    .editor-toolbar {
        display: flex; align-items: center; gap: 4px; flex-wrap: wrap;
        padding: 8px 10px; background: #f8f9fa; border: 1px solid #d6d9dc;
        border-radius: 9px 9px 0 0; margin-bottom: -1px;
    }
    .toolbar-group {
        display: flex; align-items: center; gap: 2px;
    }
    .toolbar-separator {
        width: 1px; height: 20px; background: #d6d9dc; margin: 0 4px;
    }
    .toolbar-btn {
        display: flex; align-items: center; justify-content: center;
        width: 28px; height: 28px; padding: 0; border: none;
        background: transparent; color: #6a737c; border-radius: 5px;
        cursor: pointer; transition: all .1s;
    }
    .toolbar-btn:hover {
        background: #e3e6e8; color: #232629;
    }
    .toolbar-btn:active {
        background: #d6d9dc;
    }
    .toolbar-btn svg {
        pointer-events: none;
    }
    
    .editor-textarea {
        border-radius: 0 0 9px 9px !important;
        border-top: none !important;
        font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
    }
    
    /* Styles pour la prévisualisation Markdown */
    #preview-content h1, #preview-content h2, #preview-content h3 {
        font-weight: 600; color: #232629; margin: 16px 0 8px;
    }
    #preview-content h1 { font-size: 24px; }
    #preview-content h2 { font-size: 20px; }
    #preview-content h3 { font-size: 17px; }
    #preview-content p { margin: 8px 0; }
    #preview-content strong { font-weight: 700; color: #232629; }
    #preview-content em { font-style: italic; }
    #preview-content code {
        padding: 2px 6px; background: #f6f6f6; border: 1px solid #e3e6e8;
        border-radius: 3px; font-family: 'Consolas', 'Monaco', monospace;
        font-size: 13px; color: #c7254e;
    }
    #preview-content pre {
        background: #f6f6f6; border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 12px; overflow-x: auto; margin: 12px 0;
    }
    #preview-content pre code {
        background: none; border: none; padding: 0; color: #232629;
    }
    #preview-content ul, #preview-content ol {
        margin: 8px 0; padding-left: 24px;
    }
    #preview-content li { margin: 4px 0; }
    #preview-content blockquote {
        border-left: 4px solid #e3e6e8; padding-left: 12px;
        margin: 12px 0; color: #6a737c; font-style: italic;
    }
    #preview-content a {
        color: #0074cc; text-decoration: none;
    }
    #preview-content a:hover { color: #0a95ff; }
    #preview-content table {
        border-collapse: collapse; width: 100%; margin: 12px 0;
    }
    #preview-content table th, #preview-content table td {
        border: 1px solid #e3e6e8; padding: 8px 12px; text-align: left;
    }
    #preview-content table th {
        background: #f8f9fa; font-weight: 600;
    }

    /* Tag badges selection */
    .tag-grid { display: flex; flex-wrap: wrap; gap: 10px; }
    .tag-selectable { position: relative; }
    .tag-selectable input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0; width: 0;
    }
    .tag-badge {
        display: inline-flex; align-items: center;
        padding: 6px 14px; border-radius: 20px;
        font-size: 13px; font-weight: 600; color: #5046e5;
        background: #f0f2ff; border: 1.5px solid #c7d2fe;
        cursor: pointer; transition: all .2s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }
    .tag-badge:hover {
        background: #e0e7ff;
        border-color: #5046e5;
        transform: translateY(-1px);
    }
    .tag-selectable input:checked + .tag-badge {
        background: #5046e5 !important;
        color: #fff !important;
        border-color: #5046e5 !important;
        box-shadow: 0 4px 12px rgba(80, 70, 229, 0.3);
        transform: translateY(-1px);
    }
    .tag-selectable input:focus + .tag-badge {
        box-shadow: 0 0 0 3px rgba(80, 70, 229, 0.2);
    }

    /* Tag checkboxes */
    .tag-grid { display:flex; flex-wrap:wrap; gap:8px; }
    .tag-check { display:none; }
    .tag-badge {
        display:inline-flex; align-items:center; gap:6px;
        padding:6px 12px; border-radius:20px;
        font-size:12px; font-weight:600; color:#39739d;
        background:#e1ecf4; border:1px solid #a0c7e4;
        cursor:pointer; transition:all .15s;
        user-select:none;
    }
    .tag-badge:hover { 
        background:#d0e3f1;
    }
    .tag-badge .remove-tag {
        display:inline-flex; align-items:center; justify-content:center;
        width:16px; height:16px; border-radius:50%;
        background:rgba(0,0,0,.1); color:#39739d;
        font-size:14px; line-height:1; font-weight:700;
        transition:all .15s;
    }
    .tag-badge .remove-tag:hover {
        background:rgba(0,0,0,.2);
    }
    
    .tag-suggestion {
        padding:10px 12px; cursor:pointer;
        border-bottom:1px solid #e3e6e8;
        transition:background .1s;
    }
    .tag-suggestion:last-child { border-bottom:none; }
    .tag-suggestion:hover { background:#f8f9fa; }
    .tag-suggestion-name {
        font-size:13px; font-weight:600; color:#0074cc;
        margin-bottom:2px;
    }
    .tag-suggestion-desc {
        font-size:12px; color:#6a737c;
        overflow:hidden; text-overflow:ellipsis;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;
    }
    .tag-suggestion-count {
        font-size:11px; color:#9ca3af; margin-top:2px;
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
                    <p class="form-hint" style="margin-bottom:8px;">
                        Incluez toutes les informations nécessaires pour répondre à votre question. Min 220 caractères.
                    </p>
                    
                    {{-- Onglets Écrire / Aperçu --}}
                    <div style="display:flex;gap:0;border-bottom:1px solid #d6d9dc;margin-bottom:0;">
                        <button type="button" id="tab-write" class="editor-tab active" onclick="switchTab('write')">
                            Écrire
                        </button>
                        <button type="button" id="tab-preview" class="editor-tab" onclick="switchTab('preview')">
                            Aperçu
                        </button>
                    </div>
                    
                    {{-- Barre d'outils d'édition --}}
                    <div class="editor-toolbar" id="toolbar">
                        <div class="toolbar-group">
                            <button type="button" class="toolbar-btn" data-action="bold" title="Gras (Ctrl+B)">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M15.6 10.79c.97-.67 1.65-1.77 1.65-2.79 0-2.26-1.75-4-4-4H7v14h7.04c2.09 0 3.71-1.7 3.71-3.79 0-1.52-.86-2.82-2.15-3.42zM10 6.5h3c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-3v-3zm3.5 9H10v-3h3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="toolbar-btn" data-action="italic" title="Italique (Ctrl+I)">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M10 4v3h2.21l-3.42 8H6v3h8v-3h-2.21l3.42-8H18V4z"/>
                                </svg>
                            </button>
                            <button type="button" class="toolbar-btn" data-action="strikethrough" title="Barré">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M10 19h4v-3h-4v3zM5 4v3h5v3h4V7h5V4H5zM3 14h18v-2H3v2z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="toolbar-separator"></div>
                        
                        <div class="toolbar-group">
                            <button type="button" class="toolbar-btn" data-action="code" title="Code inline (Ctrl+K)">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0l4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/>
                                </svg>
                            </button>
                            <button type="button" class="toolbar-btn" data-action="codeblock" title="Bloc de code">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="toolbar-separator"></div>
                        
                        <div class="toolbar-group">
                            <button type="button" class="toolbar-btn" data-action="link" title="Lien (Ctrl+L)">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/>
                                </svg>
                            </button>
                            <button type="button" class="toolbar-btn" data-action="image" title="Image">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="toolbar-separator"></div>
                        
                        <div class="toolbar-group">
                            <button type="button" class="toolbar-btn" data-action="ul" title="Liste à puces">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4 10.5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5 1.5-.67 1.5-1.5-.67-1.5-1.5-1.5zm0-6c-.83 0-1.5.67-1.5 1.5S3.17 7.5 4 7.5 5.5 6.83 5.5 6 4.83 4.5 4 4.5zm0 12c-.83 0-1.5.68-1.5 1.5s.68 1.5 1.5 1.5 1.5-.68 1.5-1.5-.67-1.5-1.5-1.5zM7 19h14v-2H7v2zm0-6h14v-2H7v2zm0-8v2h14V5H7z"/>
                                </svg>
                            </button>
                            <button type="button" class="toolbar-btn" data-action="ol" title="Liste numérotée">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2 17h2v.5H3v1h1v.5H2v1h3v-4H2v1zm1-9h1V4H2v1h1v3zm-1 3h1.8L2 13.1v.9h3v-1H3.2L5 10.9V10H2v1zm5-6v2h14V5H7zm0 14h14v-2H7v2zm0-6h14v-2H7v2z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="toolbar-separator"></div>
                        
                        <div class="toolbar-group">
                            <button type="button" class="toolbar-btn" data-action="quote" title="Citation">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
                                </svg>
                            </button>
                            <button type="button" class="toolbar-btn" data-action="table" title="Tableau">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M10 10.02h5V21h-5zM17 21h3c1.1 0 2-.9 2-2v-9h-5v11zm3-18H5c-1.1 0-2 .9-2 2v3h19V5c0-1.1-.9-2-2-2zM3 19c0 1.1.9 2 2 2h3V10.02H3V19z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="toolbar-separator"></div>
                        
                        <div class="toolbar-group">
                            <button type="button" class="toolbar-btn" data-action="more" title="Plus d'options">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                </svg>
                            </button>
                            <button type="button" class="toolbar-btn" data-action="help" title="Aide Markdown">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11 18h2v-2h-2v2zm1-16C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-2.21 0-4 1.79-4 4h2c0-1.1.9-2 2-2s2 .9 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    {{-- Zone d'édition --}}
                    <div id="write-area">
                        <textarea id="body" name="body" class="form-textarea editor-textarea" rows="12"
                                  required
                                  placeholder="Décrivez votre problème en détail…&#10;&#10;• Le contexte et ce que vous essayez d'accomplir&#10;• Ce que vous avez déjà essayé&#10;• Les messages d'erreur le cas échéant&#10;• Le code pertinent">{{ old('body') }}</textarea>
                    </div>
                    
                    {{-- Zone de prévisualisation --}}
                    <div id="preview-area" style="display:none;min-height:300px;padding:16px;background:#fff;border:1.5px solid #e5e7eb;border-radius:0 0 9px 9px;border-top:none;">
                        <div id="preview-content" style="font-size:15px;line-height:1.6;color:#232629;">
                            <p style="color:#9ca3af;font-style:italic;">Rien à prévisualiser pour le moment...</p>
                        </div>
                    </div>
                    
                    @error('body')
                        <p class="form-error">{{ $message }}</p>
                    @else
                        <p class="form-hint">
                            <span id="char-count">0</span> caractères (minimum 220)
                        </p>
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
                    <p class="form-hint" style="margin-bottom:8px;">
                        Ajoutez jusqu'à 5 tags pour décrire votre question. Commencez à taper pour voir les suggestions.
                    </p>
                    
                    {{-- Champ de saisie de tags --}}
                    <div style="position:relative;">
                        <input type="text" id="tag-input" class="form-input" 
                               placeholder="Ex: laravel, php, javascript..."
                               autocomplete="off"
                               style="padding-right:40px;">
                        <svg style="position:absolute;right:12px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:#9ca3af;pointer-events:none;" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        
                        {{-- Liste de suggestions --}}
                        <div id="tag-suggestions" style="display:none;position:absolute;top:100%;left:0;right:0;
                                                          background:#fff;border:1px solid #d6d9dc;border-top:none;
                                                          border-radius:0 0 9px 9px;max-height:300px;overflow-y:auto;
                                                          box-shadow:0 4px 12px rgba(0,0,0,.1);z-index:10;">
                        </div>
                    </div>
                    
                    {{-- Tags sélectionnés --}}
                    <div id="selected-tags" style="display:flex;flex-wrap:wrap;gap:8px;margin-top:12px;min-height:32px;">
                    </div>
                    
                    <p class="form-hint" style="margin-top:8px;">
                        <span id="tag-count">0</span> tag(s) sélectionné(s)
                    </p>
                    
                    {{-- Champs cachés pour soumettre les tags --}}
                    <div id="tag-hidden-inputs"></div>
                    
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
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const similarDiv  = document.getElementById('similar-questions');
    const similarList = document.getElementById('similar-questions-list');
    const bodyTextarea = document.querySelector('textarea[name="body"]');
    const charCount = document.getElementById('char-count');
    const writeArea = document.getElementById('write-area');
    const previewArea = document.getElementById('preview-area');
    const previewContent = document.getElementById('preview-content');
    const toolbar = document.getElementById('toolbar');
    let searchTimeout;
    
    // Rendre la fonction globale pour le inline onclick="switchTab(...)"
    window.switchTab = function(tab) {
        const tabWrite = document.getElementById('tab-write');
        const tabPreview = document.getElementById('tab-preview');
        
        if (tab === 'write') {
            if(tabWrite) tabWrite.classList.add('active');
            if(tabPreview) tabPreview.classList.remove('active');
            if(writeArea) writeArea.style.display = 'block';
            if(previewArea) previewArea.style.display = 'none';
            if(toolbar) toolbar.style.display = 'flex';
        } else {
            if(tabWrite) tabWrite.classList.remove('active');
            if(tabPreview) tabPreview.classList.add('active');
            if(writeArea) writeArea.style.display = 'none';
            if(previewArea) previewArea.style.display = 'block';
            if(toolbar) toolbar.style.display = 'none';
            updatePreview();
        }
    };

    function markdownToHtml(markdown) {
        if (!markdown || markdown.trim() === '') {
            return '<p style="color:#9ca3af;font-style:italic;">Rien à prévisualiser pour le moment...</p>';
        }
        let html = markdown;
        html = html.replace(/```([^`]+)```/g, '<pre><code>$1</code></pre>');
        html = html.replace(/\*\*([^\*]+)\*\*/g, '<strong>$1</strong>');
        html = html.replace(/\*([^\*]+)\*/g, '<em>$1</em>');
        html = html.replace(/~~([^~]+)~~/g, '<del>$1</del>');
        html = html.replace(/`([^`]+)`/g, '<code>$1</code>');
        html = html.replace(/\[([^\]]+)\]\(([^\)]+)\)/g, '<a href="$2" target="_blank">$1</a>');
        html = html.replace(/^### (.+)$/gm, '<h3>$1</h3>');
        html = html.replace(/^## (.+)$/gm, '<h2>$1</h2>');
        html = html.replace(/^# (.+)$/gm, '<h1>$1</h1>');
        html = html.replace(/^> (.+)$/gm, '<blockquote>$1</blockquote>');
        html = html.replace(/^\- (.+)$/gm, '<li>$1</li>');
        html = html.replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');
        html = html.replace(/^\d+\. (.+)$/gm, '<li>$1</li>');
        html = html.split('\n\n').map(para => {
            if (!para.match(/^<(h[1-3]|ul|ol|blockquote|pre)/)) {
                return '<p>' + para.replace(/\n/g, '<br>') + '</p>';
            }
            return para;
        }).join('');
        return html;
    }

    function updatePreview() {
        if(!bodyTextarea || !previewContent) return;
        const markdown = bodyTextarea.value;
        previewContent.innerHTML = markdownToHtml(markdown);
    }

    if (titleInput && similarDiv && similarList) {
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
                                           style="color:#1d4ed8;font-size:12px;line-height:1.4;">
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
    }

    if (bodyTextarea) {
        bodyTextarea.addEventListener('input', function() {
            if(!charCount) return;
            const count = this.value.length;
            charCount.textContent = count;
            if (count < 220) {
                charCount.style.color = '#dc2626';
            } else {
                charCount.style.color = '#059669';
            }
        });
        bodyTextarea.dispatchEvent(new Event('input'));
    }

    document.querySelectorAll('.toolbar-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if(!bodyTextarea) return;
            const action = this.dataset.action;
            const textarea = bodyTextarea;
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            const beforeText = textarea.value.substring(0, start);
            const afterText = textarea.value.substring(end);
            
            let newText = '';
            let cursorOffset = 0;
            
            switch(action) {
                case 'bold':
                    newText = `**${selectedText || 'texte en gras'}**`;
                    cursorOffset = selectedText ? newText.length : 2;
                    break;
                case 'italic':
                    newText = `*${selectedText || 'texte en italique'}*`;
                    cursorOffset = selectedText ? newText.length : 1;
                    break;
                case 'strikethrough':
                    newText = `~~${selectedText || 'texte barré'}~~`;
                    cursorOffset = selectedText ? newText.length : 2;
                    break;
                case 'code':
                    newText = `\`${selectedText || 'code'}\``;
                    cursorOffset = selectedText ? newText.length : 1;
                    break;
                case 'codeblock':
                    newText = `\`\`\`\n${selectedText || 'votre code ici'}\n\`\`\``;
                    cursorOffset = selectedText ? newText.length : 4;
                    break;
                case 'link':
                    const url = prompt('URL du lien:', 'https://');
                    if (url) {
                        newText = `[${selectedText || 'texte du lien'}](${url})`;
                        cursorOffset = newText.length;
                    } else return;
                    break;
                case 'image':
                    const imgUrl = prompt('URL de l\'image:', 'https://');
                    if (imgUrl) {
                        newText = `![${selectedText || 'description'}](${imgUrl})`;
                        cursorOffset = newText.length;
                    } else return;
                    break;
                case 'ul':
                    if (selectedText) {
                        newText = selectedText.split('\n').map(line => `- ${line}`).join('\n');
                    } else newText = '- Élément 1\n- Élément 2\n- Élément 3';
                    cursorOffset = newText.length;
                    break;
                case 'ol':
                    if (selectedText) {
                        newText = selectedText.split('\n').map((line, i) => `${i+1}. ${line}`).join('\n');
                    } else newText = '1. Premier élément\n2. Deuxième élément\n3. Troisième élément';
                    cursorOffset = newText.length;
                    break;
                case 'quote':
                    if (selectedText) {
                        newText = selectedText.split('\n').map(line => `> ${line}`).join('\n');
                    } else newText = '> Citation';
                    cursorOffset = newText.length;
                    break;
                case 'table':
                    newText = '| Colonne 1 | Colonne 2 |\n|-----------|-----------|\n| Cellule 1 | Cellule 2 |';
                    cursorOffset = newText.length;
                    break;
                case 'help':
                    window.open('https://www.markdownguide.org/basic-syntax/', '_blank');
                    return;
                default: return;
            }
            
            textarea.value = beforeText + newText + afterText;
            textarea.focus();
            textarea.setSelectionRange(start + cursorOffset, start + cursorOffset);
            textarea.dispatchEvent(new Event('input'));
        });
    });

    if(bodyTextarea) {
        bodyTextarea.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                let action = null;
                switch(e.key.toLowerCase()) {
                    case 'b': action = 'bold'; break;
                    case 'i': action = 'italic'; break;
                    case 'k': action = 'code'; break;
                    case 'l': action = 'link'; break;
                }
                if (action) {
                    e.preventDefault();
                    const btn = document.querySelector(`[data-action="${action}"]`);
                    if(btn) btn.click();
                }
            }
        });
    }

    const tagCount = document.getElementById('tag-count');
    const tagInput = document.getElementById('tag-input');
    const tagSuggestions = document.getElementById('tag-suggestions');
    const selectedTagsContainer = document.getElementById('selected-tags');
    const tagHiddenInputs = document.getElementById('tag-hidden-inputs');
    
    let selectedTags = [];
    let allTags = @json(\App\Models\Tag::select('id', 'name', 'description')->get());
    
    // Fonction pour mettre à jour l'affichage des tags sélectionnés
    function updateSelectedTags() {
        selectedTagsContainer.innerHTML = selectedTags.map(tag => `
            <span class="tag-badge">
                ${tag.name}
                <span class="remove-tag" onclick="removeTag(${tag.id})">&times;</span>
            </span>
        `).join('');
        
        // Mettre à jour les champs cachés
        tagHiddenInputs.innerHTML = selectedTags.map(tag => 
            `<input type="hidden" name="tags[]" value="${tag.id}">`
        ).join('');
        
        // Mettre à jour le compteur
        if (tagCount) {
            tagCount.textContent = selectedTags.length;
        }
    }
    
    // Fonction pour ajouter un tag
    window.addTag = function(tagId, tagName) {
        if (selectedTags.length >= 5) {
            alert('⚠️ Vous ne pouvez sélectionner que 5 tags maximum.');
            return;
        }
        
        if (selectedTags.find(t => t.id === tagId)) {
            return; // Tag déjà sélectionné
        }
        
        selectedTags.push({ id: tagId, name: tagName });
        updateSelectedTags();
        tagInput.value = '';
        tagSuggestions.style.display = 'none';
    };
    
    // Fonction pour retirer un tag
    window.removeTag = function(tagId) {
        selectedTags = selectedTags.filter(t => t.id !== tagId);
        updateSelectedTags();
    };
    
    // Autocomplétion des tags
    if (tagInput) {
        tagInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            
            if (query.length === 0) {
                tagSuggestions.style.display = 'none';
                return;
            }
            
            const matches = allTags.filter(tag => 
                tag.name.toLowerCase().includes(query) &&
                !selectedTags.find(t => t.id === tag.id)
            ).slice(0, 10);
            
            if (matches.length > 0) {
                tagSuggestions.innerHTML = matches.map(tag => `
                    <div class="tag-suggestion" onclick="addTag(${tag.id}, '${tag.name}')">
                        <div class="tag-suggestion-name">${tag.name}</div>
                        ${tag.description ? `<div class="tag-suggestion-desc">${tag.description}</div>` : ''}
                    </div>
                `).join('');
                tagSuggestions.style.display = 'block';
            } else {
                tagSuggestions.style.display = 'none';
            }
        });
        
        // Fermer les suggestions en cliquant ailleurs
        document.addEventListener('click', function(e) {
            if (!tagInput.contains(e.target) && !tagSuggestions.contains(e.target)) {
                tagSuggestions.style.display = 'none';
            }
        });
        
        // Ajouter un tag avec Entrée
        tagInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const firstSuggestion = tagSuggestions.querySelector('.tag-suggestion');
                if (firstSuggestion) {
                    firstSuggestion.click();
                }
            }
        });
    }
    
    // Initialiser avec les anciens tags si présents
    @if(old('tags'))
        @foreach(old('tags') as $tagId)
            @php
                $tag = \App\Models\Tag::find($tagId);
            @endphp
            @if($tag)
                selectedTags.push({ id: {{ $tag->id }}, name: '{{ $tag->name }}' });
            @endif
        @endforeach
        updateSelectedTags();
    @endif
});
</script>
</x-app-layout>

