<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div class="max-w-7xl mx-auto p-6 mt-4">

    <div class="flex justify-between items-start mb-4 bg-white dark:bg-brand-black-alt p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-brand-gray/20">
        <div class="flex items-center gap-4">
            <div
                class="w-16 h-16 bg-brand-green/20 text-brand-green rounded-full flex items-center justify-center text-2xl font-bold uppercase overflow-hidden">
                <img src="{{ $contact->avatar_url }}" alt="Profile Image" class="w-full h-full object-cover">
            </div>
            <div>
                <h1 class="text-2xl font-bold text-brand-dark dark:text-brand-light">{{ $first_name }} {{ $last_name }}</h1>
                <p class="text-gray-500 dark:text-brand-light-gray/60">{{ $job_title ?? 'No Title' }} @if($company_name) at <span class="font-medium text-gray-700 dark:text-green-200">{{ $company_name }}</span> @endif</p>
            </div>
        </div>

        <button
            wire:click="delete"
            wire:confirm="Are you absolutely sure you want to delete this lead? This cannot be undone."
            class="bg-red-50 dark:bg-red-900/40 dark:border-red-800/50 dark:border text-red-600 hover:bg-red-100 hover:text-red-700 px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            Delete Lead
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-brand-green/10 border border-brand-green/20 text-brand-green rounded-xl font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col gap-4">

        {{-- <div class="s"> --}}
            <form wire:submit="update" class="w-full flex gap-4 ">
                <div class="grow bg-white dark:bg-brand-black-alt dark:border-none p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h2 class="text-sm font-bold text-gray-900 dark:text-brand-gray mb-4 uppercase tracking-wider border-b border-gray-100 pb-2">Contact Info</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">First *</label>
                                <input type="text" wire:model="first_name" class="text-black w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none text-sm dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-brand-light-gray/80">Last</label>
                                <input type="text" wire:model="last_name" class="text-black w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none text-sm dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-brand-light-gray/80">Email</label>
                            <input type="email" wire:model="email" class="text-black w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none text-sm dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-brand-light-gray/80">Phone</label>
                            <input type="text" wire:model="phone" class="text-black w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none text-sm dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-brand-light-gray/80">Status</label>
                            <select wire:model="status" class="text-black w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none text-sm bg-white dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40">
                                <option value="Lead">Lead</option>
                                <option value="Customer">Customer</option>
                                <option value="Competitor">Competitor</option>
                                <option value="Ex-Customer">Ex-Customer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grow bg-white p-6 rounded-3xl shadow-sm border border-gray-100 dark:bg-brand-black-alt dark:border-none">
                    <h2 class="text-sm font-bold text-gray-900 dark:text-brand-gray mb-4 uppercase tracking-wider border-b border-gray-100 pb-2">Company Info</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-brand-light-gray/80">Name</label>
                            <input type="text" wire:model="company_name" class="text-black w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none text-sm dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-brand-light-gray/80">Industry</label>
                            <input type="text" wire:model="company_industry" class="text-black w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none text-sm dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-brand-light-gray/80">Website</label>
                            <input type="text" wire:model="company_website" class="text-black w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none text-sm dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40">
                        </div>
                        <button type="submit" class="w-full bg-brand-dark text-white font-bold py-2.5 rounded-xl hover:bg-brand-dim-green transition shadow-md text-sm mt-4 dark:text-brand-black dark:bg-brand-green">
                            <span wire:loading.remove>Update Details</span>
                            <span wire:loading>Saving...</span>
                        </button>
                    </div>
                </div>
            </form>
        {{-- </div> --}}

        <div class="flex gap-6">

            <div class="grow bg-white p-6 rounded-3xl shadow-sm border border-gray-100 dark:bg-brand-black-alt dark:border-none">
                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-2">
                    <h2 class="font-bold text-gray-900  dark:text-brand-gray uppercase tracking-wider text-sm">Active Deals</h2>

                    <button @click="$dispatch('open-deal-modal', { contactId: {{ $contact->id }} })" type="button" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-6 py-2 rounded-3xl text-sm font-bold transition ">
                        Add Deal
                    </button>
                </div>



                <div class="space-y-3">
                    @forelse($contact->deals as $deal)
                        <div class="p-4 border border-gray-100 dark:border-brand-dim-green/10 dark:bg-brand-black  rounded-xl hover:border-brand-green/30 transition flex justify-between items-center group">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-brand-gray">{{ $deal->name }}</h4>
                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-3">
                                    <span class="bg-gray-100 dark:bg-brand-light/40 dark:backdrop-blur-2xl dark:text-lime-100 px-4 py-1 rounded-full font-semibold text-gray-700">{{ $deal->stage }}</span>
                                    @if($deal->expected_close_date)
                                        <span>Closes: {{ \Carbon\Carbon::parse($deal->expected_close_date)->format('M d, Y') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-black text-lg text-brand-dark dark:text-white">
                                    @if($deal->amount)
                                        ${{ number_format($deal->amount, 2) }}
                                    @else
                                        --
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400 text-sm">
                            No active deals yet. Click "Add Deal" to add one.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="grow bg-white p-6 rounded-3xl shadow-sm border border-gray-100 dark:bg-brand-black-alt dark:border-none">

                            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                                <h2 class="font-bold text-gray-900 dark:text-brand-gray uppercase tracking-wider text-sm">Activity & Tasks</h2>
                                <div class="flex gap-2">
                                    <button wire:click="toggleInteractionForm" class="{{ $is_logging_interaction ? 'bg-brand-dim-green text-black' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} px-6 py-2 rounded-3xl text-sm font-bold transition">
                                      {{ $is_logging_interaction ? "Close" : "Log Note" }}
                                    </button>
                                    <button  @click="$dispatch('open-task-modal', { contactId: {{ $contact->id }} })" type="button"  class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-6 py-2 rounded-3xl text-sm font-bold transition">
                                        Add Task
                                    </button>
                                </div>
                            </div>

                            @if($is_logging_interaction)
                                <form wire:submit="saveInteraction" class="mb-8 bg-brand-green/5 p-5 rounded-2xl border border-brand-green/20 space-y-4">
                                    <div class="flex gap-4">
                                        <div class="w-1/3">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                                            <select wire:model="interaction_type" class="text-black w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brand-green outline-none text-sm bg-white dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40">
                                                <option value="Note">📝 Note</option>
                                                <option value="Call">📞 Call</option>
                                                <option value="Email">✉️ Email</option>
                                                <option value="Meeting">🤝 Meeting</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Details *</label>
                                        <textarea wire:model="interaction_content" rows="3" placeholder="What happened?" class="text-black w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brand-green outline-none text-sm dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40"></textarea>
                                        @error('interaction_content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <button type="submit" class="bg-brand-green text-black font-bold py-2 px-6 rounded-xl hover:bg-lime-700 transition text-sm">Save Log</button>
                                </form>
                            @endif

                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-brand-gray/80 mb-4 ">Timeline</h3>
                                @if($contact->interactions->count() > 0)
                                    <div class="relative border-l-2 border-gray-100 dark:border-gray-100/50 ml-3 space-y-6 pb-4">
                                        @foreach($contact->interactions as $log)
                                            <div class="relative pl-6">
                                                <div class="absolute -left-2.25 top-1 w-4 h-4 rounded-full border-2 border-white {{ $log->type == 'Call' ? 'bg-blue-500' : ($log->type == 'Email' ? 'bg-purple-500' : ($log->type == 'Meeting' ? 'bg-brand-green' : 'bg-gray-400')) }}"></div>

                                                <div class="note-tab p-4 rounded-xl border border-gray-100 {{ $log->type == 'Call' ? 'note-call-tab' : ($log->type == 'Email' ? 'note-email-tab' : ($log->type == 'Meeting' ? 'note-meeting-tab' : 'note-normal-tab')) }}">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <span class="text-xs font-bold text-gray-700 dark:text-brand-gray uppercase tracking-widest">{{ $log->type }}</span>
                                                        <span class="text-xs text-gray-400 dark:text-brand-light-gray/50">{{ \Carbon\Carbon::parse($log->interaction_date)->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-800 dark:text-brand-gray/70 whitespace-pre-wrap">{{ $log->content }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-6 text-gray-400 text-sm border-2 border-dashed border-gray-100 rounded-xl">
                                        No interactions logged yet. Break the ice!
                                    </div>
                                @endif
                            </div>

                        </div>

        </div>
    </div>
<livewire:create-task-modal/>
<livewire:create-deal-modal />
</div>
