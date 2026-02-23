<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DisplayImage extends Component
{
    public ?string $imageUrl = null;

    public function mount(): void
    {
        $this->loadImage();
    }

    public function loadImage(): void
    {
        $user = Auth::user();
        if ($user && $user->home_image) {
            $this->imageUrl = asset('storage/' . $user->home_image);
        } else {
            // Default fallback image
            $this->imageUrl = asset('images/truck.webp');
        }
    }

    #[\Livewire\Attributes\On('imageUpdated')]
    public function refreshImage(): void
    {
        $this->loadImage();
    }

    public function render()
    {
        return view('livewire.display-image');
    }
}

