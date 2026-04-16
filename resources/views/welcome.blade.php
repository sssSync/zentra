<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ __('Welcome') }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any" />
    <link rel="icon" href="/favicon.svg" type="image/svg+xml" />
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/home.css'])

</head>

<body class="bg-white dark:bg-[#040600fc] dark:text-brand-gray text-gray-800 antialiased overflow-x-hidden manrope">

    {{-- #040600fc 011109--}}

    <nav class="w-full px-12 py-3 flex justify-between items-center">
        <flux:brand href="#" logo="crm-logo.png" class="invert scale-160 mr-4" />
        <div class="flex items-center space-x-6">
            {{-- <div class="hidden md:flex space-x-6 text-sm font-medium text-gray-500">
                <a href="#" class="hover:text-gray-900 transition">Home</a>
                <a href="#" class="hover:text-gray-900 transition">Features</a>
                <a href="#" class="hover:text-gray-900 transition">Pricing</a>
                <a href="#" class="hover:text-gray-900 transition">About</a>
            </div> --}}
            </div>
            <div class="flex items-center space-x-4">

                @if (Route::has('login'))
                    <div class="flex items-center justify-end gap-2">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="bg-brand-green text-black px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-brand-dim-green transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-brand-gray text-black px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-brand-dim-green transition">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-brand-green text-black px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-brand-dim-green transition">
                                    Get Started
                                </a>
                        @endif @endauth
                    </div>
                @endif
                </div>
                </nav>

    {{-- Hero section --}}
    <section class="max-w-7xl mx-auto px-6 py-16 md:py-24 flex flex-col items-center gap-4 pt-40 hero-section relative">

        <div class="mt-30 py-2 px-6 uppercase border dark:border-brand-light/20 rounded-4xl bg-[#2929299c] mb-3 text-sm ">
            Intelligence Redifined
        </div>
<div class="absolute inset-0 flex items-center justify-center opacity-30 pointer-events-none">
    <div class="w-96 h-96 bg-brand-green/40 rounded-full blur-[100px] "></div>
</div>
        <div class="absolute back-b1" 011109></div>
        <div class="absolute back-b2"></div>
        <div class="absolute back-b3"></div>
        <div>
            <h1 class="text-[9rem] newsreader text-center" style="line-height: 1;">
                Scale Faster with</h1>
            <h1 class="text-9xl text-center newsreader italic">
                Intelligence.
            </h1>
            </div>

        <h3>
            The ultimate CRM platform designed for modern sales teams to automeate workflows and close more deals.
        </h3>

        <div class="flex gap-6 mt-5">
            <button
                class="btn rounded-4xl border dark:border-brand-light/20 border-gray-600 px-8 py-3 text-lg bg-brand-green dark:text-brand-black uppercase tracking-tight font-semibold">
                Get
                Started For Free</button>
            <button
                class="btn rounded-4xl border bg-[#ffffff0f] dark:border-brand-light/20 border-gray-600 px-8 py-3 text-lg flex gap-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="size-6 fill-brand-green text-brand-green">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" class="fill-brand-black text-brand-black"
                        d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                </svg>

                View
                Demo</button>
                </div>
    </section>

    <section class="w-10/12 mx-auto p-6 border-3 border-white/15 rounded-2xl bg-[#1e1c1cd1] mt-10">
        <img src="/assets/image.png" alt="image-dashboard" class="rounded-2xl">
    </section>

    <section class="w-full px-6 py-24 mt-20 flex flex-col gap-9">
        <div class="text-7xl newsreader text-center flex flex-col items-center text-brand-gray/90 gap-2 ">
            <h1>
                Built for High-Velocity Teams</h1>
            <h4 class="text-2xl w-160 text-brand-gray/70">
                Shopisticate tools shouldn't be completed. We focus on the workflows that actully move the needle.

            </h4>
            </div>
            {{-- --}}
            <div class="flex flex-col gap-4">

                {{--! ------------ 1 ------------------- --}}
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="card-bg flex grow rounded-4xl min-h-80 border">

                        <div class="flex flex-col justify-between">
                            <div
                                class="border border-brand-light-gray/20 bg-brand-green/10 flex justify-center items-center rounded-xl w-12 aspect-square">
                                <flux:icon.sparkles class="text-brand-green" />
                            </div>
                            <div>
                            <h1 class="text-4xl mt-4 newsreader "> Smart Automation
                            </h1>
                            <p class="mt-5 manrope text-lg">
                                Let me control your device to see through your all private document.Effortlessly
                                streamline your sales pipeline with
                                intelligent workflows that handle repetitive tasks, follow-ups, and
                                lead scoring while you close deals.
                            </p>
                            </div>
                            </div>
                    <img src="/assets/unk.png" alt="wht" class="object-contain w-full" />
                    </div>
                <div class="flex min-w-160 card-bg rounded-4xl min-h-80 border">
                    <div class="flex flex-col justify-between">
                        <div
                            class="border border-brand-light-gray/20 bg-brand-green/10 flex justify-center items-center rounded-xl w-12 aspect-square">
                            <flux:icon.chart-bar class="text-brand-green" />
                        </div>

                        <div>
                            <h1 class="text-4xl mt-4 newsreader"> Deep Analysis
                            </h1>
                            <p class="mt-5 text-xl">
                                Gain actionable insights with real-time reporting and visual charts that track
                                performance trends and identify
                                high-value opportunities instantly.
                            </p>
                        </div>

                    </div>
                    </div>
                    </div>

            {{--! ------------ 2n ----------------- --}}
            <div class="flex gap-4">
                <div class="flex min-w-160 card-bg rounded-4xl min-h-80 border">
                    <div class="flex flex-col justify-between">
                        <div
                            class="border border-brand-light-gray/20 bg-brand-green/10 flex justify-center items-center rounded-xl w-12 aspect-square">
                            <flux:icon.chart-bar class="text-brand-green" />
                        </div>

                        <div>
                            <h1 class="text-4xl mt-4 newsreader"> Deal Tracking
                            </h1>
                            <p class="mt-5 text-xl">
                                Monitor your revenue journey from pitch to close with a visual pipeline that ensures no
                                opportunity ever slips
                                through.
                            </p>
                        </div>

                    </div>
                    </div>
                    <div class="card-bg flex grow rounded-4xl min-h-80 border">

                    <div class="flex flex-col justify-between">
                        <div
                            class="border border-brand-light-gray/20 bg-brand-green/10 flex justify-center items-center rounded-xl w-12 aspect-square">
                            <flux:icon.sparkles class="text-brand-green" />
                        </div>
                        <div>
                            <h1 class="text-4xl mt-4 newsreader "> Seamless Managing
                            </h1>
                            <p class="mt-5 manrope text-lg">
                                Organize your database with ease using intuitive contact tools that centralize
                                communication, history, and
                                relationship
                                details in one place.
                            </p>
                        </div>
                        </div>
                        <img src="/assets/contacts.png" alt="wht" class="object-cover rounded-xl w-3/4" />
                        </div>
                    </div>

        </div>
    </section>

    <section class="w-full py-24 mt-20 flex flex-col gap-9 bg-brand-black">

        <div class="max-w-6xl mx-auto">
            <span class="newsreader text-9xl block" style="line-height: .2;">"</span>
            <h3 class="text-5xl newsreader">" ZentraCRM didn't just change our workflow; it transformed our <span
                    class="italic text-brand-green">entire
                    culture</span>. We spend less time on admin and more time building relationships. It's the highest
                leverage tool in our stack. " </h3>
            <div class="flex flex-row-reverse items-end gap-4">
                <div class="rounded-2xl overflow-hidden">
                    <img src="/assets/p2.jpg" alt="sd" />
                </div>
                    <div class="flex flex-col h-full text-xl ">
                        <h3 class="text-brand-gray/40" style="word-spacing: 4px;">Sceretory of Blue House </h3>
                        <h3 class="text-3xl font-bold capitalize newsreader tracking-widest text-brand-gray/60" style="word-spacing: 4px;">
                            Clark Amenda</h3>
                    </div>
            </div>
            </div>
            </section>

    <section class="w-full px-2 md:px-8 py-24 ">
        <div class="bg-[#b6da26] rounded-[3rem] p-16 md:p-24 text-center relative overflow-hidden">


            <div class="relative z-10">
                <h2 class="text-4xl md:text-8xl text-brand-black tracking-tight mb-6 newsreader">
                    Join the Future of Sales <br>
                    <span class="text-brand-black newsreader">Today.</span>
                </h2>
                <p class="text-gray-800 text-xk mb-10  max-w-3xl mx-auto">
                    Start your 500-day free trial. No credit card required. No complex setup.
                </p>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="/register"
                        class="bg-brand-black text-brand-gray px-8 py-4 rounded-full font-bold hover:bg-brand-black/70 transition uppercase tracking-widest w-full sm:w-auto ">
                        Start for Free
                    </a>
                    <a href="#"
                        class=" px-8 py-4 font-bold text-brand-black w-full sm:w-auto underline underline-offset-8 decoration-2 hover:font-bold transition-all">
                        Scheduling a personal demo
                    </a>
                    </div>
                    </div>
                    </div>
                    </section>

    <footer class=" pt-20 pb-10">

        <div class="max-w-7xl mx-auto px-6 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-400">
            <p>© 2024 Zentra CRM. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-gray-600 transition">Terms of Service</a>
                <a href="#" class="hover:text-gray-600 transition">Cookie Policy</a>
            </div>
        </div>
        </footer>

</html>
