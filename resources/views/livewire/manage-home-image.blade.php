<div class="space-y-6">
    @if ($canManage)
        <div>
            <flux:heading size="xl">Manage Home Page Image</flux:heading>
            <flux:subheading>Upload or delete the home page hero image.</flux:subheading>

            @if ($currentImage)
                <div class="my-6">
                    <flux:label>Current Image</flux:label>
                    <img src="{{ $currentImage }}"
                         alt="Current home image"
                         class="w-full max-w-md h-auto object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <flux:input type="file"
                           id="image"
                           wire:model="image"
                           accept="image/*"
                           label="Upload New Image"
                           placeholder="Choose an image..." />
                </div>

                @if ($image)
                    <div class="mb-4">
                        <flux:label>Preview</flux:label>
                        <img src="{{ $image->temporaryUrl() }}"
                             alt="Image preview"
                             class="w-full max-w-md h-auto object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                    </div>
                @endif

                <div class="flex gap-2">
                    @if ($image)
                        <flux:button wire:click="uploadImage"
                                wire:loading.attr="disabled"
                                variant="primary">
                            <span wire:loading.remove>Upload Image</span>
                            <span wire:loading>Uploading...</span>
                        </flux:button>
                    @endif

                    @if ($currentImage)
                        <flux:button wire:click="deleteImage"
                                wire:confirm="Are you sure you want to delete this image?"
                                variant="danger">
                            Delete Current Image
                        </flux:button>
                    @endif
                </div>
            </div>

            @if (session()->has('success'))
                <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-lg">
                    {{ session()->get('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <flux:heading size="lg" class="mt-2">Welcome to your dashboard</flux:heading>
            <flux:subheading class="mt-1">You don't have any management permissions yet.</flux:subheading>
        </div>
    @endif
</div>

