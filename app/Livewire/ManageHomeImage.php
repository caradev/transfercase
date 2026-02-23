<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageHomeImage extends Component
{
    use WithFileUploads;

    public $image;

    public $currentImage;

    public bool $canManage = false;

    public function mount()
    {
        $this->canManage = auth()->user()->hasPermissionTo('manage home image');
        $this->currentImage = auth()->user()->home_image;
    }

    public function updatedImage()
    {
        if (! $this->canManage) {
            return;
        }

        $this->validate([
            'image' => 'image|max:5120', // 5MB Max
        ]);
    }

    public function uploadImage()
    {
        if (! $this->canManage) {
            session()->flash('error', 'You do not have permission to manage the home image.');

            return;
        }

        $this->validate([
            'image' => 'required|image|max:5120',
        ]);

        $user = auth()->user();

        // Delete old image if exists
        if ($user->home_image && Storage::disk('public')->exists($user->home_image)) {
            Storage::disk('public')->delete($user->home_image);
        }

        // Store new image
        $path = $this->image->store('home-images', 'public');
        $user->update(['home_image' => $path]);

        $this->currentImage = $path;
        $this->image = null;

        session()->flash('success', 'Image updated successfully!');
    }

    public function deleteImage()
    {
        if (! $this->canManage) {
            session()->flash('error', 'You do not have permission to manage the home image.');

            return;
        }

        $user = auth()->user();

        if ($user->home_image && Storage::disk('public')->exists($user->home_image)) {
            Storage::disk('public')->delete($user->home_image);
            $user->update(['home_image' => null]);
            $this->currentImage = null;

            session()->flash('success', 'Image deleted successfully!');
        }
    }

    public function render()
    {
        return view('livewire.manage-home-image');
    }
}
