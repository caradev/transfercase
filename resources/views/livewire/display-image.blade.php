<div>
    @if ($imageUrl)
        <img src="{{ $imageUrl }}"
             alt="Home display image"
             class="w-full h-auto object-cover rounded-lg">
    @else
        <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
            <span class="text-gray-500 dark:text-gray-400">No image available</span>
        </div>
    @endif
</div>

