<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $userId;

    // Form fields
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $selectedRole;

    // Search and filter
    public $search = '';
    public $roleFilter = '';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->userId ?? 'NULL'),
            'selectedRole' => 'required|exists:roles,name',
        ];

        if (!$this->editMode || $this->password) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

    public function mount()
    {
        // Check if user has permission
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->roleFilter, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', $this->roleFilter);
                });
            })
            ->latest()
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.admin.user-management', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function createUser()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function editUser($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->userId = $id;

        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRole = $user->roles->first()?->name ?? '';

        $this->showModal = true;
    }

    public function saveUser()
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $user = User::findOrFail($this->userId);
                $user->name = $this->name;
                $user->email = $this->email;

                if ($this->password) {
                    $user->password = Hash::make($this->password);
                }

                $user->save();
                $user->syncRoles([$this->selectedRole]);

                session()->flash('success', 'User updated successfully!');
            } else {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);

                $user->assignRole($this->selectedRole);

                session()->flash('success', 'User created successfully!');
            }

            $this->closeModal();
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving user: ' . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            // Prevent deleting yourself
            if ($id == auth()->id()) {
                session()->flash('error', 'You cannot delete your own account!');
                return;
            }

            $user = User::findOrFail($id);
            $user->delete();

            session()->flash('success', 'User deleted successfully!');
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting user: ' . $e->getMessage());
        }
    }

    public function updateUserRole($userId, $roleName)
    {
        try {
            $user = User::findOrFail($userId);
            $user->syncRoles([$roleName]);

            session()->flash('success', 'Role updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating role: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRole = '';
        $this->resetValidation();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }
}

