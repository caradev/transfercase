<?php

namespace App\Livewire\Admin;

use App\Models\ContactInquiry;
use Livewire\Component;
use Livewire\WithPagination;

class ContactInquiries extends Component
{
    use WithPagination;

    public $search = '';

    public $filterRead = '';

    public $showModal = false;

    public $selectedInquiry;

    protected $queryString = ['search', 'filterRead'];

    public function mount()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function render()
    {
        $inquiries = ContactInquiry::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhere('subject', 'like', '%'.$this->search.'%')
                    ->orWhere('message', 'like', '%'.$this->search.'%');
            })
            ->when($this->filterRead === 'read', function ($query) {
                $query->where('is_read', true);
            })
            ->when($this->filterRead === 'unread', function ($query) {
                $query->where('is_read', false);
            })
            ->latest()
            ->paginate(10);

        $unreadCount = ContactInquiry::where('is_read', false)->count();

        return view('livewire.admin.contact-inquiries', [
            'inquiries' => $inquiries,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function viewInquiry($id)
    {
        $this->selectedInquiry = ContactInquiry::findOrFail($id);

        // Mark as read when viewing
        if (! $this->selectedInquiry->is_read) {
            $this->selectedInquiry->markAsRead();
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedInquiry = null;
    }

    public function toggleRead($id)
    {
        $inquiry = ContactInquiry::findOrFail($id);

        if ($inquiry->is_read) {
            $inquiry->markAsUnread();
            session()->flash('success', 'Inquiry marked as unread.');
        } else {
            $inquiry->markAsRead();
            session()->flash('success', 'Inquiry marked as read.');
        }
    }

    public function deleteInquiry($id)
    {
        try {
            ContactInquiry::findOrFail($id)->delete();
            session()->flash('success', 'Inquiry deleted successfully.');

            if ($this->showModal) {
                $this->closeModal();
            }

            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting inquiry.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterRead()
    {
        $this->resetPage();
    }
}
