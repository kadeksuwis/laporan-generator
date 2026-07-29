@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Dashboard Laporan</h1>
            <a href="{{ route('reports.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Buat Laporan
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($reports as $report)
                <a href="{{ route('reports.show', $report) }}"
                    class="border rounded-lg p-4 hover:shadow-md transition bg-white block">
                    @if($report->logo)
                        <img src="{{ $report->logo_url }}" class="w-10 h-10 object-contain mb-2">
                    @endif
                    <h2 class="font-semibold mb-1">{{ $report->title }}</h2>
                    <p class="text-sm text-gray-500">{{ $report->chapters_count }} bab</p>
                    <p class="text-xs text-gray-400 mt-2">{{ $report->created_at->format('d M Y') }}</p>
                </a>
            @empty
                <p class="text-gray-500 col-span-full">Belum ada laporan. Yuk buat yang pertama.</p>
            @endforelse
        </div>
    </div>
@endsection