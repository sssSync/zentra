<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div class="max-w-7xl mx-auto p-6 mt-4">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Business Analytics</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Deep dive into your CRM performance and revenue trends.</p>
        </div>

        <div
            class="bg-white dark:bg-brand-black-alt border border-gray-200 dark:border-none rounded-xl px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-200 shadow-sm">
            📅 All Time Overview
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2 dark:bg-brand-black-alt dark:border-brand-gray/20">
            <h2 class="font-bold text-lg text-gray-900 dark:text-brand-gray mb-2">Revenue Trend (Won Deals)</h2>
            <p class="text-xs text-gray-500 dark:text-brand-gray/50 mb-6">Total revenue closed over the last 6 months.</p>

            <div class="w-full h-75"
                 x-data="{
                    init() {
                        const isDark = document.documentElement.classList.contains('dark');
                        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
                        const textColor = isDark ? '#9ca3af' : '#6b7280'; // text-gray-400 : text-gray-500

                        new Chart(this.$refs.revenueChart, {
                            type: 'line',
                            data: {
                                labels: {{ Js::from($trendLabels) }},
                                datasets: [{
                                    label: 'Revenue Won ($)',
                                    data: {{ Js::from($trendData) }},
                                    borderColor: '#ccf34cd0', /* brand-green */
                                    backgroundColor: isDark ? 'rgba(16, 185, 129, 0.2)' : 'rgba(16, 185, 129, 0.1)',
                                    borderWidth: 3,
                                    tension: 0.4, /* Makes the line smooth/curved */
                                    fill: true,
                                    pointBackgroundColor: isDark ? '#1a1a1a' : '#fff',
                                    pointBorderColor: '#c7f33c',
                                    pointBorderWidth: 2,
                                    pointRadius: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: { color: gridColor, borderDash: [4, 4] },
                                        ticks: { color: textColor }
                                    },
                                    x: {

                                        grid: { display: false },
                                        ticks: { color: textColor }
                                    }
                                }
                            }
                        });
                    }
                 }">
                <canvas x-ref="revenueChart"></canvas>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 dark:bg-brand-black-alt dark:border-brand-gray/20">
            <h2 class="font-bold text-lg text-gray-900 dark:text-brand-gray mb-2">Pipeline Health</h2>
            <p class="text-xs text-gray-500 dark:text-brand-gray/50 mb-6">Volume of deals currently sitting in each stage.</p>

            <div class="w-full h-70"
                 x-data="{
                    init() {
                        const isDark = document.documentElement.classList.contains('dark');
                        const textColor = isDark ? '#9ca3af' : '#6b7280';

                        new Chart(this.$refs.pipelineChart, {
                            type: 'doughnut',
                            data: {
                                labels: {{ Js::from($pipelineLabels) }},
                                datasets: [{
                                    data: {{ Js::from($pipelineData) }},
                                    backgroundColor: isDark ? [
                                        '#59677c', /* Discovery - Dark Gray */
                                        '#0e90dc', /* Proposal - Dark Blue */
                                        '#7c23b0', /* Negotiation - Dark Purple */
                                        '#7adb39', /* Won - Dark Green */
                                        '#d62323'  /* Lost - Dark Red */
                                    ] : [
                                        '#f3f4f6', /* Discovery - Gray */
                                        '#bfdbfe', /* Proposal - Blue */
                                        '#e9d5ff', /* Negotiation - Purple */
                                        '#bbf7d0', /* Won - Green */
                                        '#fecaca'  /* Lost - Red */
                                    ],
                                    borderColor: isDark ? '#1f2937' : '#ffffff',
                                    borderWidth: 1,
                                    hoverOffset: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '72%', /* Makes the hole in the middle bigger */
                                plugins: {
                                    legend: {
                                       display:false
                                    }
                                }
                            }
                        });
                    }
                 }">
                <canvas x-ref="pipelineChart"></canvas>
            </div>
        </div>

    </div>


    <div class="mt-8">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Business Analytics</h1>
                <p class="text-sm text-gray-500 mt-1">Advanced insights and revenue momentum.</p>
            </div>
            <button wire:click="exportReport"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    class="bg-white dark:bg-brand-green border border-gray-200 dark:border-brand-green/20 rounded-xl px-4 py-2 text-sm font-bold text-gray-700 dark:text-brand-black shadow-sm hover:bg-gray-50 dark:hover:bg-brand-black transition flex items-center justify-center min-w-35">

                <span wire:loading.remove wire:target="exportReport">Export Report &darr;</span>

                <span wire:loading wire:target="exportReport" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Exporting...
                </span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

            <div
                class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden h-45 flex flex-col justify-between dark:bg-brand-black-alt dark:border-brand-gray/20">
                <div class="flex justify-between items-start z-10 relative">
                    <div>
                        <h3 class="text-sm font-bold text-blue-500 flex items-center gap-2"><span class="w-2 h-4 bg-blue-500 rounded-full"></span> Lead Generation</h3>
                        <p class="text-3xl font-black text-gray-900 dark:text-white mt-2">+{{ array_sum($leadsData) }}</p>
                        <p class="text-xs text-gray-500 dark:text-brand-gray/50 font-medium">New contacts in 6 months</p>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-25"
                     x-data="{
                        init() {
                            const isDark = document.documentElement.classList.contains('dark');
                            let ctx = this.$refs.leadChart.getContext('2d');
                            let gradient = ctx.createLinearGradient(0, 0, 0, 100);

                            if (isDark) {
                                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)'); /* Darker Blue */
                                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');
                            } else {
                                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)'); /* Lighter Blue */
                                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');
                            }

                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: {{ Js::from($months) }},
                                    datasets: [{
                                        data: {{ Js::from($leadsData) }},
                                        borderColor: '#3b82f6',
                                        backgroundColor: gradient,
                                        borderWidth: 3,
                                        tension: 0.4,
                                        fill: true,
                                        pointRadius: 0
                                    }]
                                },
                                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: { enabled: false } }, scales: { x: { display: false }, y: { display: false, min: 0 } }, layout: { padding: 0 } }
                            });
                        }
                     }">
                    <canvas x-ref="leadChart"></canvas>
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 dark:bg-brand-black-alt dark:border-brand-gray/20 h-45 flex flex-col">
                <h3 class="text-sm font-bold text-purple-500 flex items-center gap-2 mb-2"><span class="w-2 h-4 bg-purple-500 rounded-full"></span> Deal Closure Rate</h3>

                <div class="flex-1 relative w-full flex justify-center items-end pb-2"
                     x-data="{
                        init() {
                            const isDark = document.documentElement.classList.contains('dark');

                            new Chart(this.$refs.gaugeChart, {
                                type: 'doughnut',
                                data: {
                                    datasets: [{
                                        data: [{{ $closureRate }}, {{ 100 - $closureRate }}],
                                        backgroundColor: isDark ? ['#d946ef', '#42375187'] : ['#d946ef', '#f3f4f6'], /* Fuchsia and Gray/Dark-Gray */
                                        borderWidth: 0,
                                        borderRadius: [20, 0] // Rounded edges on the colored bar
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    circumference: 180, /* Makes it a half circle */
                                    rotation: -90,      /* Starts from the left */
                                    cutout: '75%',      /* Thin ring */
                                    plugins: { legend: { display: false }, tooltip: { enabled: false } }
                                }
                            });
                        }
                     }">
                    <canvas x-ref="gaugeChart" class="max-h-30"></canvas>
                    <div class="absolute bottom-4 left-0 right-0 text-center">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white ">{{ $closureRate }}%</p>
                        <p class="text-[10px] tracking-widest text-gray-400 font-bold capitalize">Win Rate</p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 dark:bg-brand-black-alt dark:border-brand-gray/20 h-45 flex flex-col justify-center">
                 <h3 class="text-sm font-bold text-brand-green flex items-center gap-2 mb-4"><span class="w-2 h-4 bg-brand-green rounded-full"></span> Revenue Momentum</h3>
                <p class="text-4xl font-black text-gray-900 dark:text-white mb-2">+58%</p>
                 <p class="text-sm text-gray-500 leading-tight">Strong revenue growth driving success this quarter compared to last year.</p>
            </div>

        </div>

        <div
            class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 dark:bg-brand-black-alt dark:border-brand-gray/20">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="font-bold text-xl text-gray-900 dark:text-brand-gray">Active Pipeline by Stage</h2>
                    <p class="text-sm text-gray-500 dark:text-brand-gray/50">How your active deals are distributed month over month.</p>
                </div>
                <div class="flex gap-4 text-sm font-bold text-gray-700 dark:text-gray-300">
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-blue-500 dark:bg-[#e6f9a8]"></span>
                        Discovery</span>
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-blue-300 dark:bg-[#d1ee6f]"></span>
                        Proposal</span>
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-blue-100 dark:bg-brand-green"></span>
                        Negotiation</span>
                </div>
            </div>

            <div class="w-full h-100"
                 x-data="{
                    init() {
                        const isDark = document.documentElement.classList.contains('dark');
                        const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : '#f3f4f6';
                        const textColor = isDark ? '#9ca3af' : '#6b7280';

                        new Chart(this.$refs.stackedBar, {
                            type: 'bar',
                            data: {
                                labels: {{ Js::from($months) }},
                                datasets: [
                                    { label: 'Discovery', data: {{ Js::from($stackedData['Discovery']) }}, backgroundColor: isDark ? '#e6f9a8' : '#3b82f6', borderRadius: 6 },
                                    { label: 'Proposal', data: {{ Js::from($stackedData['Proposal']) }}, backgroundColor: isDark ? '#d1ee6f' : '#93c5fd', borderRadius: 6 },
                                    { label: 'Negotiation', data: {{ Js::from($stackedData['Negotiation']) }}, backgroundColor: isDark ? '#c7f33c' : '#dbeafe', borderRadius: 6 }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } }, // Custom legend built in HTML above
                                scales: {
                                    x: {
                                        stacked: true,
                                        grid: { display: false },
                                        ticks: { color: textColor }
                                    },
                                    y: {
                                        stacked: true,
                                        border: { display: false },
                                        grid: { color: gridColor },
                                        ticks: {
                                            color: textColor,
                                            callback: function(val) { return '$' + (val/1000) + 'k'; }
                                        }
                                    }
                                }
                            }
                        });
                    }
                 }">
                <canvas x-ref="stackedBar"></canvas>
            </div>
        </div>

    </div>
</div>
