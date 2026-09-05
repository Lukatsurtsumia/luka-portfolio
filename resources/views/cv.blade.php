@php
    $dev = config('portfolio.developer');
    $projects = config('portfolio.projects');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $dev['name'] }} - CV</title>
    <meta name="robots" content="noindex">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --gold: #a97f22;
            --ink: #1a1a1a;
            --muted: #5b5b5b;
            --line: #dcdcdc;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: var(--ink);
            background: #f4f4f2;
            margin: 0;
            padding: 24px 16px;
            line-height: 1.5;
            font-size: 14px;
        }

        .sheet {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px 44px;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
        }

        .toolbar {
            max-width: 800px;
            margin: 0 auto 16px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .toolbar button, .toolbar a {
            font: inherit;
            font-size: 12px;
            padding: 8px 14px;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--ink);
            text-decoration: none;
            cursor: pointer;
            border-radius: 3px;
        }

        header { display: flex; gap: 20px; align-items: center; }
        header img { width: 84px; height: 84px; object-fit: cover; border-radius: 3px; filter: grayscale(1); }

        h1 { font-size: 27px; margin: 0 0 2px; letter-spacing: -.01em; }
        .role { font-size: 15px; color: var(--gold); font-weight: 600; margin: 0 0 8px; }
        .meta { font-size: 12.5px; color: var(--muted); margin: 0; }
        .meta a { color: var(--muted); }

        h2 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .16em;
            color: var(--gold);
            border-bottom: 1px solid var(--line);
            padding-bottom: 5px;
            margin: 26px 0 12px;
        }

        p.summary { margin: 0; font-size: 13.5px; }

        .cols { display: grid; grid-template-columns: 1fr 1fr; gap: 4px 28px; }

        .tags { display: flex; flex-wrap: wrap; gap: 5px; }
        .tag {
            font-size: 11.5px;
            border: 1px solid var(--line);
            border-radius: 3px;
            padding: 3px 8px;
            color: #3d3d3d;
        }

        .project { margin-bottom: 15px; page-break-inside: avoid; }
        .project-head { display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap; }
        .project h3 { font-size: 14.5px; margin: 0; }
        .kind {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .1em;
            padding: 2px 6px;
            border: 1px solid var(--line);
            border-radius: 2px;
            color: var(--muted);
        }
        .kind-client { color: var(--gold); border-color: var(--gold); }
        .project .sub { font-size: 12px; color: var(--muted); margin: 2px 0 4px; }
        .project p { font-size: 12.8px; margin: 0 0 4px; }
        .project .links { font-size: 11.5px; }
        .project .links a { color: var(--gold); text-decoration: none; margin-right: 10px; }

        ul.langs { list-style: none; padding: 0; margin: 0; font-size: 13px; }
        ul.langs li { display: flex; justify-content: space-between; border-bottom: 1px solid var(--line); padding: 3px 0; }
        ul.langs span:last-child { color: var(--muted); font-size: 12px; }

        @media print {
            body { background: #fff; padding: 0; font-size: 11.5pt; }
            .sheet { box-shadow: none; padding: 0; max-width: none; }
            .toolbar { display: none; }
            a { text-decoration: none; }
            h2 { margin-top: 18px; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button type="button" onclick="window.print()">{{ __('Save as PDF') }}</button>
        <a href="{{ route('home') }}">{{ __('Back to site') }}</a>
    </div>

    <div class="sheet">
        <header>
            <img src="{{ asset($dev['portrait_small']) }}" alt="{{ $dev['name'] }}">
            <div>
                <h1>{{ $dev['name'] }}</h1>
                <p class="role">{{ $dev['title'] }}</p>
                <p class="meta">{{ $dev['location'] }} &middot; {{ $dev['email'] }} &middot; {{ $dev['phone'] }}</p>
                <p class="meta">
                    <a href="{{ $dev['github'] }}">{{ str_replace('https://', '', $dev['github']) }}</a>
                    &middot;
                    <a href="{{ $dev['linkedin'] }}">LinkedIn</a>
                </p>
            </div>
        </header>

        <h2>{{ __('Profile') }}</h2>
        <p class="summary">{{ __($dev['summary']) }}</p>

        <h2>{{ __('Technical skills') }}</h2>
        <div class="tags">
            @foreach ($dev['skills'] as $skill)
                <span class="tag">{{ $skill['name'] }}</span>
            @endforeach
        </div>

        <h2>{{ __('Selected projects') }}</h2>
        @foreach ($projects as $project)
            <div class="project">
                <div class="project-head">
                    <h3>{{ $project['title'] }}</h3>
                    <span class="kind {{ $project['kind'] === 'client' ? 'kind-client' : '' }}">
                        {{ $project['kind'] === 'client' ? __('Client work') : ($project['kind'] === 'product' ? __('Own product') : __('Learning project')) }}
                        &middot; {{ $project['year'] }}
                    </span>
                </div>
                <p class="sub">{{ __($project['subtitle']) }}@if ($project['client']) &middot; {{ $project['client'] }}@endif</p>
                <p>{{ __($project['summary']) }}</p>
                <div class="tags" style="margin-bottom:5px;">
                    @foreach (array_slice($project['stack'], 0, 6) as $tech)
                        <span class="tag">{{ $tech }}</span>
                    @endforeach
                </div>
                <p class="links">
                    @if ($project['live_url'])
                        <a href="{{ $project['live_url'] }}">{{ preg_replace('#^https?://#', '', rtrim($project['live_url'], '/')) }}</a>
                    @endif
                    @if ($project['github_url'])
                        <a href="{{ $project['github_url'] }}">{{ __('Source code') }}</a>
                    @endif
                </p>
            </div>
        @endforeach

        <div class="cols">
            <div>
                <h2>{{ __('Languages') }}</h2>
                <ul class="langs">
                    @foreach ($dev['languages'] as $language)
                        <li><span>{{ __($language['name']) }}</span><span>{{ __($language['level']) }}</span></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h2>{{ __('Infrastructure') }}</h2>
                <p style="font-size:12.8px;margin:0;">
                    {{ __('All projects self-deployed: Docker images built and run on a Hetzner server via Coolify, Cloudflare DNS and TLS, MySQL, persistent volumes, verified nightly backups and cron.') }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>
