@section('title', 'Article Records')

<div>
    @livewire('frontend.search-bar')
    {{-- Articles Panel --}}
    <div class="pt-16 max-w-7xl mx-auto px-2">
        <div class="md:flex items-start pb-8">
            <div class="flex-0 mt-4 md:mt-0">
                <h1 class="text-xl font-semibold">{{ $count }} Article Records</h1>

                {{--  Search  --}}
                <x-jet-input wire:model.debounce.300ms="search" class="block w-full mt-1" type="text" placeholder="Search ..." />


                {{-- Years --}}
                <div class="my-4 rounded-md shadow-md p-4">
                  <h1 class="pb-2 font-semibold">Years</h1>
                    <div class="flex justify-between pb-2">
                      <label for="years">
                        {{ $firstYear }}
                      </label>
                      <label for="years">
                        {{ $lastYear }}
                      </label>
                    </div>
                
                      <input class="rounded-lg overflow-hidden appearance-none bg-gray-100 h-3 min-w-full focus:outline-none" wire:model="years" type="range" min="{{ $firstYear }}" max="{{ $lastYear }}" step="1" :value="{{ $firstYear }}" />
                      <x-jet-label for="year" value="{{ __('Year') }}"/>
                      <x-jet-input type="text" wire:model="years" class="w-full mt-1"/>
                  </div>
                

                {{-- Journals --}}
                <div class="my-4 rounded-md shadow-md p-4">
                    <h1 class="pb-2 font-semibold">Journals</h1>
                    
                    @foreach ($repositories as $repository)
                      <div class="flex justify-start items-center py-2 w-60 text-sm">
                        <x-jet-input  class="block" type="radio" wire:model="repositoryId" value="{{ $repository->id }}" />
                        <label for="repository_id" class="px-2">{{ $repository->repoTitle }} ({{ $repository->article->count() }})</label>
                      </div>
                   @endforeach
                    
                </div>

            </div>
            {{-- Articles --}}
            <div class="flex-1 md:ml-4 mt-4 md:mt-0">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center justify-start w-full">
                        <label for="latest_articles" class="flex items-center cursor-pointer">
                          <div class="relative">
                            <input type="checkbox" wire:click="sortBy('date')" id="latest_articles" class="sr-only">
                            <div class="block bg-gray-200 w-12 h-5 rounded-full"></div>
                            <div class="dot absolute left-1 top-0 bg-blue-300 w-5 h-5 rounded-full transition"></div>
                          </div>
                        <div class="ml-3 text-gray-700 font-medium">
                          Latest
                        </div>
                      </label>
                    </div>
                    <div class="flex items-center justify-start w-full">
                        <label for="popular" class="flex items-center cursor-pointer">
                        <div class="relative">
                          <input type="checkbox" id="popular" wire:click="sortBy('title')" class="sr-only">
                          <div class="block bg-gray-200 w-12 h-5 rounded-full"></div>
                          <div class="dot absolute left-1 top-0 bg-blue-300 w-5 h-5 rounded-full transition"></div>
                        </div>
                        <div class="ml-3 text-gray-700 font-medium">
                          A-Z
                        </div>
                      </label>
                    </div>
                    <select wire:model="paginate" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md">
                        <option>{{ __('10') }}</option>
                        <option>{{ __('25') }}</option>
                        <option>{{ __('50') }}</option>
                        <option>{{ __('100') }}</option>
                    </select>
                </div>
                
                @foreach ($articles as $article)
                  <div class="p-4 shadow-md rounded-md">
                    {{-- Title --}}
                    <div class="sm:flex justify-between items-center">
                      <h1 class="font-semibold text-xl py-1 flex-1">
                        <a href="{{ route('articleDetail', ['abbreviation' => $article->repository->abbreviation, 'id' => $article->id]) }}" wire:click="viewPopular({{ $article->id }})">{{ $article->title }}</a>
                      </h1>
                      <div class="mt:2 sm:mt-0 flex-0">
                        <div class="flex">
                          @if (Route::has('login'))
                        @auth
                          <button wire:click="saveInLibrary({{ $article->id }})" x-data="{ tooltip: false }" class="relative z-30 inline-flex rounded-md shadow-md hover:bg-gray-200 p-2 mb-2 sm:mb-0">
                            <svg x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                              <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                            </svg>
                            <div class="relative" x-cloak x-show.transition.origin.top="tooltip">
                              <div class="absolute top-0 z-10 p-2 -mt-1 text-sm min-w-full text-white whitespace-nowrap transform -translate-x-1/2 -translate-y-full bg-blue-500 rounded-lg shadow-lg">
                                {{ __('Save in Your Library') }}
                              </div>
                              <svg class="absolute left-5 z-10 w-6 h-6 text-blue-500 transform -translate-x-12 -translate-y-3 fill-current stroke-current" width="8" height="8">
                                <rect x="12" y="-10" width="8" height="8" transform="rotate(45)" />
                              </svg>
                            </div>
                          </button>                          
                        @else
                          <a href="{{ route('login') }}" x-data="{ tooltip: false }" class="relative z-30 inline-flex rounded-md shadow-md hover:bg-gray-200 p-2 mb-2 sm:mb-0">
                            <svg x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                              <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                            </svg>
                            <div class="relative" x-cloak x-show.transition.origin.top="tooltip">
                              <div class="absolute top-0 z-10 p-2 -mt-1 text-sm min-w-full text-white whitespace-nowrap transform -translate-x-1/2 -translate-y-full bg-blue-500 rounded-lg shadow-lg">
                                {{ __('Save in Your Library') }}
                              </div>
                              <svg class="absolute left-5 z-10 w-6 h-6 text-blue-500 transform -translate-x-12 -translate-y-3 fill-current stroke-current" width="8" height="8">
                                <rect x="12" y="-10" width="8" height="8" transform="rotate(45)" />
                              </svg>
                            </div>
                          </a>
                        @endauth
                        @endif
                        <x-jet-dropdown align="left" width="sm">
                          <x-slot name="trigger">
                            <button x-data="{ tooltip: false }" class="relative z-30 inline-flex rounded-md shadow-md hover:bg-gray-200 p-2 mb-2 sm:mb-0">
                                <svg x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                  <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                </svg>
                                <div class="relative" x-cloak x-show.transition.origin.top="tooltip">
                                  <div class="absolute top-0 z-10 p-2 -mt-1 text-sm min-w-full text-white whitespace-nowrap transform -translate-x-1/2 -translate-y-full bg-blue-500 rounded-lg shadow-lg">
                                    {{ __('Share') }}
                                  </div>
                                  <svg class="absolute left-5 z-10 w-6 h-6 text-blue-500 transform -translate-x-12 -translate-y-3 fill-current stroke-current" width="8" height="8">
                                    <rect x="12" y="-10" width="8" height="8" transform="rotate(45)" />
                                  </svg>
                                </div>
                              </button>
                          </x-slot>
      
                          <x-slot name="content">
                    <a href="https://www.facebook.com/sharer.php?u={{ Request::url() }}" target="_blank" class="inline-flex items-center px-4 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:bg-blue-500 focus:outline-none focus:text-gray-700 hover:text-white focus:border-gray-300 transition min-w-full" wire:click="shareOnFacebook({{ $article->id }})">{{ __('Facebook') }}</a>
                      <a href="https://twitter.com/share?url={{ Request::url() }}&text={{ $article->title }}"  target="_blank" class="inline-flex items-center px-4 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:bg-sky-500 focus:outline-none focus:text-gray-700 hover:text-white focus:border-gray-300 transition min-w-full" wire:click="shareOnTwitter({{ $article->id }})">{{ __('Twitter') }}</a>
                      <a href="https://api.whatsapp.com/send?text={{ $article->title }} {{ Request::url() }}" target="_blank" class="inline-flex items-center px-4 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:bg-green-500 focus:outline-none focus:text-gray-700 hover:text-white focus:border-gray-300 transition min-w-full" wire:click="shareOnWhatsapp({{ $article->id }})">{{ __('Whatsapp') }}</a>
                      <a href="mailto:?subject='{{ $article->title }}'&body={{ $article->description }}:{{ Request::url() }}" title="{{ $article->title }}" class="inline-flex items-center px-4 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:bg-red-500 focus:outline-none focus:text-gray-700 hover:text-white focus:border-gray-300 transition min-w-full" wire:click="shareOnMail({{ $article->id }})">{{ __('Email') }}</a>
                        </x-slot>
                        </x-jet-dropdown>
                        </div>
                      </div>
                    </div>
                    <p class="italic text-gray-500 text-xs"> @foreach ($article->author as $author)
                      {{ $author->firstname }} {{ $author->lastname }},
                  @endforeach</p>
                    <p class="text-sm py-1">{{ $article->repository->repoTitle }}, {{ $article->issue }}
                      @if (!empty($article->pages))
                           , pp. {{ $article->pages }}
                      @else
                          
                      @endif
                    </p>
                    <p class="line-clamp-3 text-sm pt-2">{!! $article->description !!}</p>
                  </div>
                @endforeach
                <div class="mt-4">
                  {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
