<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        // La vue gère la pagination et le tri manuellement
        return view('tags.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:50|unique:tags',
            'description' => 'nullable|string|max:255',
            'category'    => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Tag::create($validated);

        return redirect()->route('tags.index')->with('success', 'Tag créé avec succès.');
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:50|unique:tags,name,' . $tag->id,
            'description' => 'nullable|string|max:255',
            'category'    => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $tag->update($validated);

        return redirect()->route('tags.index')->with('success', 'Tag mis à jour avec succès.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag supprimé avec succès.');
    }
}
