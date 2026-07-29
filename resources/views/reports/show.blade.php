@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-1">{{ $report->title }}</h1>
        <p class="text-gray-500 mb-6">{{ $report->chapters->count() }} bab</p>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Daftar Bab --}}
        <div class="space-y-4 mb-8">
            @forelse($report->chapters as $chapter)
                <div class="border rounded p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="font-semibold text-lg">
                            BAB {{ $chapter->roman_number }}
                            @if ($chapter->title)
                                — {{ $chapter->title }}
                            @endif
                        </h2>
                        <form action="{{ route('chapters.destroy', $chapter) }}" method="POST"
                            onsubmit="return confirm('Hapus bab ini beserta semua sub babnya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 text-sm">Hapus Bab</button>
                        </form>
                    </div>

                    {{-- Daftar Sub Bab --}}
                    <div class="ml-4 space-y-2 mb-3">
                        @forelse($chapter->subChapters as $sub)
                            <div class="border-l-2 pl-3 py-1 flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-sm">
                                        {{ $sub->number }}
                                        @if ($sub->title)
                                            {{ $sub->title }}
                                        @endif
                                    </p>
                                    @if ($sub->content)
                                        <p class="text-sm text-gray-600">{{ Str::limit($sub->content, 100) }}</p>
                                    @endif
                                </div>
                                <form action="{{ route('sub-chapters.destroy', $sub) }}" method="POST"
                                    onsubmit="return confirm('Hapus sub bab ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 text-xs">Hapus</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm">Belum ada sub bab.</p>
                        @endforelse
                    </div>

                    {{-- Form tambah sub bab --}}
                    <form action="{{ route('sub-chapters.store', $chapter) }}" method="POST" class="ml-4 space-y-2">
                        @csrf
                        <input type="text" name="title" placeholder="Judul sub bab (opsional)"
                            class="w-full border rounded p-2 text-sm">
                        <textarea name="content" placeholder="Isi konten sub bab..." class="w-full border rounded p-2 text-sm" rows="2"></textarea>
                        <button type="submit" class="bg-gray-700 text-white px-3 py-1 rounded text-sm">
                            + Tambah Sub Bab
                        </button>
                    </form>
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
