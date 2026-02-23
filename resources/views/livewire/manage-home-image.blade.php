<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold mb-4">Manage Home Page Image</h2>

        @if ($currentImage)
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Current Image</h3>
                <img src="{{ $currentImage }}"
                     alt="Current home image"
                     class="w-full max-w-md h-auto object-cover rounded-lg border border-gray-300 dark:border-gray-600">
            </div>
        @endif

        <div class="space-y-4">
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Upload New Image
                </label>
                <input type="file"
                       id="image"
                       wire:model="image"
                       accept="image/*"
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">

                @error('image')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            @if ($image)
                <div class="mb-4">
                    <h3 class="text-lg font-semibold mb-2">Preview</h3>
                    <img src="{{ $image->temporaryUrl() }}"
                         alt="Image preview"
                         class="w-full max-w-md h-auto object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                </div>
            @endif

            <div class="flex gap-2">
                @if ($image)
                    <button wire:click="uploadImage"
                            wire:loading.attr="disabled"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:bg-gray-400 transition">
                        <span wire:loading.remove>Upload Image</span>
                        <span wire:loading>Uploading...</span>
                    </button>
                @endif

                @if ($currentImage)
                    <button wire:click="deleteImage"
                            wire:confirm="Are you sure you want to delete this image?"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Delete Current Image
                    </button>
                @endif
            </div>
        </div>

        @if (session()->has('success'))
            <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-lg">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
</div>

