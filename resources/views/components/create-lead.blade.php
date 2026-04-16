<?php

use Livewire\Component;

new class extends Component {
    //
};
?>
<div
    class="max-w-2xl mx-auto bg-white dark:bg-brand-black-alt p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-100/10 mt-8">
    <h2 class="text-2xl font-bold text-brand-dark mb-6 dark:text-white">Add New Lead</h2>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-brand-green/10 border border-brand-green/20 text-brand-green rounded-xl font-medium">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        <div class="mb-6 flex items-center gap-6">
            <div
                class="w-20 h-20 rounded-full bg-gray-100 border border-gray-200 dark:border-gray-200/20 overflow-hidden flex items-center justify-center shrink-0">
                @if ($avatar)
                    {{-- Livewire Temporary URL for previewing --}}
                    <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                @else
                    {{-- Default placeholder --}}
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                @endif
            </div>
        
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Profile
                    Image</label>
                <input type="file" wire:model="avatar" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                         file:rounded-full file:border-0
                          file:text-sm file:font-semibold                                                                                           file:bg-brand-green/10 file:text-brand-dark
                        dark:file:bg-brand-black dark:file:text-brand-light-gray/50                                                                                           hover:file:bg-brand-green/20 dark:hover:file:bg-brand-black/20" />
                <div wire:loading wire:target="avatar" class="text-sm text-brand-dark mt-1">Uploading...</div>
                @error('avatar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">First Name
                    *</label>
                <input type="text" wire:model="first_name"
                    class="text-black w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green focus:border-transparent outline-none transition dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40"
                    placeholder="Jane">
                @error('first_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Last
                    Name</label>
                <input type="text" wire:model="last_name"
                    class="text-black w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green focus:border-transparent outline-none transition dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40"
                    placeholder="Doe">
            </div>
        </div>


        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Email Address
                *</label>
            <input type="email" wire:model="email"
                class="text-black w-full px-4 py-2 border border-gray-200/30 rounded-xl focus:ring-2 focus:ring-brand-green focus:border-transparent outline-none transition dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40"
                placeholder="jane@company.com">
            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Phone
                    Number</label>
                <input type="text" wire:model="phone"
                    class="text-black w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green focus:border-transparent outline-none transition dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40"
                    placeholder="+1 (555) 000-0000">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Job
                    Title</label>
                <input type="text" wire:model="job_title"
                    class="text-black w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green focus:border-transparent outline-none transition dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40"
                    placeholder="e.g. Director of Sales">
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 mt-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-bold text-gray-900 dark:text-brand-light-gray/70 uppercase tracking-wider">
                    Company Details</h3>

                <button type="button" wire:click="toggleCompanyMode"
                    class="text-sm font-medium text-brand-green hover:text-lime-700 transition flex items-center gap-1">
                    @if($is_creating_company)
                        <span>← Back to Search</span>
                    @else
                        <span>+ Create New Company</span>
                    @endif
                </button>
            </div>

            @if(!$is_creating_company)
                <div>
                    <select wire:model="company_id"
                        class="text-black w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none bg-white dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40">
                        <option value="">-- No Company (Independent) --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('company_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            @endif

            @if($is_creating_company)
                <div class="bg-gray-50 dark:bg-brand-black-alt dark:border-none p-5 rounded-2xl border border-gray-100 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Company
                            Name *</label>
                        <input type="text" wire:model="new_company_name"
                            class="text-black w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40"
                            placeholder="e.g. Stark Industries">
                        @error('new_company_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Company
                            Address</label>
                        <textarea wire:model="new_company_address" rows="2"
                            class="text-black w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40"
                            placeholder="123 Business Rd, Suite 100, City, State, ZIP"></textarea>
                        @error('new_company_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Industry</label>
                            <input type="text" wire:model="new_company_industry"
                                class="text-black w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40"
                                placeholder="e.g. Defense">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-brand-light-gray/80 mb-1">Website</label>
                            <input type="url" wire:model="new_company_website"
                                class="text-black w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-green outline-none dark:text-brand-light-gray dark:border-gray-200/20 dark:bg-brand-black dark:focus:ring-brand-light-gray/40"
                                placeholder="https://...">
                            @error('new_company_website') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full bg-brand-dark dark:bg-brand-gray  text-white dark:text-brand-black font-bold py-3 px-4 rounded-xl hover:bg-black dark:hover:text-white transition shadow-lg flex justify-center items-center">
                <span wire:loading.remove>Save Lead to Pipeline</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>
    </form>
</div>
