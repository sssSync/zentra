<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        @vite(['resources/css/nav-style.css'])
    </head>
    <body class="min-h-screen bg-white dark:bg-brand-black">
        <flux:header  class=" bg-zinc-50 dark:bg-brand-black">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />
            <flux:brand href="#" logo="crm-logo.png" class="dark:invert scale-120 mr-4" />
            <flux:navbar class="max-lg:hidden nav-item-container">
                <flux:navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navbar.item>

                <flux:navbar.item icon="users" :href="route('contacts.index')" :current="request()->routeIs('contacts.index')" wire:navigate>
                      {{ __('Contacts') }}
               </flux:navbar.item>

                     <flux:navbar.item icon="calendar-days" :href="route('calendar')" :current="request()->routeIs('calendar')" wire:navigate>
                                        {{ __('Calendar View') }}
                     </flux:navbar.item>
                     <flux:navbar.item icon="chart-bar" :href="route('analytics')" :current="request()->routeIs('analytics')" wire:navigate>
                         {{ __('Analytic Hub') }}
                     </flux:navbar.item>

                     <flux:navbar.item icon="banknotes" :href="route('deals.board')" :current="request()->routeIs('deals.board')" wire:navigate>
                         {{ __('Deals') }}
                     </flux:navbar.item>

                     <flux:navbar.item icon="clipboard-document-check" :href="route('tasks.board')" :current="request()->routeIs('tasks.board')" wire:navigate>
                         {{ __('Task Board') }}
                     </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                <flux:tooltip :content="__('Search')" position="bottom">
                    <flux:navbar.item class="h-10! [&>div>svg]:size-5" icon="magnifying-glass" href="#" :label="__('Search')" />
                </flux:tooltip>

                <flux:tooltip :content="__('Support & Help')" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="chat-bubble-left-right"
                        href="https://laravel.com/docs/starter-kits#livewire"
                        target="_blank"
                        :label="__('Support & Help')"
                    />
                </flux:tooltip>
            </flux:navbar>

            <x-desktop-user-menu />
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')">
                    <flux:sidebar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard')  }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
