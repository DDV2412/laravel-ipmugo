@section('title', $repository->repoTitle)
<div>
    <div class="h-28 shadow-md" style="background-image: url('https://img.wallpapersafari.com/desktop/1366/768/52/6/yzmaux.jpg'); background-size: cover; background-repeat: no-repeat">
    </div>
    <div class="mx-auto max-w-7xl -mt-14">
        <div class="sm:flex items-start px-2">
            <div class="flex-0 sm:w-52">
                <div class="bg-white opacity-75 p-4 rounded-md shadow-md mb-4">
                    <img src="{{ Storage::url($repository->repoThumnail) }}" alt="" class="w-40 rounded-md shadow-md mx-auto">
                </div>
                <div class="bg-white opacity-75 p-2 rounded-md shadow-md mb-4">
                    <div class="flex items-center justify-start">
                        <div class="flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <div class="mx-2 flex-1">
                            <p class="font-bold">{{ __('Contact Email') }}</p>
                            <p class="text-sm">{{ $repository->adminEmail }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-jet-button>{{ __('Submit Article') }}</x-jet-button>
                    </div>
                </div>
            </div>
            <div class="flex-1 sm:mx-2 mb-4">
                <div class="bg-white opacity-75 shadow-md rounded-md p-4 mb-8">
                    <h1 class="font-semibold text-xl">{{ $repository->repoTitle }}</h1>
                    <p class="py-1"><a href="{{ $repository->baseURL }}" class="flex items-center">{{ __('Website') }}<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd" />
                      </svg></a></p>
                    <p class="py-1">{{ __('ISSN:') }}{{ $repository->printISSN }}{{ __('/') }}{{ __('E-ISSN:') }}{{ $repository->onlineISSN }}</p>
                    <p class="py-1 line-clamp-6 text-justify">{{ $repository->repoDescription }}</p>
                </div>

                {{--  Articles  --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start w-full mx-4">
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
                    <x-jet-input wire:model.debounce.300ms="search" class="block w-1/2" type="text" placeholder="Search ..." />
                    <select wire:model="paginate" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md">
                        <option>{{ __('50') }}</option>
                        <option>{{ __('75') }}</option>
                        <option>{{ __('100') }}</option>
                        <option>{{ __('150') }}</option>
                    </select>
                </div>

                <div class="mt-6">
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
                        <p class="italic text-gray-500 text-xs">
                          @foreach ($article->author as $author)
                          {{ $author->firstname }} {{ $author->lastname }},
                      @endforeach
                        </p>
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
            <div class="flex-0 sm:w-64">
                <div class="bg-white opacity-75 rounded-md shadow-md mb-4 p-4">
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

                <h1 class="pb-2 font-semibold">{{ __('Issues') }}</h1>
                <div class="mb-4 rounded-md shadow-md p-4 max-h-screen overflow-y-auto">                    
                    @foreach ($articleIssue as $issue)
                      <div class="flex justify-start items-center py-2 w-60 text-sm">
                        <x-jet-input  class="block" type="radio" wire:model="issueOriginal" value="{{ $issue->issue }}"/>
                        <label for="repository_id" class="px-2">{{ $issue->issue }} ({{ $issue->count }})</label>
                      </div>
                   @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>