<x-layouts::app :title="__('User Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 bg-white dark:bg-neutral-900">
            <livewire:admin.user-management />
        </div>
    </div>
</x-layouts::app>

