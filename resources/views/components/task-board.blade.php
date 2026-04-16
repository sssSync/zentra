<div class="p-6 mt-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Global Task Board</h1>
        <button @click="$dispatch('open-task-modal')" type="button" class="bg-brand-green text-black hover:bg-brand-dim-green px-8 py-3 rounded-4xl text-sm font-bold transition dark:bg-brand-black-alt dark:hover:bg-brand-light-gray dark:hover:text-black dark:text-white ">
            <span>+ Add Task</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

            @php
$columns = [
    'Todo' => 'bg-gray-100 border-gray-200 text-gray-700',
    'In Progress' => 'bg-blue-50 border-blue-200 text-blue-700',
    'Complete' => 'bg-brand-green/10 border-brand-green/20 text-brand-green'
];
            @endphp

            @foreach($columns as $status => $theme)

                                                                                                                                                    @php

                $statusBg = match ($status) {
                    'Complete' => 'border-gray-100 dark:border-brand-black-alt/70 bg-complete',
                    'In Progress' => 'border-gray-100 dark:border-brand-black-alt/70 bg-progress',
                    default => 'border-gray-100 dark:border-[#63636330] bg-gray-50 dark:bg-brand-black-alt', // Todo / Default
                };
                                                                                                                                                    @endphp
                                                                                                                                                        <div x-data="{ isDraggingOver: false }"
                                                                                                                                                        wire:key="col-{{ $status }}"
                                                                                                                                                             @dragover.prevent="isDraggingOver = true"
                                                                                                                                                             @dragleave.prevent="isDraggingOver = false"
                                                                                                                                                             @drop="
                                                                                                                                                                isDraggingOver = false;
                                                                                                                                                                let taskId = event.dataTransfer.getData('text/plain');
                                                                                                                                                                                if (taskId) {
                                                                                                                                                                                    $wire.updateTaskStatus(taskId, '{{ $status }}');
                                                                                                                                                                                }
                                                                                                                                                             "

                                                                                                                                                            :class="isDraggingOver ? 'border-brand-dark bg-gray-100 dark:bg-brand-black dark:border-brand-black-alt/70 scale-[1.02]' : '{{ $statusBg }}'"

                                                                                                                                                             class="rounded-2xl p-4 border-2 transition-all duration-200 min-h-125 ">

                                                                                                                                                            <div class="flex justify-between items-center mb-4 px-2">
                                                                                                                                                                <h2 class="font-bold text-sm dark:text-white uppercase tracking-wider"
                                                                                                                                                            >{{ $status }}</h2>
                                                                                                                                                                <span class="bg-white text-gray-500 text-xs font-bold px-2 py-1 rounded-full shadow-sm">{{ count($tasks->get($status, [])) }}</span>
                                                                                                                                                            </div>

                                                                                                                                                            <div class="space-y-3">
                                                                                                                                                                @forelse($tasks->get($status, []) as $task)

                                                                                                                                                                    <div draggable="true" wire:key="task-{{ $task->id }}" @dragstart="
                                                                                                                                                                                                                    event.dataTransfer.setData('text/plain', {{ $task->id }});
                                                                                                                                                                                                                    event.target.classList.add('opacity-50', 'scale-95');
                                                                                                                                                                                                                 " @dragend="event.target.classList.remove('opacity-50', 'scale-95')"
                                                                                                                                                                        class="cursor-grab active:cursor-grabbing bg-white dark:bg-brand-black p-4 rounded-xl shadow-sm border border-gray-200 dark:border-[#d4d3d31a] hover:border-brand-green/50 hover:shadow-md transition-all relative group">

                                                                                                                                                                        <div class="flex justify-between items-start mb-1 gap-2">
                                                                                                                                                                            <h3 class="font-bold text-gray-900 dark:text-white leading-tight">{{ $task->title }}</h3>

                                                                                                                                                                            <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Are you sure you want to delete this task?"
                                                                                                                                                                                class="text-gray-300 group-hover:text-red-500 transition-opacity focus:opacity-100 shrink-0 mt-0.5">
                                                                                                                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                                                                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                                                                                                                                    </path>
                                                                                                                                                                                </svg>
                                                                                                                                                                            </button>
                                                                                                                                                                            </div>

                                                                                                                                                                            <div class="text-xs text-gray-500 mb-3 flex items-center gap-1">
                                                                                                                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                                                                                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                                                                                                                                </svg>
                                                                                                                                                                                {{ $task->contact->first_name }} {{ $task->contact->last_name }}
                                                                                                                                                                            </div>

                                                                                                                                                                            <div class="flex justify-between items-end mt-4">
                                                                                                                                                                                <div class="space-y-2">
                                                                                                                                                                                    @if($task->due_date)
                                                                                                                                                                                        <div
                                                                                                                                                                                            class="text-xs font-medium {{ \Carbon\Carbon::parse($task->due_date)->isPast() && $status !== 'Complete' ? 'text-red-500' : 'text-gray-500' }}">
                                                                                                                                                                                            Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                                                                                                                                                                        </div>
                                                                                                                                                                                    @endif

                                                                                                                                                                                    @if($task->interaction_id)
                                                                                                                                                                                        <button wire:click="viewInteraction({{ $task->interaction_id }})"
                                                                                                                                                                                            class="text-xs font-bold text-brand-green/70 bg-brand-green/10 hover:bg-brand-green/20 px-2 py-1 rounded transition flex items-center gap-1">
                                                                                                                                                                                            <span>🔗 View Interaction</span>
                                                                                                                                                                                        </button>
                                                                                                                                                                                    @endif
                                                                                                                                                                                </div>

                                                                                                                                                                                <div class="text-gray-300 group-hover:text-brand-green transition">
                                                                                                                                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                                                                                                                                                                    </svg>
                                                                                                                                                                                </div>
                                                                                                                                                                            </div>
                                                                                                                                                                            </div>
                                                                                                                                                                @empty
                                                                                                                                                                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center text-sm text-gray-400">
                                                                                                                                                                        Drop tasks here.
                                                                                                                                                                    </div>
                                                                                                                                                                @endforelse
                                                                                                                                                                            </div>
                                                                                                                                                                            </div>
            @endforeach
        </div>

    @if($isModalOpen && $selectedInteraction)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm">

            <div
                class="bg-white dark:bg-brand-black rounded-3xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl animate-fade-in-up">
                <div
                    class="flex justify-between items-center p-6 border-b border-gray-100  dark:border-brand-gray/10 bg-gray-50 dark:bg-brand-black">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-brand-gray flex items-center gap-2">
                        <span
                            class="bg-brand-green text-white dark:text-brand-black text-xs px-2 py-1 rounded-md uppercase tracking-wider">{{ $selectedInteraction->type }}</span>
                        Interaction Details
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400  hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="p-6">
                    <div class="mb-4">
                        <p class="text-sm font-bold text-gray-500 dark:text-brand-light-gray/40 uppercase tracking-wider mb-1">
                            With Contact</p>
                        <p class="text-gray-900 dark:text-brand-gray font-medium">
                            {{ $selectedInteraction->contact->first_name }}
                            {{ $selectedInteraction->contact->last_name }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm font-bold text-gray-500 dark:text-brand-light-gray/40 uppercase tracking-wider mb-1">
                            Date Logged</p>
                        <p class="text-gray-900 dark:text-brand-gray font-medium">
                            {{ \Carbon\Carbon::parse($selectedInteraction->interaction_date)->format('F j, Y @ g:i a') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-brand-light-gray/40 uppercase tracking-wider mb-2">
                            Notes / Content
                        </p>
                        <div
                            class="bg-gray-50 dark:bg-brand-black-alt p-4 rounded-xl border border-gray-100 dark:border-brand-gray/10 text-gray-800 dark:text-brand-light-gray/70 whitespace-pre-wrap text-sm leading-relaxed">
                            {{ $selectedInteraction->content }}
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 dark:border-brand-gray/10 bg-gray-50 dark:bg-brand-black flex justify-end">
                    <button wire:click="closeModal"
                        class="bg-gray-200 dark:bg-brand-black-alt text-gray-800 dark:text-brand-gray font-bold py-2 px-6 rounded-xl hover:bg-gray-300 dark:hover:text-brand-black transition">Close
                        Window</button>
                </div>
            </div>
        </div>
    @endif
    <livewire:create-task-modal />
</div>
