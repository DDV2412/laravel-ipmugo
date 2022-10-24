@section('title', 'Repository')
<div class="px-2">
    <div class="py-4 overflow-x-auto min-w-full">
        <div>
            <div class="sm:flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <select wire:model="paginate" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md mr-4">
                        <option>{{ __('10') }}</option>
                        <option>{{ __('15') }}</option>
                        <option>{{ __('25') }}</option>
                    </select>
                    <x-jet-input wire:model.debounce.300ms="search" class="block w-full" type="text" placeholder="Search ..." />
                </div>
                <div class="mt-2 sm:mt-0">
                    <x-jet-button wire:click="newRepository()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                        </svg>
                        <span>{{ __('Add Repository') }}</span>
                    </x-jet-button>
                </div>
            </div>
            <div class="shadow overflow-x-auto border-b border-gray-200 sm:rounded-md">
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
                        <div wire:click="sortBy('repositoryName')" class="flex items-center" style="cursor:pointer">
                            @include('components.backend.sort-icon', ['field' => 'repositoryName'])
                            <span>{{ __('Repository Name') }}</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        <div wire:click="sortBy('adminEmail')" class="flex items-center" style="cursor:pointer">
                            @include('components.backend.sort-icon', ['field' => 'adminEmail'])
                            <span>{{ __('Admin Email') }}</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        <div wire:click="sortBy()" class="flex items-center" style="cursor:pointer">
                            @include('components.backend.sort-icon', ['field' => ''])
                            <span>{{ __('ISSN/E-ISSN') }}</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        {{ __('Actions') }}
                    </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($repositories as $repository)
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">
                            {{ $repository->id }}
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @role('Administrator')
                                <a href="{{ route('admin.repositoryId', $repository->id) }}">{{ $repository->repoTitle }}</a>
                                @endrole
                                @role('Assistent')
                                <a href="{{ route('assistent.repositoryId', $repository->id) }}">{{ $repository->repoTitle }}</a>
                                @endrole
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $repository->baseURL }}
                            </div>
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap">
                            {{ $repository->adminEmail }}
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ $repository->printISSN }}/{{ $repository->onlineISSN }}
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="synkRepo({{ $repository->id }})" class="p-2 bg-white hover:bg-orange-500 hover:text-white focus:outline-none shadow-md rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                  </svg>
                            </button>
                            <button wire:click="editRepo({{ $repository->id }})" class="p-2 bg-blue-500 hover:bg-blue-400 focus:outline-none shadow-md rounded-md text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button wire:click="deleteRepository({{ $repository->id }})" class="p-2 bg-red-500 hover:bg-red-400 focus:outline-none shadow-md rounded-md text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>

                        @empty
                        <td colspan="5" class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                           <div class="flex items-center min-w-full justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span>Repository Not Records</span>
                           </div>
                        </td>
                    </tr>                   
                    @endforelse
                </tbody>
                </table>
            </div>

            <div class="py-4">
                {{ $repositories->links() }}
            </div>
        </div>
    </div>

    {{--  Create Repository  --}}
    <x-jet-dialog-modal wire:model="repository">
        <x-slot name="title">
            <div class="flex justify-between">
                {{ isset($repoId) ? 'Update Repository' : 'Add Repository' }}
                <button class="p-2 hover:bg-blue-300 focus:outline-none rounded-md shadow-md"  wire:click="$toggle('repository')" wire:loading.attr="disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </x-slot>

        <x-slot name="content">
            <x-jet-validation-errors class="mb-4" />
            @if (!empty($repoId))
                <div>
                    <x-jet-label for="repoThumnail" value="{{ __('Repository Image') }}" />
                    <x-jet-input id="repoThumnail" wire:model="repoThumnail" class="block mt-1 w-full" type="file" name="repoThumnail" :value="old('repoThumnail')" />
                </div>
                <div class="mt-4">
                    <x-jet-label for="repoTitle" value="{{ __('Repository Title') }}" />
                    <x-jet-input id="repoTitle" wire:model="repoTitle" class="block mt-1 w-full" type="text" name="repoTitle" :value="old('repoTitle')" />
                </div>
                <div class="mt-4">
                    <x-jet-label for="repoDescription" value="{{ __('Repository Description') }}" />
                    <textarea name="repoDescription" id="repoDescription" rows="5" wire:model="repoDescription" class="block mt-1 w-full border-gray-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md"></textarea>
                </div>
                <div class="mt-4 sm:flex justify-between items-center">
                    <div class="flex-1 sm:mr-2">
                        <x-jet-label for="printISSN" value="{{ __('Repository ISSN') }}" />
                        <x-jet-input id="printISSN" wire:model="printISSN" class="block mt-1 w-full" type="text" name="printISSN" :value="old('printISSN')" />
                    </div>
                    <div class="flex-1 sm:ml-2">
                        <x-jet-label for="onlineISSN" value="{{ __('Repository E-ISSN') }}" />
                        <x-jet-input id="onlineISSN" wire:model="onlineISSN" class="block mt-1 w-full" type="text" name="onlineISSN" :value="old('onlineISSN')" />
                    </div>
                </div>
                <div class="mt-4 sm:flex justify-between items-center">
                    <div class="flex-1 sm:mr-2">
                        <x-jet-label for="abbreviation" value="{{ __('Repository Abbrev') }}" />
                        <x-jet-input id="abbreviation" wire:model="abbreviation" class="block mt-1 w-full" type="text" name="abbreviation" :value="old('abbreviation')" />
                    </div>
                    <div class="flex-1 sm:ml-2">
                        <x-jet-label for="adminEmail" value="{{ __('Repository Contact') }}" />
                        <x-jet-input id="adminEmail" wire:model="adminEmail" class="block mt-1 w-full" type="text" name="adminEmail" :value="old('adminEmail')" />
                    </div>
                </div>
                <div class="mt-4">
                    <x-jet-label for="baseURL" value="{{ __('Repository URL') }}" />
                    <x-jet-input id="baseURL" wire:model="baseURL" class="block mt-1 w-full" type="url" name="baseURL" :value="old('baseURL')" />
                </div>
            @else
                <div>
                    <x-jet-label for="baseURL" value="{{ __('Repository URL') }}" />
                    <x-jet-input id="baseURL" wire:model="baseURL" class="block mt-1 w-full" type="text" name="baseURL" :value="old('baseURL')" />
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click="storeRepository()"  wire:loading.attr="disabled">
                {{ isset($repoId) ? 'Update Repository' : 'Add Repository' }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{--  Update Repository  --}}
    <x-jet-dialog-modal wire:model="repositoryUP">
        <x-slot name="title">
            <div class="flex justify-between">
                {{ isset($repoId) ? 'Update Repository' : 'Add Repository' }}
                <button class="p-2 hover:bg-blue-300 focus:outline-none rounded-md shadow-md"  wire:click="$toggle('repositoryUP')" wire:loading.attr="disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </x-slot>

        <x-slot name="content">
            <x-jet-validation-errors class="mb-4" />
            @if (!empty($repoId))
                <div>
                    <x-jet-label for="repoThumnail" value="{{ __('Repository Image') }}" />
                    <x-jet-input id="repoThumnail" wire:model="repoThumnail" class="block mt-1 w-full" type="file" name="repoThumnail" :value="old('repoThumnail')" />
                </div>
                <div class="mt-4">
                    <x-jet-label for="repoTitle" value="{{ __('Repository Title') }}" />
                    <x-jet-input id="repoTitle" wire:model="repoTitle" class="block mt-1 w-full" type="text" name="repoTitle" :value="old('repoTitle')" />
                </div>
                <div class="mt-4">
                    <x-jet-label for="repoDescription" value="{{ __('Repository Description') }}" />
                    <textarea name="repoDescription" id="repoDescription" rows="5" wire:model="repoDescription" class="block mt-1 w-full border-gray-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md"></textarea>
                </div>
                <div class="mt-4 sm:flex justify-between items-center">
                    <div class="flex-1 sm:mr-2">
                        <x-jet-label for="printISSN" value="{{ __('Repository ISSN') }}" />
                        <x-jet-input id="printISSN" wire:model="printISSN" class="block mt-1 w-full" type="text" name="printISSN" :value="old('printISSN')" />
                    </div>
                    <div class="flex-1 sm:ml-2">
                        <x-jet-label for="onlineISSN" value="{{ __('Repository E-ISSN') }}" />
                        <x-jet-input id="onlineISSN" wire:model="onlineISSN" class="block mt-1 w-full" type="text" name="onlineISSN" :value="old('onlineISSN')" />
                    </div>
                </div>
                <div class="mt-4 sm:flex justify-between items-center">
                    <div class="flex-1 sm:mr-2">
                        <x-jet-label for="abbreviation" value="{{ __('Repository Abbrev') }}" />
                        <x-jet-input id="abbreviation" wire:model="abbreviation" class="block mt-1 w-full" type="text" name="abbreviation" :value="old('abbreviation')" />
                    </div>
                    <div class="flex-1 sm:ml-2">
                        <x-jet-label for="adminEmail" value="{{ __('Repository Contact') }}" />
                        <x-jet-input id="adminEmail" wire:model="adminEmail" class="block mt-1 w-full" type="text" name="adminEmail" :value="old('adminEmail')" />
                    </div>
                </div>
                <div class="mt-4">
                    <x-jet-label for="baseURL" value="{{ __('Repository URL') }}" />
                    <x-jet-input id="baseURL" wire:model="baseURL" class="block mt-1 w-full" type="url" name="baseURL" :value="old('baseURL')" />
                </div>
            @else
                <div>
                    <x-jet-label for="baseURL" value="{{ __('Repository URL') }}" />
                    <x-jet-input id="baseURL" wire:model="baseURL" class="block mt-1 w-full" type="text" name="baseURL" :value="old('baseURL')" />
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click="updateRepo()"  wire:loading.attr="disabled">
                {{ isset($repoId) ? 'Update Repository' : 'Add Repository' }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
