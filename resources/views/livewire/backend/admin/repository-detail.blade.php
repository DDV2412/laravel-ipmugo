@section('title', $repository->repoTitle)
<div class="px-2">
    <div class="py-4 overflow-x-auto min-w-full">
        <div class="md:flex items-start">
            <div class="flex-1 mx-2 rounded-md shadow-md p-4">
                <x-jet-button wire:click="getListSet">
                    {{ __('List Sets') }}
                </x-jet-button>
                <div>
                    <p class="mt-2">{{ __('Datestamp of response : ') }}{{ $responseDate }}</p>
                    <p class="mt-2">{{ __('Request URL : ') }}{{ $request }}</p>
                </div>
                <form wire:submit.prevent="storeAbbreviation">
                    <div class="mt-4">
                        <select name="abbreviation" id="abbreviation" wire:model="abbreviation" class="w-52 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md">
                            <option>{{ $repository->abbreviation }}</option>
                            @foreach ($listSet as $id => $listSet)
                                <option value="{{ $listSet['setSpec'] }}">{{ $listSet['setSpec'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <x-jet-button class="mt-8" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                              </svg>
                            {{ __('Add Abbreviation') }}
                        </x-jet-button>
                    </div>
                </form>
            </div>
            <div class="flex-1 mx-2 rounded-md shadow-md p-4">
                <div>
                    <p>{{ __('Datestamp of response : ') }}{{ $responseDateRecord }}</p>
                </div>
                <form wire:submit.prevent="getListRecords" class="mt-2">
                    <select wire:model="protocol" class="w-52 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md">
                        <option value="oai_dc" selected>{{ __('OAI DC') }}</option>
                     </select>
                     <div class="md:flex items-center mt-4">
                        <div class="flex-1 md:mr-2">
                            <x-jet-label for="from" value="{{ __('From') }}" />
                            <x-jet-input id="from" class="block mt-1 w-full" wire:model='from' type="text" name="from" :value="old('from')"/>
                        </div>
                        <div class="flex-1 mt-2 md:mt-0">
                            <x-jet-label for="until" value="{{ __('Until') }}" />
                            <x-jet-input id="until" class="block mt-1 w-full" wire:model='until' type="text" name="until" :value="old('until')"/>
                        </div>
                     </div>
                     <span class="italic text-gray-500 text-xs">Please Input Form Until Before Harvest Records</span>
                     <div class="flex justify-end items-center">
                        <button class="mt-2 disabled:bg-opacity-50 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest active:bg-blue-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-300 transition shadow-md" type="submit" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                              </svg>
                            {{ __('Harvest Now') }}
                        </button>
                     </div>
                </form>
            </div>
        </div>
    </div> 
    
    <div class="sm:flex justify-between items-center mb-2 mx-2">
        <div class="flex items-center">
            <select wire:model="paginate" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md mr-4">
                <option>{{ __('10') }}</option>
                <option>{{ __('15') }}</option>
                <option>{{ __('25') }}</option>
            </select>
            <x-jet-input wire:model.debounce.300ms="search" class="block w-full" type="text" placeholder="Search ..." />
        </div>
        <x-jet-button class="mt-2" wire:click="history">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5  mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
              </svg>
            {{ __('History') }}
        </x-jet-button>
    </div>

    <div class="mx-2 shadow overflow-x-auto border-b border-gray-200 sm:rounded-md">
        <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-blue-500">
            <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                <div wire:click="sortBy('id')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'id'])
                    <span>{{ __('ID') }}</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                <div wire:click="sortBy('title')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'title'])
                    <span>{{ __('Title') }}</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                <div wire:click="sortBy('doi')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'doi'])
                    <span>{{ __('DOI') }}</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                <div wire:click="sortBy('issue')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'issue'])
                    <span>{{ __('Issue') }}</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                <div wire:click="sortBy('year')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'year'])
                    <span>{{ __('Year') }}</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                {{ __('Actions') }}
            </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 text-sm">
            @forelse ($articles as $article)
             <tr>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $article->id }}
                </td>
                <td class="px-6 py-2">
                    <a href="{{ route('articleDetail', ['abbreviation' => $article->repository->abbreviation, 'id' => $article->id]) }}">
                        {{ $article->title }}
                    </a>
                    <div class="text-gray-500 italic text-xs">
                       
                       @foreach ($article->author as $author)
                           {{ $author->firstname }} {{ $author->lastname }},
                       @endforeach
                       
                    </div>
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $article->doi }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $article->issue }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $article->year }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                    <button wire:click="EditArticle({{ $article->id }})" class="p-2 bg-blue-500 hover:bg-blue-400 focus:outline-none shadow-md rounded-md text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
                @empty
                <td colspan="6" class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                    <div class="flex items-center min-w-full justify-center">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-4" viewBox="0 0 20 20" fill="currentColor">
                         <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                     </svg>
                     <span>Articles not Record! Harvest NOW</span>
                    </div>
                </td>
            </tr>
            @endforelse
            
        </tbody>
        </table>
    </div>
    <div class="py-4 mx-2">
        {{ $articles->links() }}
    </div>


{{--  Update Article  --}}
    <x-jet-dialog-modal wire:model="EditModal">
        <x-slot name="title">
            <div class="flex justify-between">
                {{ isset($articleId) ? 'Update Article' : 'Add Article' }}
                <button class="p-2 hover:bg-blue-300 focus:outline-none rounded-md shadow-md"  wire:click="$toggle('EditModal')" wire:loading.attr="disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </x-slot>

        <x-slot name="content">
            <x-jet-validation-errors class="mb-4" />
            <div>
                <x-jet-label for="file_PDF" value="{{ __('PDF') }}" />
                <x-jet-input id="file_PDF" wire:model="file_PDF" class="block mt-1 w-full" type="file" name="file_PDF" :value="old('file_PDF')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Article Title') }}" />
                <x-jet-input id="title" wire:model="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" />
            </div>
            <div class="mt-4">
                    <x-jet-label for="description" value="{{ __('Article Description') }}" />
                    <textarea name="description" id="description" rows="5" wire:model="description" class="block mt-1 w-full border-gray-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md"></textarea>
            </div>
            <div class="mt-4 sm:flex">
                <div class="mt-4 sm:mt-0 sm:mr-2">
                    <x-jet-label for="issue" value="{{ __('Article Issue') }}" />
                    <x-jet-input id="issue" wire:model="issue" class="block mt-1 w-full" type="text" name="issue" :value="old('issue')" />
                </div>
                <div class="mt-4 sm:mt-0 sm:mr-2">
                    <x-jet-label for="volume" value="{{ __('Article Volume') }}" />
                    <x-jet-input id="volume" wire:model="volume" class="block mt-1 w-full" type="text" name="volume" :value="old('volume')" />
                </div>
                <div class="mt-4 sm:mt-0 sm:mr-2">
                    <x-jet-label for="nomor" value="{{ __('Article Nomor') }}" />
                    <x-jet-input id="nomor" wire:model="nomor" class="block mt-1 w-full" type="text" name="nomor" :value="old('nomor')" />
                </div>
                <div class="mt-4 sm:mt-0">
                    <x-jet-label for="pages" value="{{ __('Article Pages') }}" />
                    <x-jet-input id="pages" wire:model="pages" class="block mt-1 w-full" type="text" name="pages" :value="old('pages')" />
                </div>
            </div>
            <div class="mt-4">
               <x-jet-label for="doi" value="{{ __('Article DOI') }}" />
                    <x-jet-input id="doi" wire:model="doi" class="block mt-1 w-full" type="text" name="doi" :value="old('doi')" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click="articleUpdate()"  wire:loading.attr="disabled">
                {{ isset($articleId) ? 'Update Article' : 'Add Article' }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
