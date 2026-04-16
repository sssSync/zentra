<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div>
    <div class="max-w-7xl mx-auto p-6 mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-1 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 h-fit">
            <h2 class="text-2xl font-bold text-brand-dark mb-6">Book a Meeting</h2>

            @if (session()->has('success'))
                <div class="mb-4 p-3 bg-brand-green/10 border border-brand-green/20 text-brand-green rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit="saveMeeting" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Contact *</label>
                    <select wire:model="contact_id" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none bg-white">
                        <option value="">-- Choose a Lead --</option>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}">{{ $contact->first_name }} {{ $contact->last_name }}</option>
                        @endforeach
                    </select>
                    @error('contact_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Title *</label>
                    <input type="text" wire:model="title" placeholder="e.g. Product Demo" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date & Time *</label>
                    <input type="datetime-local" wire:model="scheduled_at" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none">
                    @error('scheduled_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-brand-dark text-white font-bold py-3 rounded-xl hover:bg-black transition shadow-lg mt-4">
                    Schedule Meeting
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-gray-50 p-8 rounded-3xl border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Your Itinerary</h3>

            <div class="space-y-4">
                @forelse($appointments as $apt)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">{{ $apt->title }}</h4>
                            <p class="text-sm text-gray-500 mt-1">With: <span class="font-medium text-gray-700">{{ $apt->contact->first_name }} {{ $apt->contact->last_name }}</span></p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-brand-green bg-brand-green/10 px-3 py-1 rounded-full inline-block">
                                {{ \Carbon\Carbon::parse($apt->scheduled_at)->format('M d, Y') }}
                            </div>
                            <div class="text-xs text-gray-400 mt-2">
                                {{ \Carbon\Carbon::parse($apt->scheduled_at)->format('h:i A') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-400">
                        <p>No upcoming meetings scheduled.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
