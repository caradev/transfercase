<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <flux:heading size="xl">Contact Inquiries</flux:heading>
            <flux:subheading>
                Manage and respond to customer inquiries
                @if($unreadCount > 0)
                    <flux:badge color="orange" size="sm" class="ml-2">
                        {{ $unreadCount }} unread
                    </flux:badge>
                @endif
            </flux:subheading>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 bg-red-100 text-red-700 rounded-lg border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    {{-- Search and Filter --}}
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <flux:input wire:model.live.debounce.300ms="search"
                       placeholder="Search inquiries..."
                       icon="magnifying-glass" />
        </div>
        <div class="sm:w-48">
            <select wire:model.live="filterRead"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                <option value="">All Inquiries</option>
                <option value="unread">Unread</option>
                <option value="read">Read</option>
            </select>
        </div>
    </div>

    {{-- Inquiries Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Subject
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($inquiries as $inquiry)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 {{ !$inquiry->is_read ? 'bg-orange-50 dark:bg-orange-900/10' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($inquiry->is_read)
                                    <flux:badge color="gray" size="sm">Read</flux:badge>
                                @else
                                    <flux:badge color="orange" size="sm">New</flux:badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $inquiry->name }}
                                </div>
                                @if($inquiry->phone)
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $inquiry->phone }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $inquiry->email }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                {{ Str::limit($inquiry->subject ?? 'No subject', 30) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $inquiry->created_at->format('M d, Y') }}
                                <div class="text-xs">{{ $inquiry->created_at->format('g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <flux:button wire:click="viewInquiry({{ $inquiry->id }})" variant="ghost" size="sm">
                                    View
                                </flux:button>
                                <flux:button wire:click="toggleRead({{ $inquiry->id }})" variant="ghost" size="sm">
                                    {{ $inquiry->is_read ? 'Unread' : 'Read' }}
                                </flux:button>
                                <flux:button wire:click="deleteInquiry({{ $inquiry->id }})"
                                            wire:confirm="Are you sure you want to delete this inquiry?"
                                            variant="ghost" color="red" size="sm">
                                    Delete
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                No inquiries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $inquiries->links() }}
    </div>

    {{-- View Modal --}}
    <flux:modal wire:model="showModal" class="max-w-2xl">
        @if($selectedInquiry)
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Contact Inquiry Details</flux:heading>
                    <flux:subheading>Information received from {{ $selectedInquiry->name }}</flux:subheading>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <flux:label>Name</flux:label>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $selectedInquiry->name }}</p>
                    </div>

                    <div class="space-y-1">
                        <flux:label>Email</flux:label>
                        <p class="text-sm">
                            <a href="mailto:{{ $selectedInquiry->email }}" class="text-blue-600 hover:underline">
                                {{ $selectedInquiry->email }}
                            </a>
                        </p>
                    </div>

                    @if($selectedInquiry->phone)
                        <div class="space-y-1">
                            <flux:label>Phone</flux:label>
                            <p class="text-sm">
                                <a href="tel:{{ $selectedInquiry->phone }}" class="text-blue-600 hover:underline">
                                    {{ $selectedInquiry->phone }}
                                </a>
                            </p>
                        </div>
                    @endif

                    <div class="space-y-1">
                        <flux:label>Received</flux:label>
                        <p class="text-sm text-gray-900 dark:text-white">
                            {{ $selectedInquiry->created_at->format('F d, Y \a\t g:i A') }}
                            <span class="text-gray-500 text-xs">({{ $selectedInquiry->created_at->diffForHumans() }})</span>
                        </p>
                    </div>
                </div>

                @if($selectedInquiry->subject)
                    <div class="space-y-1">
                        <flux:label>Subject</flux:label>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $selectedInquiry->subject }}</p>
                    </div>
                @endif

                <div class="space-y-1">
                    <flux:label>Message</flux:label>
                    <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg text-sm text-gray-900 dark:text-white whitespace-pre-wrap border border-gray-200 dark:border-gray-700">
                        {{ $selectedInquiry->message }}
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <flux:button wire:click="deleteInquiry({{ $selectedInquiry->id }})"
                                wire:confirm="Are you sure you want to delete this inquiry?"
                                variant="filled" color="red">
                        Delete
                    </flux:button>
                    <flux:button wire:click="toggleRead({{ $selectedInquiry->id }})" variant="filled">
                        Mark as {{ $selectedInquiry->is_read ? 'Unread' : 'Read' }}
                    </flux:button>
                    <flux:modal.close>
                        <flux:button variant="ghost">Close</flux:button>
                    </flux:modal.close>
                </div>
            </div>
        @endif
    </flux:modal>
</div>

