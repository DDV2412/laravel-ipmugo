<nav x-data="{ open: false }" class="fixed left-0 right-0 top-0 bg-white border-b border-gray-100 h-16 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 text-blue-500" viewBox="0 0 125.533 64.114" fill="currentColor">
                            <g transform="translate(-1927 -2183.497)">
                                <path d="M1983.683,2198.985c-30.6,21.63-29.659,57.937-56.683,63.141C1950.136,2237.045,1956.845,2198.734,1983.683,2198.985Z" transform="translate(0 -14.515)"/>
                                <path d="M2433.341,2192.369c-21.381,21.632-23.452,50.6-47.341,55.241,18.121-19.626,26.146-47.34,41.634-58.376,22.448-15.925,54.99,3.449,32.6,31.791l-9.217-1C2467.764,2203.782,2451.462,2174.123,2433.341,2192.369Z" transform="translate(-430.22)"/>
                                <path d="M3141.716,2352c-.689,6.02-5.456,47.968-17.055,44.519-3.95-1.191-6.646-7.336-3.825-12.792l-9.908-1.316L3094,2402.6l11.161.689,7.147-9.28c23.075,14.735,33.734-1.818,34.047-21.068C3146.481,2365.983,3143.536,2358.207,3141.716,2352Z" transform="translate(-1093.827 -157.938)"/>
                            </g>
                        </svg>
                    </a>
                </div>

                {{-- Navigation Link --}}
                <div class="hidden space-x-4 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('journals') }}" :active="request()->routeIs('journals')">
                        {{ __('Journals') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('articles') }}" :active="request()->routeIs('articles')">
                        {{ __('Articles') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('about-us') }}" :active="request()->routeIs('about-us')">
                        {{ __('About Us') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">
                        {{ __('Contact') }}
                    </x-jet-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @if (Route::has('login'))
                   @auth
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none  transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->username }}" />
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                            {{ Auth::user()->username }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>
                                @role('Administrator')
                                <x-jet-dropdown-link href="{{ route('admin.dashboard') }}">
                                    {{ __('Dashboard') }}
                                </x-jet-dropdown-link>
                                <x-jet-dropdown-link href="{{ route('admin.profile') }}">
                                    {{ __('Setting Profile') }}
                                </x-jet-dropdown-link>
                                @endrole

                                @role('Assistent')
                                <x-jet-dropdown-link href="{{ route('assistent.dashboard') }}">
                                    {{ __('Dashboard') }}
                                </x-jet-dropdown-link>
                                <x-jet-dropdown-link href="{{ route('assistent.profile') }}">
                                    {{ __('Setting Profile') }}
                                </x-jet-dropdown-link>
                                @endrole

                                @role('Reader')
                                <x-jet-dropdown-link href="{{ route('reader.dashboard') }}">
                                    {{ __('Dashboard') }}
                                </x-jet-dropdown-link>
                                <x-jet-dropdown-link href="{{ route('reader.profile') }}">
                                    {{ __('Setting Profile') }}
                                </x-jet-dropdown-link>
                                @endrole
                                <div class="border-t border-gray-100"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-jet-dropdown-link href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-jet-dropdown-link>
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 rounded-md mx-2 text-white hover:bg-blue-300 uppercase font-semibold text-xs tracking-widest disabled:opacity-25 transition">Login</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-orange-500 rounded-md mx-2 text-white hover:bg-orange-300 uppercase font-semibold text-xs tracking-widest disabled:opacity-25 transition">Register</a>
                    @endif
                @endauth
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                @if (Route::has('login'))
                @auth
                    <button @click="open = ! open" class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none  transition">
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->username }}" />
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                
                @else
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endauth
                @endif
            </div>
        </div>
    </div>

    {{-- Responsive --}}
    @if (Route::has('login'))
    @auth
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white">
            @role('Administrator')
            <div class="pt-2 pb-3 space-y-1">
                <x-jet-responsive-nav-link href="{{ route('admin.dashboard') }}" class="flex items-center" :active="request()->routeIs('admin.dashboard')">
                    <span class="mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </span>
                    <span>{{ __('Dashboard') }}</span>
                </x-jet-responsive-nav-link>
            </div>
            @endrole

            @role('Assistent')
            <div class="pt-2 pb-3 space-y-1">
                <x-jet-responsive-nav-link href="{{ route('assistent.dashboard') }}" class="flex items-center" :active="request()->routeIs('assistent.dashboard')">
                    <span class="mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </span>
                    <span>{{ __('Dashboard') }}</span>
                </x-jet-responsive-nav-link>
            </div>
            @endrole

            @role('Reader')
            <div class="pt-2 pb-3 space-y-1">
                <x-jet-responsive-nav-link href="{{ route('reader.dashboard') }}" class="flex items-center" :active="request()->routeIs('reader.dashboard')">
                    <span class="mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </span>
                    <span>{{ __('Dashboard') }}</span>
                </x-jet-responsive-nav-link>
            </div>
            @endrole

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="flex-shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->username }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->username }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Account Management -->
                    <x-jet-responsive-nav-link href="{{ route('journals') }}" class="flex items-center" :active="request()->routeIs('journals')">
                        <span class="mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                              </svg>
                        </span>
                        <span>{{ __('Journals') }}</span>
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('articles') }}" class="flex items-center" :active="request()->routeIs('articles')">
                        <span class="mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span>{{ __('Articles') }}</span>
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('about-us') }}" class="flex items-center" :active="request()->routeIs('about-us')">
                        <span class="mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd" />
                              </svg>
                        </span>
                        <span>{{ __('About Us') }}</span>
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('contact') }}" class="flex items-center" :active="request()->routeIs('contact')">
                        <span class="mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </span>
                        <span>{{ __('Contact') }}</span>
                    </x-jet-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
    
                        <x-jet-responsive-nav-link href="{{ route('logout') }}" class="flex items-center"
                                       onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                        <span class="mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                              </svg>
                                        </span>
                                          <span>
                                            {{ __('Log Out') }}
                                          </span>
                        </x-jet-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    @else
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white pb-6 rounded-md shadow-md">
        <x-jet-responsive-nav-link href="{{ route('journals') }}" class="flex items-center" :active="request()->routeIs('journals')">
            <span class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                  </svg>
            </span>
            <span>{{ __('Journals') }}</span>
        </x-jet-responsive-nav-link>
        <x-jet-responsive-nav-link href="{{ route('articles') }}" class="flex items-center" :active="request()->routeIs('articles')">
            <span class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                </svg>
            </span>
            <span>{{ __('Articles') }}</span>
        </x-jet-responsive-nav-link>
        <x-jet-responsive-nav-link href="{{ route('about-us') }}" class="flex items-center" :active="request()->routeIs('about-us')">
            <span class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd" />
                  </svg>
            </span>
            <span>{{ __('About Us') }}</span>
        </x-jet-responsive-nav-link>
        <x-jet-responsive-nav-link href="{{ route('contact') }}" class="flex items-center" :active="request()->routeIs('contact')">
            <span class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
            </span>
            <span>{{ __('Contact') }}</span>
        </x-jet-responsive-nav-link>
        <div class="mt-4">
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 rounded-md mx-4 text-white hover:bg-blue-300 uppercase font-semibold text-xs tracking-widest disabled:opacity-25 transition">Login</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="px-4 py-2 bg-orange-500 rounded-md mx-2 text-white hover:bg-orange-300 uppercase font-semibold text-xs tracking-widest disabled:opacity-25 transition">Register</a>
            @endif
        </div>
    </div>
    @endauth
    @endif
    
</nav>
