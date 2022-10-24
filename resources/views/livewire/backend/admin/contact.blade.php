@section('title', 'Contact')
<div class="px-2">
    {{--  User Table  --}}
    <div class="py-4 overflow-x-auto min-w-full">
        <div class="">
            <div class="sm:flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <select wire:model="paginate" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md mr-4">
                        <option>{{ __('10') }}</option>
                        <option>{{ __('15') }}</option>
                        <option>{{ __('25') }}</option>
                    </select>
                    <x-jet-input wire:model.debounce.300ms="search" class="block w-full" type="text" placeholder="Search ..." />
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
                        <div wire:click="sortBy('name')" class="flex items-center" style="cursor:pointer">
                            @include('components.backend.sort-icon', ['field' => 'name'])
                            <span>{{ __('Name') }}</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        <div wire:click="sortBy('email')" class="flex items-center" style="cursor:pointer">
                            @include('components.backend.sort-icon', ['field' => 'email'])
                            <span>{{ __('Email') }}</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        <div wire:click="sortBy('massage')" class="flex items-center" style="cursor:pointer">
                            @include('components.backend.sort-icon', ['field' => 'massage'])
                            <span>{{ __('Massage') }}</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        <div wire:click="sortBy('address')" class="flex items-center" style="cursor:pointer">
                            @include('components.backend.sort-icon', ['field' => 'address'])
                            <span>{{ __('Address') }}</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        <div wire:click="sortBy('countryName')" class="flex items-center" style="cursor:pointer">
                            @include('components.backend.sort-icon', ['field' => 'countryName'])
                            <span>{{ __('Country Name') }}</span>
                        </div>
                    </th>
                    
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($contacs as $contac)
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">
                            {{ $contac->id }}
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $contac->name }}
                            </div>
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap text-sm">
                            {{ $contac->email }}
                        </td>
                        <td class="px-6 py-2 text-sm text-gray-500">
                            {{ $contac->massage }}
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ $contac->address }}
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ $contac->countryName }}
                        </td>
                        
                        @empty
                        <td colspan="6" class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                           <div class="flex items-center min-w-full justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span>Contact Empty</span>
                           </div>
                        </td>
                    </tr>                   
                    @endforelse
                </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $contacs->links() }}
            </div>
        </div>
    </div>
</div>
