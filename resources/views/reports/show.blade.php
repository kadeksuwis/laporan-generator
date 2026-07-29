@extends('layouts.app')
@section('content')
    <div class="max-w-3xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-2">{{ $report->title }}</h1>
        <p class="text-gray-500 mb-6">{{ $report->chapters->count() }} bab</p>

        {{-- Nanti di sini kita render daftar bab & sub bab --}}
    </div>
@endsection
