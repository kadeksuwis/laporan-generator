<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Html;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::withCount('chapters')->latest()->get();
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
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

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
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $report->update($validated);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Laporan berhasil diubah.');
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

        // ===== Halaman Cover =====
        $cover = $phpWord->addSection();
        $cover->addTextBreak(4);

        if ($report->logo) {
            $cover->addImage(
                storage_path('app/public/' . $report->logo),
                ['width' => 100, 'height' => 100, 'alignment' => Jc::CENTER]
            );
            $cover->addTextBreak(1);
        }

        $cover->addText($report->title, ['bold' => true, 'size' => 20], ['alignment' => Jc::CENTER]);
        $cover->addTextBreak(1);

        // ===== Isi Laporan (tiap bab di section baru = otomatis page break) =====
        foreach ($report->chapters as $chapter) {
            $section = $phpWord->addSection();

            $section->addText('BAB ' . $chapter->roman_number, ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER]);
            if ($chapter->title) {
                $section->addText(strtoupper($chapter->title), ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER]);
            }
            $section->addTextBreak(1);

            foreach ($chapter->subChapters as $sub) {
                $subTitle = $sub->number;
                if ($sub->title) {
                    $subTitle .= ' ' . $sub->title;
                }
                $section->addText($subTitle, ['bold' => true, 'size' => 12]);

                if ($sub->content) {
                    $section->addText($sub->content, ['size' => 11], ['alignment' => Jc::BOTH]);
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