@section('title', 'History')
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
                <div wire:click="sortBy('from')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'from'])
                    <span>{{ __('From') }}</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                <div wire:click="sortBy('until')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'until'])
                    <span>{{ __('Until') }}</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                <div wire:click="sortBy('address')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'address'])
                    <span>{{ __('Address') }}</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                <div wire:click="sortBy('listRecords')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'listRecords'])
                    <span>{{ __('List Records') }}</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                <div wire:click="sortBy('countRecords')" class="flex items-center" style="cursor:pointer">
                    @include('components.backend.sort-icon', ['field' => 'countRecords'])
                    <span>{{ __('Count Records') }}</span>
                </div>
            </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 text-sm">
            @forelse ($histories as $history)
             <tr>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $history->id }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $history->from }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $history->until }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $history->address }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $history->listRecords }}
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                    {{ $history->countRecords }}
                </td>
                @empty
                <td colspan="7" class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                    <div class="flex items-center min-w-full justify-center">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-4" viewBox="0 0 20 20" fill="currentColor">
                         <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                     </svg>
                     <span>No Data History Harvest</span>
                    </div>
                </td>
            </tr>
            @endforelse
            
        </tbody>
        </table>
    </div>
    <div class="py-4 mx-2">
        {{ $histories->links() }}
    </div>
</div>
