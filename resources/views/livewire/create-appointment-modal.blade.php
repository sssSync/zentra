<div>
    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-brand-black rounded-3xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl animate-fade-in-up">

                <div class="flex justify-between items-center p-6 border-b border-gray-100 dark:border-none ">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-brand-gray">Schedule Meeting</h3>
                    <button wire:click="$set('isOpen', false)" type="button" class="text-gray-400 hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form wire:submit="save" class="p-6 space-y-4">

                    @if (session()->has('success'))
                        <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Select Contact *</label>
                        <select wire:model="contact_id" class="text-black dark:text-brand-light-gray w-full px-4 py-2 border border-gray-300 dark:border-brand-black-alt rounded-xl focus:ring-2 focus:ring-brand-dark outline-none text-sm bg-white dark:bg-brand-black-alt cursor-pointer">
                            <option value="">-- No Contact (Internal) --</option>
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->first_name }} {{ $contact->last_name }}</option>
                            @endforeach
                        </select>
                        @error('contact_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Meeting Title *</label>
                        <input type="text" wire:model="title" placeholder="e.g. Product Demo" class="text-black dark:text-brand-light-gray w-full px-4 py-2 border border-gray-300 dark:border-brand-black-alt rounded-xl focus:ring-2 focus:ring-brand-dark outline-none text-sm dark:bg-brand-black-alt">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Date & Time *</label>
                        <input type="datetime-local" wire:model="scheduled_at" class="text-black dark:text-brand-light-gray w-full px-4 py-2 border border-gray-300 dark:border-brand-black-alt rounded-xl focus:ring-2 focus:ring-brand-dark outline-none text-sm cursor-pointer dark:bg-brand-black-alt">
                        @error('scheduled_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-100/30 mt-6 flex justify-end gap-3">
                        <button type="button" wire:click="$set('isOpen', false)" class="bg-gray-100 dark:bg-brand-black-alt text-gray-700 dark:text-gray-100/60 font-bold py-2 px-4 rounded-xl hover:bg-gray-200 dark:hover:bg-mauve-700 transition text-sm">Cancel</button>
                        <button type="submit" class="bg-brand-dark dark:bg-brand-light text-white dark:text-brand-black-alt font-bold py-2 px-6 rounded-xl hover:bg-black dark:hover:text-white transition text-sm">Schedule Meeting</button>
                    </div>
                </form>

            </div>
        </div>
    @endif
</div>



