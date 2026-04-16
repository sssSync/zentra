<div class="p-6 bg-white dark:bg-brand-black min-h-screen">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white ">Your Sales Analysis</h1>
        <div class="text-sm text-gray-500 dark:text-white/80 font-bold">
            {{ now()->format('l, F j, Y') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-black text-white dark:bg-brand-black-alt p-6 rounded-3xl shadow-lg relative overflow-hidden">
            <p class="text-sm opacity-70">Today revenue</p>
            <h2 class="text-4xl font-bold mt-2">${{ number_format($todayRevenue / 1000, 1) ?? 0 }}k</h2>
            <p class="text-xs mt-4 dark:text-white opacity-50">Payout scheduled soon</p>
            <div class="absolute top-4 right-4 bg-white/20 dark:bg-white text-black p-2 rounded-full">
                <!-- <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> -->
                <flux:icon.arrow-up />

            </div>
        </div>

        <div
            class="bg-white dark:bg-brand-black-alt p-6 rounded-3xl shadow-sm border dark:border-none border-gray-100 relative">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500 dark:text-white/70">Calls</p>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($callCount) ?? 0 }}
                    </h2>
                </div>
                <div class="absolute top-4 right-4 bg-white/20 dark:bg-white text-black p-2 rounded-full">📞</div>
            </div>
        </div>

        <div
            class="bg-white dark:bg-brand-black-alt p-6 rounded-3xl shadow-sm border dark:border-none border-gray-100 relative">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500 dark:text-white/70">Emails</p>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($emailCount) ?? 0 }}
                    </h2>
                </div>
                <div class="absolute top-4 right-4 bg-white/20 dark:bg-white text-black p-2 rounded-full">
                    <flux:icon.envelope />
                </div>

            </div>
        </div>

    </div>

    <div class="mt-8">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Command Center</h1>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div
                class="bg-white dark:bg-brand-black-alt p-6 rounded-2xl shadow-sm border dark:border-none border-gray-100 flex flex-col justify-center">
                <p class="text-sm font-semibold text-gray-500 dark:text-brand-gray uppercase tracking-wider mb-1">Total
                    Pipeline Value</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($pipelineTotal, 2) }}</p>
            </div>

            <div
                class="bg-brand-green/5 p-6 rounded-2xl shadow-sm border border-brand-green/20 flex flex-col justify-center">
                <p class="text-sm font-bold text-brand-green uppercase tracking-wider mb-1">Revenue Won</p>
                <p class="text-3xl font-black text-brand-dar dark:text-white">${{ number_format($wonTotal, 2) }}</p>
            </div>

            <div class="bg-red-50 p-6 rounded-2xl shadow-sm border border-red-100 flex flex-col justify-center">
                <p class="text-sm font-bold text-red-500 uppercase tracking-wider mb-1">Tasks Due Today / Overdue</p>
                <p class="text-3xl font-black text-red-600">{{ $tasksToday->count() }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                <div
                    class="bg-white dark:bg-brand-black-alt p-6 rounded-2xl shadow-sm border dark:border-none border-gray-100">
                    <h2 class="font-bold text-lg text-gray-900 dark:text-brand-gray mb-6">Pipeline by Stage</h2>

                    <div class="w-full h-75 dark:text-brand-gray/50" x-data="{
                            init() {
                               const isDark = document.documentElement.classList.contains('dark');
                        const textColor = isDark ? '#9ca3af' : '#6b7280';
const gridColor = isDark ? '#e3e3e320' : 'rgba(0, 0, 0, 0.1)';
                                new Chart(this.$refs.canvas, {
                                    type: 'bar',
                                    data: {
                                        labels: {{ Js::from($chartLabels) }},
                                        datasets: [{
                                            label: 'Value($)',
                                            data: {{ Js::from($chartValues) }},
                                            backgroundColor: ['#59677c', '#92f6ff', '#6d2ed2', '#4de582', '#eb5b5b'],
                                            borderColor: ['#818ea17f', '#bfdbfe', '#b377f4a8', '#bbf7d0', '#ef5959'],
                                            borderWidth: 2,
                                            borderRadius: 8
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: { legend: { display: false } },
                                        scales: {
                                                y: { beginAtZero: true,
                                                    grid: { color: gridColor },
                                                    ticks: { callback: function(value) { return '$' + value; } ,color: textColor }
                                                },
                                                x: {
                                                  grid: { color: gridColor },
                                                    ticks: { color: textColor }
                                                }
                                          }
                                    }
                                });
                            }
                         }">
                        <canvas x-ref="canvas"></canvas>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-brand-black-alt p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-none">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-bold text-lg text-gray-900 dark:text-brand-gray">Action Items</h2>
                        <a href="{{ route('tasks.board') }}"
                            class="text-sm font-bold text-brand-green hover:underline">View Kanban &rarr;</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($tasksToday as $task)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 dark:bg-brand-black rounded-2xl border border-gray-500 dark:border-transparent hover:border-brand-green/30 transition">
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-brand-gray">{{ $task->title }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">For: {{ $task->contact->first_name }}
                                        {{ $task->contact->last_name }}</p>
                                </div>
                                <span class="bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                    Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center p-6 border-2 border-dashed border-gray-200 rounded-xl">
                                <p class="text-gray-400 font-bold text-sm">No tasks due today. Great job!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-brand-black-alt p-6 rounded-2xl shadow-sm border ">
                <h2 class="font-bold text-lg text-gray-900 mb-6 dark:text-brand-gray">Recent Activity</h2>

                <div
                    class="space-y-6 relative before:absolute before:inset-0 before:ml-4 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                    @forelse($recentInteractions as $interaction)
                        <div
                            class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <div
                                class="flex items-center justify-center w-8 h-8 rounded-full border border-white bg-slate-300 text-slate-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                            </div>

                            <div
                                class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white dark:bg-brand-black p-4 rounded-xl border border-slate-200 dark:border-none shadow-sm">
                                <div class="flex items-center justify-between mb-1">
                                    <span
                                        class="font-bold text-gray-900 dark:text-white uppercase text-sm">{{ $interaction->contact->first_name }}</span>
                                    <time
                                        class="text-xs font-medium text-brand-green">{{ \Carbon\Carbon::parse($interaction->interaction_date)->diffForHumans() }}</time>
                                </div>
                                <div class="text-xs font-semibold text-gray-400 tracking-wider mb-2">
                                    {{ $interaction->type }}</div>
                                <div class="text-sm text-slate-500 truncate text-balance ">{{ $interaction->content }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-sm text-gray-400">No recent activity found.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
