
<div>
    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-brand-black rounded-3xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl animate-fade-in-up">

                <div class="flex justify-between items-center p-6 border-b border-gray-100  dark:border-none ">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-brand-light-gray">Add New Task</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form wire:submit="save" class="p-6 space-y-4">

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Task Title *</label>
                        <input type="text" wire:model="title" placeholder="e.g. Send pricing proposal" class="text-black  dark:text-brand-light-gray w-full px-4 py-2 border border-gray-300 dark:border-brand-black-alt rounded-xl focus:ring-2 focus:ring-brand-dark outline-none text-sm dark:bg-brand-black-alt ">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    @if(!$is_prefilled_contact)
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Related Contact *</label>
                            <select wire:model.live="contact_id" class="text-black  dark:text-brand-light-gray w-full px-4 py-2 border border-gray-300 dark:border-brand-black-alt rounded-xl focus:ring-2 focus:ring-brand-dark outline-none text-sm bg-white dark:bg-brand-black-alt  cursor-pointer">
                                <option value="">-- Select a Contact --</option>
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}">{{ $contact->first_name }} {{ $contact->last_name }}</option>
                                @endforeach
                            </select>
                            @error('contact_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Due Date</label>
                            <input type="date" wire:model="due_date" class="text-black   dark:text-brand-light-gray w-full px-4 py-2 border border-gray-300 dark:border-brand-black-alt rounded-xl focus:ring-2 focus:ring-brand-dark outline-none text-sm cursor-pointer dark:bg-brand-black-alt ">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Link to Interaction</label>
                            <select wire:model="interaction_id" class="text-black  dark:text-brand-light-gray w-full px-4 py-2 border border-gray-300 dark:border-brand-black-alt rounded-xl focus:ring-2 focus:ring-brand-dark outline-none text-sm bg-white dark:bg-brand-black-alt  cursor-pointer" {{ empty($interactions) ? 'disabled' : '' }}>
                                <option value="">-- No Link --</option>
                                @foreach($interactions as $interaction)
                                    <option value="{{ $interaction->id }}">{{ \Carbon\Carbon::parse($interaction->interaction_date)->format('M d') }} - {{ $interaction->type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-100/30 mt-6 flex justify-end gap-3">
                        <button type="button" wire:click="closeModal" class="bg-gray-100 dark:bg-brand-black-alt text-gray-700 dark:text-gray-100/60 font-bold py-2 px-4 rounded-xl hover:bg-gray-200 dark:hover:bg-mauve-700 transition text-sm">Cancel</button>
                        <button type="submit" class="bg-brand-dark dark:bg-brand-light text-white dark:text-brand-black-alt font-bold py-2 px-6 rounded-xl hover:bg-black transition text-sm dark:hover:text-white " >Save Task</button>
                    </div>
                </form>

            </div>
        </div>
    @endif
</div>
