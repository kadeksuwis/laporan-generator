@extends('layouts.app')
@section('content')
    <div class="max-w-3xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Laporan</h1>
            <a href="{{ route('reports.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Buat Laporan
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <ul class="space-y-2">
            @forelse($reports as $report)
                <li class="border p-3 rounded flex justify-between items-center">
                    <a href="{{ route('reports.show', $report) }}" class="font-medium">
                        {{ $report->title }}
                    </a>
                    <span class="text-sm text-gray-500">
                        {{ $report->chapters_count ?? $report->chapters()->count() }} bab
                    </span>
                </li>
            @empty
                <li class="text-gray-500">Belum ada laporan.</li>
            @endforelse
        </ul>
    </div>
@endsection