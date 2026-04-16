<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta name="color-scheme" content="light only">
        @include('partials.head')
    @vite(['resources/css/nav-style.css'])
    </head>
    <body class="min-h-screen">
        <flux:sidebar sticky collapsible="mobile" class="border-e ">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>

                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>


            <flux:sidebar.item icon="users" :href="route('contacts.index')" :current="request()->routeIs('contacts.index')" wire:navigate>
                  {{ __('Sales Pipeline') }}
           </flux:sidebar.item>

             <flux:sidebar.item icon="user-plus" :href="route('leads.create')" :current="request()->routeIs('leads.create')" wire:navigate>
                                    {{ __('Add New Lead') }}
             </flux:sidebar.item>

                 <flux:sidebar.item icon="calendar" :href="route('meetings')" :current="request()->routeIs('meetings')" wire:navigate>
                                    {{ __('Meetings') }}
                  </flux:sidebar.item>
                 <flux:sidebar.item icon="calendar-days" :href="route('calendar')" :current="request()->routeIs('calendar')" wire:navigate>
                                    {{ __('Calendar View') }}
                 </flux:sidebar.item>
                 <flux:sidebar.item icon="chart-bar" :href="route('analytics')" :current="request()->routeIs('analytics')" wire:navigate>
                     {{ __('Analytic Hub') }}
                 </flux:sidebar.item>

                 <flux:sidebar.item icon="banknotes" :href="route('deals.board')" :current="request()->routeIs('deals.board')" wire:navigate>
                     {{ __('Deals') }}
                 </flux:sidebar.item>

                 <flux:sidebar.item icon="clipboard-document-check" :href="route('tasks.board')" :current="request()->routeIs('tasks.board')" wire:navigate>
                     {{ __('Task Board') }}
                 </flux:sidebar.item>
            </flux:sidebar.nav>
                       <flux:spacer />
            <flux:sidebar.nav>

                <flux:sidebar.item icon="chat-bubble-left-right" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Support & Help') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()?->name ?? 'Gures'" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()?->name ?? 'Gures'"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()?->name ?? 'Guest User' }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user() ?->email ?? 'jh' }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
