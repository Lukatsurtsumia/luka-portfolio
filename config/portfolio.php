<?php

/*
|--------------------------------------------------------------------------
| Portfolio content
|--------------------------------------------------------------------------
|
| Single source of truth for everything the site renders: the hero, the
| project "fight cards", the case-study pages and the generated CV.
|
| Adding a project later = adding one entry to 'projects'. No template edits.
|
| Every user-facing string is a translation key resolved through lang/*.json,
| except proper nouns (names, stack, client names) which stay as-is.
|
*/

return [

    'developer' => [
        'name' => 'Luka Tsurtsumia',
        'title' => 'Full-Stack PHP / Laravel Developer',
        'location' => 'Nice, France',
        'email' => 'lukatsurtsumia0@gmail.com',
        'phone' => '07 72 88 55 79',
        'linkedin' => 'https://www.linkedin.com/in/luka-tsurtsumia-921324206/',
        'github' => 'https://github.com/Lukatsurtsumia',
        'portrait' => 'images/luka.webp',
        'portrait_small' => 'images/luka-sm.webp',
        'available' => true,

        // Short punch for the hero. Long form lives on /about.
        'tagline' => 'I ship Laravel applications that real people use every day.',
        'summary' => 'Full-stack PHP/Laravel developer based in Nice. I build and self-host complete products: two live client sites on the Côte d\'Azur, and BoxerOS, an AI training platform for boxers running in production on my own infrastructure.',

        'skills' => [
            ['name' => 'PHP 8.4', 'group' => 'core'],
            ['name' => 'Laravel 11-13', 'group' => 'core'],
            ['name' => 'Livewire', 'group' => 'core'],
            ['name' => 'MySQL', 'group' => 'core'],
            ['name' => 'REST APIs', 'group' => 'core'],
            ['name' => 'Alpine.js', 'group' => 'front'],
            ['name' => 'Tailwind CSS', 'group' => 'front'],
            ['name' => 'JavaScript', 'group' => 'front'],
            ['name' => 'Docker', 'group' => 'ops'],
            ['name' => 'Linux / Ubuntu', 'group' => 'ops'],
            ['name' => 'Coolify / Hetzner', 'group' => 'ops'],
            ['name' => 'Cloudflare', 'group' => 'ops'],
            ['name' => 'Claude API', 'group' => 'ai'],
            ['name' => 'Git / GitHub', 'group' => 'ops'],
        ],

        'languages' => [
            ['name' => 'Georgian', 'level' => 'native'],
            ['name' => 'English', 'level' => 'fluent'],
            ['name' => 'French', 'level' => 'professional'],
            ['name' => 'Russian', 'level' => 'fluent'],
        ],

        // Tale of the tape - the hero stat strip.
        'tape' => [
            ['label' => 'Based in', 'value' => 'Nice, FR'],
            ['label' => 'Live projects', 'value' => '4'],
            ['label' => 'Real clients', 'value' => '2'],
            ['label' => 'Languages', 'value' => '4'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Projects
    |--------------------------------------------------------------------------
    |
    | 'kind'      client | product | learning   - drives the honesty badge
    | 'status'    live | maintained | archived
    | 'metrics'   3 short proof points shown on the card back
    | 'decisions' the case-study meat: what was hard, what was chosen, why
    |
    */
    'projects' => [

        [
            'id' => 'boxeros',
            'slug' => 'boxeros',
            'title' => 'BoxerOS',
            'subtitle' => 'AI fight-camp platform for boxers',
            'kind' => 'product',
            'status' => 'live',
            'category' => 'ai',
            'year' => '2026',
            'role' => 'Sole developer - product, build, infrastructure',
            'client' => null,
            'accent' => '#ef4444',
            'featured' => true,

            'summary' => 'A training platform for boxers: weight, nutrition, hydration and fight camps, plus CORNER, an AI coach that answers using the fighter\'s own logged data rather than generic advice.',

            'problem' => 'Boxers manage a fight camp across a notebook, a scale, a calorie app and a group chat. Nothing knows anything about anything else, so no advice they get is grounded in their actual numbers.',

            'approach' => 'One Laravel application that owns the whole picture - profile, daily logs, meals, fight calendar - with an AI coach layered on top that is handed the fighter\'s real context on every message. The AI is a feature of the data model, not a chatbot bolted to the side.',

            'metrics' => [
                ['value' => 'Live', 'label' => 'in production since July 2026'],
                ['value' => '38', 'label' => 'feature tests, green'],
                ['value' => '~1.1s', 'label' => 'AI coach response'],
            ],

            'decisions' => [
                [
                    'title' => 'Grounding the AI in real data instead of prompting harder',
                    'body' => 'CORNER receives a built context block - profile, today\'s log, recent meals, next fight countdown, plus long-term memory of past sessions. That is what makes it more useful than a general chatbot, and it is a data-modelling problem, not a prompting one.',
                ],
                [
                    'title' => 'Choosing quality over cost, deliberately',
                    'body' => 'I costed the cheaper model and rejected it: chat runs on the stronger model with a 1500-token ceiling. Cost is controlled where it does not hurt the answer instead - prompt caching on the system block, per-user daily caps, a free local food database tried before any AI call, and a data-built session opener that uses no AI at all.',
                ],
                [
                    'title' => 'Removing a feature for liability reasons',
                    'body' => 'I built an injury tracker, then deleted it. Storing structured injury records puts me close to medical record-keeping and advice I am not qualified to give. The AI still discusses injuries in chat, always pointing to a doctor or physio. Knowing what not to ship is part of the job.',
                ],
                [
                    'title' => 'A backup that reported success while writing empty files',
                    'body' => 'The nightly database backup piped mysqldump into gzip and reported success every night. The Alpine container ships no mysqldump binary, and the pipe swallowed the failure, so every backup was a 20-byte empty archive. I rewrote the dump natively in PHP over PDO and verified it by restoring into a scratch database. Now I verify restores, not backup exit codes.',
                ],
            ],

            'stack' => ['Laravel 12', 'Livewire 4', 'MySQL', 'Tailwind CSS', 'Claude API', 'Docker', 'Coolify', 'Hetzner', 'Cloudflare'],
            'tags' => ['Laravel', 'AI Integration', 'Docker', 'Self-hosted'],

            'live_url' => 'https://boxeros.app/',
            'github_url' => null, // private repo
            'repo_private' => true,

            'shots' => [
                'desktop' => 'images/projects/boxeros/desktop.webp',
                'mobile' => 'images/projects/boxeros/mobile.webp',
            ],
        ],

        [
            'id' => 'pcnboxe',
            'slug' => 'pugilist-club-nicois',
            'title' => 'Pugilist Club Niçois',
            'subtitle' => 'Site for a historic Nice boxing club',
            'kind' => 'client',
            'status' => 'live',
            'category' => 'laravel',
            'year' => '2026',
            'role' => 'Developer - site, admin, deployment',
            'client' => 'Pugilist Club Niçois, Nice',
            'accent' => '#3b82f6',
            'featured' => true,

            'summary' => 'The public site for a real boxing club in Nice: French-first with an English switch, GDPR-compliant, with a contact pipeline that reaches the club by email and an admin view for visitor stats.',

            'problem' => 'A working club needed a site that brings in members, loads fast on a phone in the gym, and does not break French privacy rules - maintained by people who are not developers.',

            'approach' => 'A Laravel application with a full French and English localisation layer, a consent gate that blocks third-party embeds until the visitor agrees, an enquiry pipeline that delivers contact requests to the club by email, and a session-authenticated admin view for visitor statistics. Content is file-based rather than database-backed, chosen to fit a brochure site maintained by non-technical volunteers.',

            'metrics' => [
                ['value' => 'Live', 'label' => 'in production for a Nice club'],
                ['value' => 'FR / EN', 'label' => 'complete bilingual localisation'],
                ['value' => 'GDPR', 'label' => 'consent-gated third-party embeds'],
            ],

            'decisions' => [
                [
                    'title' => 'Matching the architecture to the client',
                    'body' => 'A brochure site for a volunteer-run club does not need a relational database, so content and the visitor counter are stored as files. That removed migrations, backups and a class of runtime failure from a site nobody is paid to monitor, and keeps hosting costs minimal. The same judgement led me the other way on BoxerOS and Azur Clean, where MySQL and Eloquent were the right fit.',
                ],
                [
                    'title' => 'Consent gating enforced in the markup, not just the banner',
                    'body' => 'French privacy rules require consent before third-party tracking loads. Google Maps and the reviews widget are not rendered at all until the visitor accepts, rather than being loaded behind a banner that only looks compliant.',
                ],
                [
                    'title' => 'Graceful degradation for a third-party widget',
                    'body' => 'The reviews widget runs on a plan with a monthly view cap and renders nothing once exceeded. The page observes the container and substitutes a static fallback if it is still empty after a few seconds, so visitors never see an empty section.',
                ],
            ],

            'stack' => ['Laravel 13', 'PHP 8.4', 'Alpine.js', 'Tailwind CSS', 'Cloudflare Workers', 'Resend', 'Docker', 'Coolify'],
            'tags' => ['Laravel', 'Bilingual', 'GDPR', 'Docker'],

            'live_url' => 'https://pugilistclubnicois.fr',
            'github_url' => 'https://github.com/Lukatsurtsumia/PCN_club',
            'repo_private' => false,

            'shots' => [
                'desktop' => 'images/projects/pcnboxe/desktop.webp',
                'mobile' => 'images/projects/pcnboxe/mobile.webp',
            ],
        ],

        [
            'id' => 'azur-clean',
            'slug' => 'azur-clean-tinati',
            'title' => 'Azur Clean Tinati',
            'subtitle' => 'Site for a Nice cleaning company',
            'kind' => 'client',
            'status' => 'live',
            'category' => 'laravel',
            'year' => '2026',
            'role' => 'Developer - brand implementation, site, booking flow',
            'client' => 'Azur Clean Tinati, Nice',
            'accent' => '#0ea5e9',
            'featured' => true,

            'summary' => 'A bilingual site for a real cleaning company serving hotels, residences and villas on the Côte d\'Azur, built from the owner\'s business documents and printed brand material.',

            'problem' => 'The company had a visit card, a French company brochure and no web presence. Everything - brand, structure, copy, booking flow - had to be derived from paper.',

            'approach' => 'French-first bilingual site with a plain reservation form, service and pricing pages, and a job gallery. Deliberately calm: no ambient motion anywhere, at the owner\'s request.',

            'metrics' => [
                ['value' => 'Live', 'label' => 'for a real Nice business'],
                ['value' => 'FR / EN', 'label' => 'French-first bilingual'],
                ['value' => '1', 'label' => 'feature deleted after client review'],
            ],

            'decisions' => [
                [
                    'title' => 'Deleting the feature I was proudest of',
                    'body' => 'I built a full availability system - capacity, blocked days, occupancy, an admin calendar. The owner did not want it: she confirms dates by phone and showing occupied days would expose how busy she is. I removed the whole apparatus and shipped a plain date form instead. The client\'s business reality beats my nicer architecture.',
                ],
                [
                    'title' => 'Using the real artwork instead of my redraw',
                    'body' => 'I traced the logo as an SVG from a blurry angled photo and got the shape wrong. The correct move was to ask for a clean crop and use the owner\'s actual painted artwork. Approximating someone\'s brand is not a shortcut worth taking.',
                ],
                [
                    'title' => 'No animation, because the client said so',
                    'body' => 'I proposed an animated wave hero. It was rejected in favour of a real photograph. I deleted the keyframes rather than arguing for them, and the site is calmer for it.',
                ],
            ],

            'stack' => ['Laravel', 'Alpine.js', 'Tailwind CSS', 'MySQL', 'Docker', 'Coolify', 'Hetzner'],
            'tags' => ['Laravel', 'Bilingual', 'Client work'],

            'live_url' => 'https://tinati-agency.com',
            'github_url' => 'https://github.com/Lukatsurtsumia/cleaning_agency',
            'repo_private' => false,

            'shots' => [
                'desktop' => 'images/projects/azur-clean/desktop.webp',
                'mobile' => 'images/projects/azur-clean/mobile.webp',
            ],
        ],

        [
            'id' => 'bookshop',
            'slug' => 'bookshop',
            'title' => 'BookShop',
            'subtitle' => 'Full-stack e-commerce build',
            'kind' => 'learning',
            'status' => 'live',
            'category' => 'ecommerce',
            'year' => '2025',
            'role' => 'Sole developer',
            'client' => null,
            'accent' => '#f59e0b',
            'featured' => false,

            'summary' => 'An e-commerce platform built to learn the full stack end to end: catalogue, accounts, a points-based purchasing system with a welcome bonus, reviews and ratings.',

            'problem' => 'I wanted to build every part of a transactional application myself - auth, catalogue, cart, balance, reviews - rather than assemble one from packages.',

            'approach' => 'Laravel and MySQL, with a points currency instead of real payments so the whole purchase flow could be built and tested without a payment provider.',

            'metrics' => [
                ['value' => '500', 'label' => 'point welcome bonus'],
                ['value' => 'Full', 'label' => 'auth, cart, reviews, ratings'],
                ['value' => '2025', 'label' => 'first full-stack build'],
            ],

            'decisions' => [
                [
                    'title' => 'Points instead of payments',
                    'body' => 'Using an internal points balance let me build and test the entire purchase path - balance checks, failure states, order history - without onboarding to a payment provider for a learning project.',
                ],
                [
                    'title' => 'Kept online, with a caveat',
                    'body' => 'It runs on a free host that sleeps when idle, so the first request takes several seconds to wake. I have left it live and labelled rather than quietly dropping it - it is the project that taught me the stack.',
                ],
            ],

            'stack' => ['Laravel', 'MySQL', 'Blade', 'JavaScript'],
            'tags' => ['Laravel', 'E-commerce', 'MySQL'],

            'live_url' => 'https://laravel-bookshop.onrender.com',
            'github_url' => 'https://github.com/Lukatsurtsumia/laravel-bookshop',
            'repo_private' => false,
            'cold_start' => true,

            'shots' => [
                'desktop' => 'images/projects/bookshop/desktop.webp',
                'mobile' => 'images/projects/bookshop/mobile.webp',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact
    |--------------------------------------------------------------------------
    |
    | Prefilled into the Gmail compose window so a visitor only has to write
    | their message. Both strings go through __(), so they follow the site
    | language.
    |
    */
    'contact' => [
        'subject' => 'Project or role enquiry',
        'body' => "Hello Luka,\n\n",
    ],

    /*
    |--------------------------------------------------------------------------
    | Showcase - the animated 3D fighter
    |--------------------------------------------------------------------------
    |
    | Rendered live with three.js, loaded on demand when the section scrolls
    | into view. Deliberately has no repository link: it is a reusable asset,
    | not an open-source project.
    |
    */
    'showcase' => [
        'title' => '3D Boxer',
        'subtitle' => 'A rigged, animated fighter running in the browser',
        'body' => 'A rigged 3D character with a looping movement animation, rendered in real time with three.js and WebGL. The model is framed automatically from its own skeleton, so it fits any container without hand-tuning the camera, and the renderer pauses whenever it is off screen. A self-contained component, ready to drop into the next sports project.',
        'stack' => ['three.js', 'WebGL', 'FBX', 'Skeletal animation', 'JavaScript'],
        'model' => 'models/hero-boxer.fbx',
    ],

    /*
    |--------------------------------------------------------------------------
    | How I work - the three-panel proof section under the projects
    |--------------------------------------------------------------------------
    */
    'principles' => [
        [
            'title' => 'Full-stack Laravel development',
            'body' => 'I build complete applications in Laravel: relational schema design and migrations, Eloquent models and business logic, REST endpoints, and Blade, Livewire and Alpine.js interfaces styled with Tailwind CSS. I follow framework conventions and PSR standards so the codebase stays familiar to any Laravel developer joining it.',
        ],
        [
            'title' => 'Deployment and maintenance',
            'body' => 'Every application shown here runs on infrastructure I configured and continue to maintain: Docker images deployed through Coolify on a Hetzner server, MySQL, Cloudflare DNS and TLS, persistent storage volumes, scheduled tasks and verified automated backups. I am comfortable owning an application after release, not only up to it.',
        ],
        [
            'title' => 'Working with clients and requirements',
            'body' => 'I deliver French-first bilingual applications with full English localisation, working directly with business owners in Nice to turn their requirements into scope. I keep the work aligned with what the client actually needs, adjust when requirements change, and communicate clearly in English and French.',
        ],
    ],
];
