<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; line-height: 1.6; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 30px; }
        h2 { font-size: 15px; margin-top: 20px; margin-bottom: 8px; }
        h3 { font-size: 13px; margin-bottom: 4px; }
        p { margin: 0 0 10px 0; text-align: justify; }
    </style>
</head>
<body>
    <h1>{{ $report->title }}</h1>

    @foreach($report->chapters as $chapter)
        <h2>
            BAB {{ $chapter->roman_number }}
            @if($chapter->title)
                — {{ $chapter->title }}
            @endif
        </h2>

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
    @endforeach
</body>
</html>