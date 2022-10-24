@section('title', 'Users')
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
                <div class="mt-2 sm:mt-0">
                    <x-jet-button wire:click="createUser()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                        </svg>
                        <span>{{ __('Add User') }}</span>
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
                        <div wire:click="sortBy('firstname')" class="flex items-center" style="cursor:pointer">
                            @include('components.backend.sort-icon', ['field' => 'firstname'])
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
                        <span>{{ __('Role') }}</span>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        <span>{{ __('Last Activity') }}</span>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        {{ __('Actions') }}
                    </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">
                            @if ($user->isOnline())
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                {{ $user->id }}
                            </div>
                            @else
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd" />
                                </svg>
                                {{ $user->id }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $user->firstname }}  {{ $user->lastname }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $user->department }}
                            </div>
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap text-sm">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                <label>{{ $v }}</label>
                                @endforeach
                            @endif 
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                            @if($user->last_seen != null)
                            {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                            @else
                                No Record
                            @endif
                        </td>
                        
                        <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="editUser({{ $user->id }})" class="p-2 bg-blue-500 hover:bg-blue-400 focus:outline-none shadow-md rounded-md text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button wire:click="deleteUser({{ $user->id }})" class="p-2 bg-red-500 hover:bg-red-400 focus:outline-none shadow-md rounded-md text-white">
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
                            <span>User Not Registered</span>
                           </div>
                        </td>
                    </tr>                   
                    @endforelse
                </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
   
  {{--  Create User  --}}
  <x-jet-dialog-modal wire:model="UsersAdd">
    <x-slot name="title">
        <div class="flex justify-between">
            {{ isset($userId) ? 'Update User' : 'Add User' }}
            <button class="p-2 hover:bg-blue-300 focus:outline-none rounded-md shadow-md"  wire:click="$toggle('UsersAdd')" wire:loading.attr="disabled">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </x-slot>

    <x-slot name="content">
        <x-jet-validation-errors />
        <div class="mt-4">
            <x-jet-label for="username" value="{{ __('Username') }}" />
            <x-jet-input id="username"  wire:model="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required />
        </div>

        <div class="mt-4 sm:flex items-center">
            <div class="flex-1">
                <x-jet-label for="firstname" value="{{ __('First Name') }}" />
            <x-jet-input id="firstname"  wire:model="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            </div>
            <div class="flex-1 sm:ml-2 mt-4 sm:mt-0">
                <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
            <x-jet-input id="lastname"  wire:model="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
            </div>
        </div>

        <div class="mt-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" wire:model="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
        </div>

        <div class="mt-4 sm:flex items-center">
            <div class="sm:mr-4 flex-1">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" wire:model="password" class="block mt-1 w-full" type="password" name="password"  />
            </div>
            <div class=" flex-1">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" wire:model="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
            </div>
        </div>
        <div class="mt-4 sm:flex items-center">
            <div class="flex-1">
                <x-jet-label for="interest" value="{{ __('Interest') }}" />
            <x-jet-input id="interest"  wire:model="interest" class="block mt-1 w-full" type="text" name="interest" :value="old('interest')" required autofocus autocomplete="interest" />
            </div>
            <div class="flex-1 sm:ml-2 mt-4 sm:mt-0">
                <x-jet-label for="country" value="{{ __('Country') }}" />
                @include('components.frontend.country')
            </div>
        </div>
        <div class="mt-4">
            <textarea name="affiliation" wire:model="affiliation" id="affiliation" class="block mt-1 w-full border-gray-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md" rows="5"></textarea>
        </div>
        <div class="mt-4 px-2 flex items-center"> 
                @foreach ($roles as $id => $roles)
                <div class="flex items-center">
                    <x-jet-input name="roles[]" wire:model="userRoles.{{ $id }}" id="roles" type="checkbox" value="{{ $id }}"/>
                    <x-jet-label for="roles" class="px-2" value="{{ $roles }}" />
                </div>
            @endforeach
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-button wire:click="storeUser()">
            {{ isset($userId) ? 'Update User' : 'Add User' }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>

    {{--  Update  --}}
    <x-jet-dialog-modal wire:model="UserEdit">
        <x-slot name="title">
            <div class="flex justify-between">
                {{ isset($userId) ? 'Update User' : 'Add User' }}
                <button class="p-2 hover:bg-blue-300 focus:outline-none rounded-md shadow-md"  wire:click="$toggle('UserEdit')" wire:loading.attr="disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </x-slot>

        <x-slot name="content">
            <x-jet-validation-errors />
            <div class="mt-4">
                <x-jet-label for="username" value="{{ __('Username') }}" />
                <x-jet-input id="username" wire:model="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required />
            </div>

            <div class="mt-4 sm:flex items-center">
                <div class="flex-1">
                    <x-jet-label for="firstname" value="{{ __('First Name') }}" />
                <x-jet-input id="firstname" wire:model="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
                </div>
                <div class="flex-1 sm:ml-2 mt-4 sm:mt-0">
                    <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
                <x-jet-input id="lastname" wire:model="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" wire:model="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
            </div>

            <div class="mt-4 sm:flex items-center">
                <x-jet-button wire:click="editPassword()">{{ __('Change Password') }}</x-jet-button>
            </div>
            <div class="mt-4 sm:flex items-center">
                <div class="flex-1">
                    <x-jet-label for="interest" value="{{ __('Interest') }}" />
                <x-jet-input id="interest" wire:model="interest" class="block mt-1 w-full" type="text" name="interest" :value="old('interest')" required autofocus autocomplete="interest" />
                </div>
                <div class="flex-1 sm:ml-2 mt-4 sm:mt-0">
                    <x-jet-label for="country" value="{{ __('Country') }}" />
                    @include('components.frontend.country')
                </div>
            </div>
            <div class="mt-4">
                <textarea name="affiliation" wire:model="affiliation" id="affiliation" class="block mt-1 w-full border-gray-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md" rows="5"></textarea>
            </div>
            <div class="mt-4 px-2 flex items-center"> 
                    @foreach ($editRoles as $id => $editRoles)
                    <div class="flex items-center">
                        <x-jet-input name="roles[]" wire:model="userRoles.{{ $id }}" id="roles" type="checkbox" value="{{ $id }}"/>
                        <x-jet-label for="roles" class="px-2" value="{{ $editRoles }}" />
                    </div>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click="storeUser()">
                {{ isset($userId) ? 'Update User' : 'Add User' }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

     {{--  UpdatePass  --}}
     <x-jet-dialog-modal wire:model="passUpdate">
        <x-slot name="title">
            <div class="flex justify-between">
                {{ isset($userId) ? 'Update Password' : 'Add Password' }}
                <button class="p-2 hover:bg-blue-300 focus:outline-none rounded-md shadow-md"  wire:click="$toggle('passUpdate')" wire:loading.attr="disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </x-slot>

        <x-slot name="content">
            <x-jet-validation-errors />
            <div class="px-2">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" wire:model="passwordNew" class="block mt-1 w-full" type="password" name="password"  autocomplete="new-password" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click="updatePassword()">
                {{ isset($userId) ? 'Update Password' : 'Add Password' }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
