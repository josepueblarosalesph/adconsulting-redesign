<?php

namespace App\Livewire;

use App\Support\SiteContent;
use Livewire\Component;

class ServiceExplorer extends Component
{
    public int $active = 0;

    public function select(int $index): void
    {
        $this->active = max(0, min($index, count(SiteContent::SERVICE_TITLES) - 1));
    }

    public function render()
    {
        $services = SiteContent::services();

        return view('livewire.service-explorer', [
            'services' => $services,
            'service' => $services[$this->active],
        ]);
    }
}
