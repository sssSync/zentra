<div class="p-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-brand-gray ">Sales Pipeline</h1>
        <a href="{{ route('leads.create') }}"
            class="bg-brand-green text-black dark:text-white font-bold px-8 py-3 rounded-4xl hover:bg-brand-dim-green dark:hover:bg-brand-light-gray dark:hover:text-black transition flex items-center gap-2 dark:bg-brand-black-alt">
            + Add Lead
        </a>
    </div>

    <div class="flex flex-col gap-6">

        @foreach($statuses as $status)
            <div class="bg-gray-50 dark:bg-transparent rounded-2xl p-4" x-data x-on:dragover.prevent
                x-on:drop="$wire.updateContactStatus(event.dataTransfer.getData('text/plain'), '{{ $status }}')">
                <div class="flex justify-between items-center mb-10 px-2">
                    <h3 class="font-bold text-gray-700 dark:text-brand-light-gray/30 tracking-wide text-2xl font-stretch-expanded uppercase grow text-center"
                        style="transform: scaleX(1.5);">{{ $status }}</h3>
                    <span
                        class="bg-gray-200 dark:bg-brand-gray text-gray-600 dark:text-brand-black  font-bold px-2 py-1 rounded-full w-12 aspect-square flex justify-center items-center">
                        {{ $contacts->where('status', $status)->count() }}
                    </span>
                </div>

                <div class="flex gap-8 items-start pb-4 flex-wrap">
                    @foreach($contacts->where('status', $status) as $contact)
                        <div draggable="true" x-on:dragstart="event.dataTransfer.setData('text/plain', {{ $contact->id }})"
                            class="min-w-60 w-[23%] relative active:cursor-grabbing">
                            <a href="{{ route('contacts.show', $contact->id) }}" wire:navigate>
                                <div
                                    class="absolute z-3 -right-[3%] top-[3%] border dark:hover:bg-brand-gray dark:border-brand-light-gray/40 rounded-full w-[22%] flex justify-center items-center aspect-square dark:text-brand-light dark:hover:text-black group transition-all cursor-pointer">
                                    <flux:icon.arrow-up-right class="group-hover:scale-110 transition-all " />
                                </div>
                            </a>
                            <div
                                class=" bg-white dark:bg-brand-black-alt p-4 rounded-xl shadow-sm border border-gray-100 dark:border-none hover:shadow-md transition-shadow  contact-mask flex flex-col justify-between">
                                <div class="flex gap-2 items-center">
                                    <div class="w-16 rounded-full aspect-square bg-amber-100/40 overflow-hidden">

                                        <img src="{{ $contact->avatar_url }}" alt="Profile Image" class="w-full h-full object-cover">

                                    </div>
                                    <div class=" ">
                                        <h1 class="text-xl font-semibold text-gray-900 dark:text-white" style="transform: scaleY(1.2);">
                                            {{ $contact->first_name }} {{ $contact->last_name }}
                                        </h1>
                                        <h3 class="text-xs font-light text-gray-900 dark:text-brand-light-gray/60">
                                            work position of xyz com. pvt.</h3>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-brand-gray/90 mt-1 flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>

                                        {{ $contact->email }}
                                    </div>
                                    @if($contact->phone)
                                        <div class="text-xs text-gray-400 dark:text-brand-gray/90 mt-2 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                                <path
                                                    d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z">
                                                </path>
                                            </svg>
                                            </svg> {{ $contact->phone }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex gap-2 items-center">
                                    <div
                                        class="p-3 border dark:border-white/80 dark:text-brand-light-gray rounded-4xl grow text-center capitalize">
                                        call Scheduled
                                    </div>
                                    <div
                                        class="aspect-square rounded-full border dark:border-white/80 px-1.5 py-1 w-[3.4rem] flex justify-center items-center">
                                        ✉️
                                    </div>
                                    <button
                                        class="aspect-square rounded-full border dark:border-white/80 px-1.5 py-1 w-[3.4rem] flex justify-center items-center  delete-btn hover:bg-red-100 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
        @endforeach

    </div>
</div>
