<?php

namespace App\Livewire;

use App\Models\Carousel;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class HomePage extends Component
{
    /**
     * @var Collection<int,Category>
     */
    public Collection $categories;

    public function mount()
    {
        $this->categories = Category::query()
            ->where('is_enabled', true)
            ->orderBy('sort')
            ->get();
    }

    #[Computed]
    public function carousels(): ?Carousel
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
