<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Report;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function store(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
        ]);

        // urutan otomatis = jumlah bab yang sudah ada + 1
        $nextOrder = $report->chapters()->count() + 1;

        $report->chapters()->create([
            'title' => $validated['title'] ?? null,
            'order' => $nextOrder,
        ]);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Bab berhasil ditambahkan.');
    }

    public function destroy(Chapter $chapter)
    {
        $report = $chapter->report;
        $chapter->delete();

        // rapikan ulang urutan bab yang tersisa supaya romawi tetap berurutan
        $report->chapters()->orderBy('order')->get()->each(function ($ch, $index) {
            $ch->update(['order' => $index + 1]);
        });

        return redirect()->route('reports.show', $report)
            ->with('success', 'Bab berhasil dihapus.');
    }
    public function update(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
        ]);

        $chapter->update($validated);

        return redirect()->route('reports.show', $chapter->report)
            ->with('success', 'Judul bab berhasil diubah.');
    }
}
