# Developer Guidelines: Luka Tsurtsumia Portfolio

## Stack & Standards
- Framework: Laravel 11+ (PHP 8.3)
- Dynamic UI: Livewire 3 + Alpine.js
- Styling: Deep obsidian theme (`#09090b`), glowing emerald neon (`#10b981`) and electric indigo accents (`#6366f1`), glassmorphism (`backdrop-blur-xl bg-white/[0.03] border border-white/10 shadow-2xl`), ambient gradient glow backgrounds.
- Motion & FX: Interactive Alpine.js micro-animations, smooth hover card 3D tilt effects (`hover:-translate-y-2 hover:rotate-1`), animated SVG background mesh grid, interactive terminal toggle, and sleek scroll animations.
- Data: Pull directly from `config('portfolio')`

## Core Rules
1. Never hardcode developer or project details—retrieve from `config('portfolio')`.
2. Ensure responsive designs look clean on mobile (390px) and desktop (1920px).
3. Include live project links and GitHub URLs on every project card.

