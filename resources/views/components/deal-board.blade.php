<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div class="px-4 p-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Revenue Pipeline</h1>
        <button @click="$dispatch('open-deal-modal')" type="button"
            class="bg-brand-green text-black dark:text-white font-bold px-8 py-3 rounded-4xl hover:bg-brand-dim-green dark:hover:bg-brand-light-gray dark:hover:text-black transition flex items-center gap-2 dark:bg-brand-black-alt">
            <span>+ Add Deal</span>
        </button>
    </div>

    <div class="flex flex-col gap-6 overflow-x-auto pb-8 items-start snap-x">

        @php
            $stages = [

                'Discovery' => 'bg-gray-100! border-gray-200 text-gray-700',
                'Proposal' => 'bg-blue-50! border-blue-200 text-blue-700',
                'Negotiation' => 'bg-purple-50 border-purple-200 text-purple-700',
                'Closed Won' => 'bg-brand-green/10 border-brand-green/30 text-brand-green',
                'Closed Lost' => 'bg-red-50 border-red-200 text-red-600'
            ];
        @endphp

        @foreach($stages as $stage => $theme)
            @php
                // Calculate the total money in this column
                $columnDeals = $deals->get($stage, []);
                $columnTotal = collect($columnDeals)->sum('amount');
            @endphp

            <div wire:key="col-{{ Str::slug($stage) }}" x-data="{ isDraggingOver: false }"
                @dragover.prevent="isDraggingOver = true" @dragleave.prevent="isDraggingOver = false" @drop.prevent="
                                isDraggingOver = false;
                                let dealId = event.dataTransfer.getData('text/plain');
                                if (dealId) { $wire.updateDealStage(dealId, '{{ $stage }}'); }
                             "
                :class="isDraggingOver ? 'border-brand-dark bg-gray-100 dark:bg-brand-black dark:border-brand-black-alt/70 scale-[1.02]' : 'border-gray-100 dark:border-brand-black-alt/70 bg-gray-50 dark:bg-brand-black-alt'"
                class="min-w-[320px] w-full rounded-2xl p-4 border-2 transition-all duration-200  snap-center shrink-0">

                <div class="mb-4 px-2 border-b border-gray-200 dark:border-brand-gray/60 dark:border-b-2 pb-3">
                    <div class="flex justify-between items-center mb-1">
                        <h2
                            class="font-bold dark:text-brand-gray text-sm uppercase tracking-wider {{ str_replace('bg-', 'text-', explode(' ', $theme)[0]) }}">
                            {{ $stage }}</h2>
                        <span
                            class="bg-white text-gray-500 text-xs font-bold px-2 py-1 rounded-full shadow-sm">{{ count($columnDeals) }}</span>
                    </div>
                    <div class="text-lg font-black text-gray-900 dark:text-white mt-2">
                        ${{ number_format($columnTotal, 2) }}
                    </div>
                </div>

                <div class="flex gap-3 overflow-x-scroll items-start pb-4">
                    @forelse($columnDeals as $deal)

                        <div wire:key="deal-{{ $deal->id }}" draggable="true" @dragstart="
                                                event.dataTransfer.setData('text/plain', '{{ $deal->id }}');
                                                event.target.classList.add('opacity-50', 'scale-95');
                                             " @dragend="event.target.classList.remove('opacity-50', 'scale-95')"
                            class="cursor-grab active:cursor-grabbing bg-brand-light-gray dark:bg-brand-black  max-w-1/3 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-brand-black hover:border-brand-green/50 hover:shadow-md transition-all relative group min-w-60">

                            <div class="flex justify-between items-start mb-2 cursor-pointer"
                                wire:click="viewDeal({{ $deal->id }})">
                                <h3 class="font-bold text-gray-900 dark:text-white leading-tight pr-4">{{ $deal->name }}</h3>
                                <div class="text-gray-300 group-hover:text-brand-green transition shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8h16M4 16h16"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="text-xs text-gray-500 dark:text-brand-light-gray mb-3 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $deal->contact->first_name }} {{ $deal->contact->last_name }}
                            </div>

                            <div
                                class="flex justify-between items-end mt-4 pt-3 border-t border-gray-50 dark:border-brand-light-gray/50 ">
                                <div class="text-xs font-medium text-gray-500 dark:text-brand-light-gray ">
                                    @if($deal->expected_close_date)
                                        Closes: {{ \Carbon\Carbon::parse($deal->expected_close_date)->format('M d') }}
                                    @else
                                        No Date
                                    @endif
                                </div>
                                <div class="font-black text-brand-dark text-base">
                                    ${{ number_format($deal->amount, 2) }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center text-sm text-gray-400 dark:text-brand-light-gray ">
                            No deals in this stage.
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
    @if($isViewModalOpen && $selectedDeal)
        <div class="fixed inset-0 z-60 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm">
            <div
                class="bg-white dark:bg-brand-black-alt rounded-3xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl animate-fade-in-up">

                <div
                    class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50 dark:bg-brand-black-alt">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white flex items-center gap-2">
                        <span
                            class="bg-brand-dark text-white dark:bg-brand-light dark:text-black text-xs px-2 py-1 rounded-md uppercase tracking-wider">{{ $selectedDeal->stage }}</span>
                        Deal Details
                    </h3>
                    <button wire:click="closeViewModal" class="text-gray-400 hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-brand-light-gray uppercase tracking-wider mb-1">
                            Deal Name</p>
                        <p class="text-xl font-black text-gray-900 dark:text-brand-gray ">{{ $selectedDeal->name }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-brand-green/5 p-4 rounded-xl border border-brand-green/10">
                            <p class="text-sm font-bold text-brand-green uppercase tracking-wider mb-1">Amount</p>
                            <p class="text-brand-dark dark:text-brand-gray font-black text-2xl">
                                ${{ number_format($selectedDeal->amount, 2) }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-brand-black p-4 rounded-xl border  border-gray-100 dark:border-none">
                            <p
                                class="text-sm font-bold text-gray-500 dark:text-brand-light-gray uppercase tracking-wider mb-1">
                                Expected Close</p>
                            <p class="text-gray-900 font-bold text-lg dark:text-brand-gray ">
                                {{ $selectedDeal->expected_close_date ? \Carbon\Carbon::parse($selectedDeal->expected_close_date)->format('M d, Y') : 'No Date Set' }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p
                            class="text-sm font-bold text-gray-500 dark:text-brand-light-gray  uppercase tracking-wider mb-2">
                            Associated Contact</p>
                        <div
                            class="bg-gray-50 dark:bg-brand-black p-4 rounded-xl border border-gray-100 dark:border-none flex items-center gap-4">
                            <div
                                class="bg-gray-200 text-gray-600 rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg">
                                {{ substr($selectedDeal->contact->first_name, 0, 1) }}{{ substr($selectedDeal->contact->last_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-brand-gray font-bold text-lg">
                                    {{ $selectedDeal->contact->first_name }} {{ $selectedDeal->contact->last_name }}</p>
                                <p class="text-sm text-gray-500 dark:text-brand-light-gray">
                                    {{ $selectedDeal->contact->email ?? 'No email on file' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="p-6 border-t border-gray-100 bg-gray-50 dark:bg-brand-black-alt  flex justify-between items-center">
                    <button wire:click="deleteDeal({{ $selectedDeal->id }})"
                        wire:confirm="Are you sure you want to delete this deal? This action cannot be undone."
                        class="text-red-500 dark:bg-red-500/30  hover:text-red-700 dark:hover:text-red-500  hover:bg-red-50 dark:hover:bg-red-400/50 px-3 py-2 rounded-lg font-bold text-sm flex items-center gap-1 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Delete Deal
                    </button>

                    <button wire:click="closeViewModal"
                        class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-xl hover:bg-gray-300 transition">Close
                        Window</button>
                </div>
            </div>
        </div>
    @endif
    <livewire:create-deal-modal />
</div>
