@section('title', 'Journal Records')
<div>
    @livewire('frontend.search-bar')
    {{-- Journals Panel --}}
    <div class="pt-16 max-w-4xl mx-auto px-2">
        <div class="pb-8">
            
            {{-- Articles --}}
            <div class="md:ml-4 mt-4 md:mt-0">
                <div class="flex justify-between items-center mb-4">
                   <div class="flex items-center justify-start w-full">
                        <label for="fillter-AZ" class="flex items-center cursor-pointer">
                        <div class="relative">
                          <input type="checkbox" id="fillter-AZ" wire:click="sortBy('repoTitle')"  class="sr-only">
                          <div class="block bg-gray-200 w-12 h-5 rounded-full"></div>
                          <div class="dot absolute left-1 top-0 bg-blue-300 w-5 h-5 rounded-full transition"></div>
                        </div>
                        <div class="ml-3 text-gray-700 font-medium">
                          A-Z
                        </div>
                      </label>
                    </div>
                     {{--  Search  --}}
                <x-jet-input wire:model.debounce.300ms="search" class="block w-full mr-2" type="text" placeholder="Search ..." />
                    <select wire:model="paginate" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md">
                        <option>{{ __('10') }}</option>
                        <option>{{ __('25') }}</option>
                        <option>{{ __('50') }}</option>
                        <option>{{ __('100') }}</option>
                    </select>
                </div>
               @foreach ($repositories as $repository)
               <div class="p-4 shadow-md rounded-md sm:flex mb-4">
                  {{-- Title --}}
                  <div class="flex-0">
                    <img src="{{ Storage::url($repository->repoThumnail) }}" alt="" class="w-28 rounded-md shadow-md overflow-hidden">
                  </div>
                  <div class="sm:ml-4 mt-4 sm:mt-0 flex-1">
                    <h1 class="font-semibold text-xl py-1">
                      <a href="{{ route('journalDetail', $repository->abbreviation) }}">{{ $repository->repoTitle }}</a>
                    </h1>
                    <p class="italic text-gray-500 text-xs">{{ $repository->article->count() }} Total Article Records</p>
                    <p class="line-clamp-3 text-sm pt-2">{{ $repository->repoDescription }}</p>
                  </div>
                </div>
               @endforeach

               <div class="mt-4">
                {{ $repositories->links() }}
              </div>
            </div>
        </div>
    </div>
</div>
