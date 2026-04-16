<x-app-layout>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <div>
        <h1 style="font-size:24px;font-weight:800;color:#111827;margin:0 0 4px;">Gestion des Tags</h1>
        <p style="font-size:13px;color:#9ca3af;margin:0;">Créez, modifiez ou supprimez les catégories de questions</p>
    </div>
</div>

<div style="display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap;">
    {{-- Left: Formulaire de création --}}
    <div style="width:300px;flex-shrink:0;">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;">
            <h2 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 16px;">Créer un nouveau tag</h2>
            <form action="{{ route('tags.store') }}" method="POST">
                @csrf
                <div style="margin-bottom:14px;">
                    <label for="name" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                        Nom <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                           style="width:100%;padding:10px;font-size:13px;border:1.5px solid #e5e7eb;border-radius:8px;"
                           value="{{ old('name') }}">
                    @error('name')<span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                </div>
                
                <div style="margin-bottom:16px;">
                    <label for="description" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                        Description <span style="color:#9ca3af;font-weight:400;">(optionnel)</span>
                    </label>
                    <textarea id="description" name="description" rows="3"
                              style="width:100%;padding:10px;font-size:13px;border:1.5px solid #e5e7eb;border-radius:8px;">{{ old('description') }}</textarea>
                    @error('description')<span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                </div>
                
                <button type="submit"
                        style="width:100%;padding:10px;font-size:13px;font-weight:700;color:#fff;
                               background:linear-gradient(135deg,#5046e5,#7c3aed);border:none;border-radius:8px;
                               cursor:pointer;box-shadow:0 3px 8px rgba(80,70,229,.3);">
                    Enregistrer le tag
                </button>
            </form>
        </div>
    </div>

    {{-- Right: Liste des tags --}}
    <div style="flex:1;min-width:300px;">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:#f9fafb;border-bottom:1px solid #e5e7eb;text-align:left;">
                        <th style="padding:12px 16px;font-weight:700;color:#6b7280;">Tag</th>
                        <th style="padding:12px 16px;font-weight:700;color:#6b7280;">Description</th>
                        <th style="padding:12px 16px;font-weight:700;color:#6b7280;text-align:center;">Questions</th>
                        <th style="padding:12px 16px;font-weight:700;color:#6b7280;text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                        <tr style="border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                            <td style="padding:12px 16px;">
                                <span style="display:inline-block;padding:4px 10px;font-size:12px;font-weight:600;
                                             color:#5046e5;background:#eef2ff;border-radius:6px;">
                                    {{ $tag->name }}
                                </span>
                            </td>
                            <td style="padding:12px 16px;color:#6b7280;">{{ $tag->description ?? '—' }}</td>
                            <td style="padding:12px 16px;color:#374151;font-weight:600;text-align:center;">{{ $tag->questions_count }}</td>
                            <td style="padding:12px 16px;text-align:right;">
                                <div style="display:flex;gap:6px;justify-content:flex-end;">
                                    <a href="{{ route('tags.edit', $tag) }}"
                                       style="padding:4px 8px;font-size:11px;font-weight:600;color:#0891b2;background:#ecfeff;
                                              border-radius:4px;text-decoration:none;">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('tags.destroy', $tag) }}" style="display:inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tag ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                style="padding:4px 8px;font-size:11px;font-weight:600;color:#dc2626;background:#fef2f2;
                                                       border:none;border-radius:4px;cursor:pointer;">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:16px;">
            {{ $tags->links() }}
        </div>
    </div>
</div>
</x-app-layout>
