<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProjectsShowcase extends Component
{
    public string $activeKind = 'all';

    public function setKind(string $kind): void
    {
        $this->activeKind = $kind;
    }

    #[Computed]
    public function projects(): Collection
    {
        $projects = collect(config('portfolio.projects'));

        if ($this->activeKind !== 'all') {
            $projects = $projects->where('kind', $this->activeKind);
        }

        // Featured work leads the card regardless of the active filter.
        return $projects
            ->sortByDesc(fn (array $project) => $project['featured'] ?? false)
            ->values();
    }

    /** Kind => count, so the filter buttons can show how much sits behind each. */
    #[Computed]
    public function kinds(): Collection
    {
        return collect(config('portfolio.projects'))
            ->countBy('kind')
            ->sortKeys();
    }

    public function render()
    {
        return view('livewire.projects-showcase', [
            'projects' => $this->projects,
            'kinds' => $this->kinds,
        ]);
    }
}
