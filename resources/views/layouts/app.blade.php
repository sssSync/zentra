
    <x-layouts::app.header :title="$title ?? null">
    <flux:main class="bg-white dark:bg-brand-black">
        {{ $slot }}
    </flux:main>
    </x-layouts::app.header >
