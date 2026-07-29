<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; line-height: 1.6; }

        .cover { text-align: center; padding-top: 150px; }
        .cover img { width: 100px; margin-bottom: 20px; }
        .cover h1 { font-size: 22px; }

        .chapter { page-break-before: always; }
        .chapter-number { text-align: center; font-size: 15px; font-weight: bold; margin-bottom: 4px; }
        .chapter-title { text-align: center; font-size: 15px; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; }

        h3 { font-size: 13px; margin-bottom: 4px; }
        p { margin: 0 0 10px 0; text-align: justify; }
    </style>
</head>
<body>
    {{-- Cover --}}
    <div class="cover">
        @if($report->logo)
            <img src="{{ storage_path('app/public/' . $report->logo) }}">
        @endif
        <h1>{{ $report->title }}</h1>
    </div>

    {{-- Isi per bab, tiap bab mulai halaman baru --}}
    @foreach($report->chapters as $chapter)
        <div class="chapter">
            <div class="chapter-number">BAB {{ $chapter->roman_number }}</div>
            @if($chapter->title)
                <div class="chapter-title">{{ $chapter->title }}</div>
            @endif

            @foreach($chapter->subChapters as $sub)
                <h3>
                    {{ $sub->number }}
                    @if($sub->title)
                        {{ $sub->title }}
                    @endif
                </h3>
                @if($sub->content)
                    <p>{{ $sub->content }}</p>
                @endif
            @endforeach
        </div>
    @endforeach
</body>
</html>