<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProjectsShowcase extends Component
{
    public string $activeCategory = 'all';

    public function setCategory(string $category): void
    {
        $this->activeCategory = $category;
    }

    #[Computed]
    public function projects(): Collection
    {
        $projects = collect(config('portfolio.projects'));

        if ($this->activeCategory === 'all') {
            return $projects;
        }

        return $projects->where('category', $this->activeCategory)->values();
    }

    #[Computed]
    public function categories(): Collection
    {
        return collect(config('portfolio.projects'))
            ->pluck('category')
            ->unique()
            ->values();
    }

    public function render()
    {
        return view('livewire.projects-showcase', [
            'projects' => $this->projects,
            'categories' => $this->categories,
        ]);
    }
}
