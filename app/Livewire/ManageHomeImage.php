<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManageHomeImage extends Component
{
    use WithFileUploads;

    public $image;
    public ?string $currentImage = null;

    public function mount(): void
    {
        $this->loadCurrentImage();
    }

    public function loadCurrentImage(): void
    {
        $user = Auth::user();
        if ($user && $user->home_image) {
            $this->currentImage = asset('storage/' . $user->home_image);
        }
    }

    public function uploadImage(): void
    {
        $this->validate([
            'image' => 'required|image|max:5120', // max 5MB
        ]);

        $user = Auth::user();

        // Delete old image if exists
        if ($user->home_image && Storage::disk('public')->exists($user->home_image)) {
            Storage::disk('public')->delete($user->home_image);
        }

        // Store new image
        $path = $this->image->store('home-images', 'public');

        // Update user record
        $user->update(['home_image' => $path]);

        // Reset form
        $this->image = null;
        $this->loadCurrentImage();

        // Broadcast event to refresh the display component
        $this->dispatch('imageUpdated')->self();

        session()->flash('success', 'Image uploaded successfully!');
    }

    public function deleteImage(): void
    {
        $user = Auth::user();

        if ($user->home_image && Storage::disk('public')->exists($user->home_image)) {
            Storage::disk('public')->delete($user->home_image);
        }

        $user->update(['home_image' => null]);

        $this->currentImage = null;
        $this->image = null;

        // Broadcast event to refresh the display component
        $this->dispatch('imageUpdated')->self();

        session()->flash('success', 'Image deleted successfully!');
    }

    public function render()
    {
        return view('livewire.manage-home-image');
    }
}

