<div class="max-w-8xl mx-auto p-6 pt-0">
    <div class="flex justify-end items-center mb-8">
        <button @click="$dispatch('open-appointment-modal')" type="button"
            class="bg-brand-green text-black dark:text-white font-bold px-8 py-3 rounded-4xl hover:bg-brand-dim-green dark:hover:bg-brand-light-gray dark:hover:text-black transition flex items-center gap-2 dark:bg-brand-black-alt">
            <flux:icon.calendar /> <span>Add Meeting</span>
            </button>
            </div>
    <div
        class="bg-white dark:bg-brand-black-alt rounded-3xl shadow-sm border border-gray-100 dark:border-gray-100/20 dark:border-2 overflow-hidden">

        <div
            class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-brand-gray/50 bg-gray-50/50 dark:bg-brand-black-alt">
            <h2 class="text-xl font-bold text-gray-900 dark:text-brand-gray">{{ $currentDateStr }}</h2>
            <div class="flex space-x-2">
                <button wire:click="previousMonth"
                    class="p-2 rounded-xl hover:bg-gray-200 text-gray-600 dark:text-brand-light-gray transition dark:hover:text-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
                <button wire:click="nextMonth"
                    class="p-2 rounded-xl hover:bg-gray-200 text-gray-600 dark:text-brand-light-gray transition dark:hover:text-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div
            class="grid grid-cols-7 border-b border-gray-100 dark:border-brand-gray/50 bg-gray-50 dark:bg-brand-black-alt text-center text-xs font-bold text-gray-500 dark:text-brand-light-gray uppercase tracking-wider  py-3">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
        </div>

        <div class="grid grid-cols-7 bg-gray-100 dark:bg-brand-gray/40 gap-px">
            @foreach($days as $day)
                <div
                    class="min-h-30 valid-day rounded-lg p-2 transition hover:bg-gray-50 dark:hover:bg-brand-black {{ $day['isToday'] ? 'today-day' : (!$day['isCurrentMonth'] ? 'bg-gray-50/50 text-gray-400 dark:text-brand-light-gray/20 dark:opacity-80 invalid-day' : '') }}">

                    <div class="flex justify-between items-start mb-2">
                        <span
                            class="text-base font-medium {{ $day['isToday'] ? 'bg-brand-green text-white dark:text-black h-7 w-7 flex items-center justify-center rounded-full' : 'text-gray-700 dark:text-brand-light-gray p-1' }}">
                            {{ $day['dayNumber'] }}
                        </span>
                    </div>

                    <div class="space-y-1 overflow-y-auto max-h-20 no-scrollbar">
                        @foreach($day['appointments'] as $apt)
                                    <div class="px-2 py-1 text-sm rounded-lg bg-brand-green/10 dark:bg-brand-green/30
                            dark:text-brand-green text-brand-dark border border-lime-400/50 truncate"
                                        title="{{ $apt->title }} with {{ $apt->contact->first_name }}">
                                            <span class="font-bold">{{ \Carbon\Carbon::parse($apt->scheduled_at)->format('g:ia') }}</span>
                                            {{ $apt->title }}
                                        </div>
                        @endforeach
                    </div>

                </div>
            @endforeach
        </div>

    </div>

    <livewire:create-appointment-modal />
</div>
