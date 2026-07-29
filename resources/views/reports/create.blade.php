@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Buat Laporan Baru</h1>

        <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
            @csrf
            <label class="block mb-2 font-medium">Judul Laporan</label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full border rounded p-2 mb-2" placeholder="Contoh: Laporan Praktik Kerja Lapangan">
            @error('title')
                <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
            @enderror

            <label class="block mb-2 mt-4 font-medium">Logo (opsional)</label>
            <input type="file" name="logo" accept="image/*" class="w-full border rounded p-2 mb-2">
            @error('logo')
                <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
            @enderror

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-2">
                Simpan & Lanjut Tambah Bab
            </button>
        </form>
    </div>
@endsection