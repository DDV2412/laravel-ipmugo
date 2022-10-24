@section('title', 'My Library')
<div>
    <div class="sm:flex justify-between items-center mb-2 mx-2">
        <div class="flex items-center">
            <select wire:model="paginate" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md mr-4">
                <option>{{ __('10') }}</option>
                <option>{{ __('15') }}</option>
                <option>{{ __('25') }}</option>
            </select>
            <x-jet-input wire:model.debounce.300ms="search" class="block w-full" type="text" placeholder="Search ..." />
        </div>
        <div class="mt-2 sm:mt-0">
            <x-jet-button wire:click="newArticle()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                </svg>
                <span>{{ __('Add Article') }}</span>
            </x-jet-button>
        </div>
    </div>

    <div class="mx-2 shadow overflow-x-auto border-b border-gray-200 sm:rounded-md">
        <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-blue-500">
            <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                <div wire:click="sortBy('save_articles.id')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'save_articles.id'])
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
                <div wire:click="sortBy('original')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'original'])
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
            @foreach ($articles as $article)
            <tr>
             @if($article->deleted_at == null)
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
                    {{ $article->original }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $article->year }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                    <button wire:click="deleteArticle({{ $article->id }})" class="p-2 bg-red-500 hover:bg-red-400 focus:outline-none shadow-md rounded-md text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
             @else
             <td class="px-6 py-2 whitespace-nowrap">
                    {{ $article->id }}
                </td>
                <td class="px-6 py-2">
                    <p class="text-red-500">
                        {{ $article->title }} <span class="italic font-semibold">{{__('(Deleted)') }}</span>
                    </p>
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
                    {{ $article->original }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $article->year }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                    
                </td>
             @endif
            </tr>
            @endforeach
            
        </tbody>
        </table>
    </div>
    <div class="py-4 mx-2">
        {{ $articles->links() }}
    </div>
</div>
