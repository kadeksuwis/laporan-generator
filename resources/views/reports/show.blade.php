@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-1">{{ $report->title }}</h1>
        <p class="text-gray-500 mb-6">{{ $report->chapters->count() }} bab</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Daftar Bab --}}
        <div class="space-y-4 mb-8">
            @forelse($report->chapters as $chapter)
                <div class="border rounded p-4">
                    <div class="flex justify-between items-center">
                        <h2 class="font-semibold text-lg">
                            BAB {{ $chapter->roman_number }}
                            @if($chapter->title)
                                — {{ $chapter->title }}
                            @endif
                        </h2>
                        <form action="{{ route('chapters.destroy', $chapter) }}" method="POST"
                            onsubmit="return confirm('Hapus bab ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Belum ada bab.</p>
            @endforelse
        </div>

        {{-- Form tambah bab --}}
        <div class="border-t pt-6">
            <h3 class="font-medium mb-2">Tambah Bab Baru</h3>
            <form action="{{ route('chapters.store', $report) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="title" placeholder="Judul bab (opsional, contoh: Pendahuluan)"
                    class="flex-1 border rounded p-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    + Tambah Bab
                </button>
            </form>
        </div>
    </div>
@endsection