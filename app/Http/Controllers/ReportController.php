<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::latest()->get();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $report = Report::create($validated);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Laporan berhasil dibuat, silakan tambah bab.');
    }

    public function show(Report $report)
    {
        $report->load('chapters.subChapters');
        return view('reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $report->update($validated);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Judul laporan berhasil diubah.');
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function exportPdf(Report $report)
    {
        $report->load('chapters.subChapters');

        $pdf = Pdf::loadView('reports.export-pdf', compact('report'))
            ->setPaper('a4');

        return $pdf->download($report->title . '.pdf');
    }

    public function exportWord(Report $report)
    {
        $report->load('chapters.subChapters');

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText($report->title, ['bold' => true, 'size' => 16], ['alignment' => Jc::CENTER]);
        $section->addTextBreak(1);

        foreach ($report->chapters as $chapter) {
            $chapterTitle = 'BAB ' . $chapter->roman_number;
            if ($chapter->title) {
                $chapterTitle .= ' — ' . $chapter->title;
            }
            $section->addText($chapterTitle, ['bold' => true, 'size' => 14]);
            $section->addTextBreak(1);

            foreach ($chapter->subChapters as $sub) {
                $subTitle = $sub->number;
                if ($sub->title) {
                    $subTitle .= ' ' . $sub->title;
                }
                $section->addText($subTitle, ['bold' => true, 'size' => 12]);

                if ($sub->content) {
                    $section->addText($sub->content, ['size' => 11]);
                }
                $section->addTextBreak(1);
            }
        }

        $filename = $report->title . '.docx';
        $tempPath = storage_path('app/' . $filename);
        $phpWord->save($tempPath, 'Word2007');

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}