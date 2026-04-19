<x-app-layout>
<div style="max-width:500px;margin:0 auto;padding-top:20px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
        <a href="{{ route('tags.index') }}" style="color:#6b7280;text-decoration:none;font-weight:600;">← Retour</a>
        <h1 style="font-size:20px;font-weight:800;color:#111827;margin:0;">Modifier le tag : {{ $tag->name }}</h1>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;">
        <form action="{{ route('tags.update', $tag) }}" method="POST">
            @csrf @method('PUT')
            
            <div style="margin-bottom:16px;">
                <label for="name" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                    Nom 
                </label>
                <input type="text" id="name" name="name" required
                       style="width:100%;padding:10px;font-size:13px;border:1.5px solid #e5e7eb;border-radius:8px;"
                       value="{{ old('name', $tag->name) }}">
                @error('name')<span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>@enderror
            </div>
            
            <div style="margin-bottom:20px;">
                <label for="description" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                    Description
                </label>
                <textarea id="description" name="description" rows="4"
                          style="width:100%;padding:10px;font-size:13px;border:1.5px solid #e5e7eb;border-radius:8px;">{{ old('description', $tag->description) }}</textarea>
                @error('description')<span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>@enderror
            </div>

            <div style="margin-bottom:20px;">
                <label for="category" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                    Catégorie
                </label>
                <select id="category" name="category" 
                        style="width:100%;padding:10px;font-size:13px;border:1.5px solid #e5e7eb;border-radius:8px;background:#fff;">
                    @foreach(['frontend' => 'Frontend', 'backend' => 'Backend', 'database' => 'Base de données', 'mobile' => 'Mobile', 'devops' => 'DevOps', 'general' => 'Général'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('category', $tag->category) == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
                @error('category')<span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>@enderror
            </div>
            
            <div style="text-align:right;">
                <button type="submit"
                        style="padding:10px 20px;font-size:13px;font-weight:700;color:#fff;
                               background:linear-gradient(135deg,#5046e5,#7c3aed);border:none;border-radius:8px;
                               cursor:pointer;box-shadow:0 3px 8px rgba(80,70,229,.3);">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
