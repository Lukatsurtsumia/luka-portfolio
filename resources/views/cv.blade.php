@php
    $developer = config('portfolio.developer');
    $projects = config('portfolio.projects');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $developer['name'] }} — CV</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #18181b;
            background: #ffffff;
            max-width: 780px;
            margin: 0 auto;
            padding: 48px 32px;
            line-height: 1.5;
        }
        h1 { font-size: 28px; margin: 0 0 4px; }
        h2 {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #10b981;
            border-bottom: 1px solid #e4e4e7;
            padding-bottom: 6px;
            margin: 32px 0 12px;
        }
        .title { font-size: 16px; color: #4f46e5; font-weight: 600; margin: 0 0 12px; }
        .meta { font-size: 13px; color: #52525b; margin-bottom: 4px; }
        .summary { font-size: 14px; color: #3f3f46; }
        .tags { display: flex; flex-wrap: wrap; gap: 6px; }
        .tag {
            font-size: 12px;
            border: 1px solid #e4e4e7;
            border-radius: 999px;
            padding: 4px 10px;
            color: #3f3f46;
        }
        .project { margin-bottom: 16px; }
        .project h3 { font-size: 15px; margin: 0 0 2px; }
        .project .subtitle { font-size: 12px; color: #71717a; margin: 0 0 6px; }
        .project p { font-size: 13px; color: #3f3f46; margin: 0 0 6px; }
        .project a { font-size: 12px; color: #4f46e5; text-decoration: none; margin-right: 12px; }
        @media print {
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <h1>{{ $developer['name'] }}</h1>
    <p class="title">{{ $developer['title'] }}</p>
    <p class="meta">{{ $developer['location'] }} · {{ $developer['email'] }} · {{ $developer['phone'] }}</p>
    <p class="meta">{{ $developer['linkedin'] }} · {{ $developer['github'] }}</p>

    <h2>Summary</h2>
    <p class="summary">{{ $developer['summary'] }}</p>

    <h2>Skills</h2>
    <div class="tags">
        @foreach ($developer['skills'] as $skill)
            <span class="tag">{{ $skill }}</span>
        @endforeach
    </div>

    <h2>Languages</h2>
    <div class="tags">
        @foreach ($developer['languages'] as $language)
            <span class="tag">{{ $language }}</span>
        @endforeach
    </div>

    <h2>Projects</h2>
    @foreach ($projects as $project)
        <div class="project">
            <h3>{{ $project['title'] }}</h3>
            <p class="subtitle">{{ $project['subtitle'] }}</p>
            <p>{{ $project['description'] }}</p>
            <div class="tags" style="margin-bottom: 6px;">
                @foreach ($project['tags'] as $tag)
                    <span class="tag">{{ $tag }}</span>
                @endforeach
            </div>
            <a href="{{ $project['live_url'] }}">Live Site →</a>
            <a href="{{ $project['github_url'] }}">GitHub →</a>
        </div>
    @endforeach
</body>
</html>
