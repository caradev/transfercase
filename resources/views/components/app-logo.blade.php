@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Transfercase Unlimited" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            TU
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Transfercase Unlimited" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            TU
        </x-slot>
    </flux:brand>
@endif
