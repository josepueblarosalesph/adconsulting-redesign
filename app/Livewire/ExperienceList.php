<?php

namespace App\Livewire;

use App\Models\Experience;
use Livewire\Component;

class ExperienceList extends Component
{
    private const PAGE_SIZE = 16;

    public int $limit = self::PAGE_SIZE;

    public function loadMore(): void
    {
        $this->limit += self::PAGE_SIZE;
    }

    public function render()
    {
        $experiences = Experience::publishedOrFallback();

        return view('livewire.experience-list', [
            'experiences' => $experiences->take($this->limit),
            'hasMore' => $experiences->count() > $this->limit,
        ]);
    }
}
