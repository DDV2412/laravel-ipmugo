@section('title', 'Ipmu Go Digital Library')
    
<div>
    @livewire('frontend.search-bar')
    {{--  Feature  --}}
    <div class="pt-14 max-w-5xl mx-auto px-2">
        <h1 class="font-semibold text-4xl mb-8">Open Access Journals</h1>
        <div class="center">
            
            @foreach ($repositories as $repository)
                <div class="text-center rounded-md p-2 shadow-md mx-3 max-w-max">
                    <img src="{{ Storage::url($repository->repoThumnail) }}" alt="{{ $repository->repoTitle }}" class="w-40 rounded-md shadow-md mx-auto">
                    <a href="{{ $repository->baseURL }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-300 active:bg-blue-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-300 disabled:opacity-25 transition shadow-md mt-2">{{ __('View Detail') }}</a>
                </div>
            @endforeach
            
        </div>
    </div>

    {{--  Articles  --}}
    <div class="bg-blue-500 mt-10 pb-10">
        <div class="max-w-5xl mx-auto px-2 pt-8 overflow-hidden">
            <h1 class="font-semibold text-4xl text-white">Featured New Articles</h1>
            <div class="md:grid grid-cols-3 gap-4 items-center mt-8 mb-4">
                
                @foreach ($articles as $article)
                    <div class="bg-white shadow-md rounded-md my-2 md:my-0">
                        <div class="flex items-center justify-between">
                            <p><span class="bg-blue-500 rounded-md shadow-md text-white py-2 px-4 text-xs uppercase">{{ $article->repository->abbreviation }}</span></p>
                            <p class="text-sm mr-2 text-gray-500 italic">
                                @if ($article->file_PDF == null)
                                    {{ __('Early Access') }}
                                @else
                                Publish Date: {{ $article->date }}
                                @endif
                            </p>
                        </div>
                        <div class="mt-2 px-4 py-2">
                            <a href="{{ route('articleDetail', ['abbreviation' => $article->repository->abbreviation, 'id' => $article->id]) }}" wire:click="viewPopular({{ $article->id }})" class="line-clamp-2 font-semibold">{{ $article->title }}</a>
                            <p class="text-sm italic text-gray-500 line-clamp-1 mt-1">
                                @foreach ($article->author as $author)
                      {{ $author->firstname }} {{ $author->lastname }},
                  @endforeach
                            </p>
                            <p class="line-clamp-3 mt-2">{{ $article->description }}</p>
                            <a href="https://doi.org/{{ $article->doi }}" target="_blank" class="line-clamp-1 mt-2">{{ $article->doi }}</a>
                        </div>
                    </div>
                @endforeach
                
            </div>
            <a href="{{ route('articles') }}" class="font-semibold text-xl text-white">More Articles ...</a>
        </div>
    </div>
    
    {{-- Statistic --}}
    <div class="my-4">
        <div class="max-w-5xl mx-auto px-2">
            <div class="sm:flex items-center justify-between">
                <div class="p-4 rounded-md shadow-md flex-1 mx-1 mb-2 sm:mb-0">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                        <div class="mx-2">
                            <p class="text-xl font-semibold text-orange-500">{{ $articleRecord }}</p>
                            <p class="text-sm italic text-gray-500">Articles</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 rounded-md shadow-md flex-1 mx-1 mb-2 sm:mb-0">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                          </svg>
                        <div class="mx-2">
                            <p class="text-xl font-semibold text-orange-500">{{ $subjects }}</p>
                            <p class="text-sm italic text-gray-500">Subjects</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 rounded-md shadow-md flex-1 mx-1 mb-2 sm:mb-0">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                          </svg>
                        <div class="mx-2">
                            <p class="text-xl font-semibold text-orange-500">{{ $authors }}</p>
                            <p class="text-sm italic text-gray-500">Authors</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 rounded-md shadow-md flex-1 mx-1 mb-2 sm:mb-0">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                          </svg>
                        <div class="mx-2">
                            <p class="text-xl font-semibold text-orange-500">{{ $popular }}</p>
                            <p class="text-sm italic text-gray-500">Total Views</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
