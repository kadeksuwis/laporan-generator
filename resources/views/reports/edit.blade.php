@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Edit Laporan</h1>

        <form method="POST" action="{{ route('reports.update', $report) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="block mb-2 font-medium">Judul Laporan</label>
            <input type="text" name="title" value="{{ old('title', $report->title) }}"
                class="w-full border rounded p-2 mb-2">
            @error('title')
                <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
            @enderror

            <label class="block mb-2 mt-4 font-medium">Logo</label>
            @if($report->logo)
                <img src="{{ $report->logo_url }}" class="w-16 h-16 object-contain mb-2">
            @endif
            <input type="file" name="logo" accept="image/*" class="w-full border rounded p-2 mb-2">
            <p class="text-xs text-gray-500 mb-2">Upload gambar baru untuk mengganti logo lama (opsional).</p>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-2">
                Simpan Perubahan
            </button>
        </form>
    </div>
@endsection