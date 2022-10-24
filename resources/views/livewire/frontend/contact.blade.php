@section('title', 'Contact Us')

<div class="bg-blue-500">
    <div class="max-w-4xl mx-auto px-2 py-4">
        <div class="text-center py-8 text-white">
            <h1 class="pb-2 text-4xl font-semibold">Contact Us</h1>
            <p>Tell us what your complaint is, so we can provide the best solution for all of us, <br>you are satisfied we are happy.
            </p>
        </div>
        <div class="sm:flex items-start pt-4">
            <div class="flex-1">
                <div class="flex items-start sm:py-8 py-4">
                    <div class="p-2 rounded-md shadow-md text-blue-500 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <div class="ml-2">
                        <h1 class="font-semibold text-white">{{ __('Phone') }}</h1>
                        <p class="text-sm text-white">{{ __('(+62274) 2805750') }}</p>
                    </div>
                </div>
                <div class="flex items-start sm:py-8 py-4">
                    <div class="p-2 rounded-md shadow-md text-blue-500 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <div class="ml-2">
                        <h1 class="font-semibold text-white">{{ __('Email') }}</h1>
                        <p class="text-sm text-white">{{ __('info@iaesjournal.com') }}</p>
                    </div>
                </div>
                <div class="flex items-start sm:py-8 py-4">
                    <div class="p-2 rounded-md shadow-md text-blue-500 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-2">
                        <h1 class="font-semibold text-white">{{ __('Address') }}</h1>
                        <p class="text-sm text-white">JEC Residence C5, Plumbon, Banguntapan, <br> Modalan, Banguntapan, Kec. Banguntapan, <br> Bantul, Daerah Istimewa Yogyakarta 55198.</p>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <h1 class="font-semibold text-white">{{ __('Send us Message') }}</h1>
                <x-jet-validation-errors class="mb-4" />
                <form wire:submit.prevent="getMassage">
                    <x-jet-input id="name" wire:model="name" class="block mt-2 min-w-full" type="text" name="name" :value="old('name')" placeholder="{{ __('Enter your Name') }}"/>
                    <x-jet-input id="email" wire:model="email" class="block mt-2 min-w-full" type="email" name="email" :value="old('email')" placeholder="{{ __('Enter your Email') }}"/>
                    <textarea name="massage" wire:model="massage" rows="7" class="block mt-2 min-w-full border-gray-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md" placeholder="{{ __('Enter your Massage') }}"></textarea>
                    <button class="mt-2 inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-300 active:bg-orange-500 focus:outline-none focus:border-orange-500 focus:ring focus:ring-orange-300 disabled:opacity-25 transition shadow-md">{{ __('Send Massage') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
