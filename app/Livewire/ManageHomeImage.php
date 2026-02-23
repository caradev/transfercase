<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

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
        if (!$this->canManage) {
            return;
        }

        $this->validate([
            'image' => 'image|max:5120', // 5MB Max
        ]);}

    public function save()
    {
        if (!$this->canManage) {
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

        session()->flash('message', 'Image updated successfully!');
    }

    public function delete()
    {
        if (!$this->canManage) {
            session()->flash('error', 'You do not have permission to manage the home image.');
            return;
        }

        $user = auth()->user();

        if ($user->home_image && Storage::disk('public')->exists($user->home_image)) {
            Storage::disk('public')->delete($user->home_image);
            $user->update(['home_image' => null]);
            $this->currentImage = null;

            session()->flash('message', 'Image deleted successfully!');
        }
    }

    public function render()
    {
        return view('livewire.manage-home-image');
    }
}
