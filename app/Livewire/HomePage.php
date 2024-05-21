<?php

namespace App\Livewire;

use App\Models\Carousel;
use Livewire\Attributes\Computed;
use Livewire\Component;

class HomePage extends Component
{
    #[Computed]
    public function carousels()
    {
        return Carousel::query()
            ->with('items.media')
            ->where('key', 'home')->first();
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
