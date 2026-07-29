<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\SubChapter;
use Illuminate\Http\Request;

class SubChapterController extends Controller
{
    public function store(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        $nextOrder = $chapter->subChapters()->count() + 1;

        $chapter->subChapters()->create([
            'title' => $validated['title'] ?? null,
            'content' => $validated['content'] ?? null,
            'order' => $nextOrder,
        ]);

        return redirect()->route('reports.show', $chapter->report)
            ->with('success', 'Sub bab berhasil ditambahkan.');
    }

    public function update(Request $request, SubChapter $subChapter)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        $subChapter->update($validated);

        return redirect()->route('reports.show', $subChapter->chapter->report)
            ->with('success', 'Sub bab berhasil diperbarui.');
    }

    public function destroy(SubChapter $subChapter)
    {
        $chapter = $subChapter->chapter;
        $subChapter->delete();

        // rapikan ulang urutan sub bab yang tersisa
        $chapter->subChapters()->orderBy('order')->get()->each(function ($sc, $index) {
            $sc->update(['order' => $index + 1]);
        });

        return redirect()->route('reports.show', $chapter->report)
            ->with('success', 'Sub bab berhasil dihapus.');
    }
}
