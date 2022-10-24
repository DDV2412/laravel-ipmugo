<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h1 class="text-xl font-extrabold mt-2">{{ __('Register to your accounts') }}</h1>
            <p class="text-sm py-1">{{ __('Already registered?') }} <a href="{{ route('login') }}" class="text-blue-500 font-semibold">{{ __('Sign in here') }}</a></p>
            
            {{-- Sosial Account --}}
            <div class="mt-4 flex justify-center">
                <a href="{{ route('login.facebook') }}" class="my-2 mx-2 rounded-full inline-flex items-center p-2 border border-transparent font-semibold text-xs uppercase tracking-widest focus:outline-none  disabled:opacity-25 transition shadow-md">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w-10 text-blue-500 transform transition" viewBox="0 0 167.657 167.657" fill="currentColor">
                        <g>
                            <path d="M83.829,0.349C37.532,0.349,0,37.881,0,84.178c0,41.523,30.222,75.911,69.848,82.57v-65.081H49.626
                                v-23.42h20.222V60.978c0-20.037,12.238-30.956,30.115-30.956c8.562,0,15.92,0.638,18.056,0.919v20.944l-12.399,0.006
                                c-9.72,0-11.594,4.618-11.594,11.397v14.947h23.193l-3.025,23.42H94.026v65.653c41.476-5.048,73.631-40.312,73.631-83.154
                                C167.657,37.881,130.125,0.349,83.829,0.349z"/>
                        </g>
                    </svg>
                </a>
                <a href="{{ route('login.github') }}" class="my-2 mx-2 rounded-full inline-flex items-center p-2 border border-transparent font-semibold text-xs uppercase tracking-widest focus:outline-none  disabled:opacity-25 transition shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"  class="w-10 transform transition" fill="currentColor">
                        <g>
                            <path d="M255.968,5.329C114.624,5.329,0,120.401,0,262.353c0,113.536,73.344,209.856,175.104,243.872
                                c12.8,2.368,17.472-5.568,17.472-12.384c0-6.112-0.224-22.272-0.352-43.712c-71.2,15.52-86.24-34.464-86.24-34.464
                                c-11.616-29.696-28.416-37.6-28.416-37.6c-23.264-15.936,1.728-15.616,1.728-15.616c25.696,1.824,39.2,26.496,39.2,26.496
                                c22.848,39.264,59.936,27.936,74.528,21.344c2.304-16.608,8.928-27.936,16.256-34.368
                                c-56.832-6.496-116.608-28.544-116.608-127.008c0-28.064,9.984-51.008,26.368-68.992c-2.656-6.496-11.424-32.64,2.496-68
                                c0,0,21.504-6.912,70.4,26.336c20.416-5.696,42.304-8.544,64.096-8.64c21.728,0.128,43.648,2.944,64.096,8.672
                                c48.864-33.248,70.336-26.336,70.336-26.336c13.952,35.392,5.184,61.504,2.56,68c16.416,17.984,26.304,40.928,26.304,68.992
                                c0,98.72-59.84,120.448-116.864,126.816c9.184,7.936,17.376,23.616,17.376,47.584c0,34.368-0.32,62.08-0.32,70.496
                                c0,6.88,4.608,14.88,17.6,12.352C438.72,472.145,512,375.857,512,262.353C512,120.401,397.376,5.329,255.968,5.329z"/>
                        </g>
                    </svg>
                </a>
                <a href="{{ route('login.google') }}"  class="my-2 mx-2 rounded-full inline-flex items-center p-2 border border-transparent font-semibold text-xs uppercase tracking-widest focus:outline-none  disabled:opacity-25 transition shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-10 transform transition" fill="currentColor">
                        <path style="fill:#FBBB00;" d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256
                        c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456
                        C103.821,274.792,107.225,292.797,113.47,309.408z"/>
                        <path style="fill:#518EF8;" d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451
                        c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535
                        c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z"/>
                        <path style="fill:#28B446;" d="M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512
                        c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771
                        c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z"/>
                        <path style="fill:#F14336;" d="M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012
                        c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0
                        C318.115,0,375.068,22.126,419.404,58.936z"/>
                    </svg>
                </a>
            </div>

            <div class="mt-4">
                <x-jet-label for="username" value="{{ __('Username') }}" />
                <x-jet-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"/>
            </div>

            <div class="mt-4 sm:flex items-center">
                <div class="flex-1">
                    <x-jet-label for="firstname" value="{{ __('First Name') }}" />
                <x-jet-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')"/>
                </div>
                <div class="flex-1 sm:ml-2 mt-4 sm:mt-0">
                    <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
                <x-jet-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')"/>
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4 sm:flex items-center">
                <div class="flex-1">
                    <x-jet-label for="interest" value="{{ __('Interest') }}" />
                <x-jet-input id="interest" class="block mt-1 w-full" type="text" name="interest" :value="old('interest')" />
                </div>
                <div class="flex-1 sm:ml-2 mt-4 sm:mt-0">
                    <x-jet-label for="country" value="{{ __('Country') }}" />
                    @include('components.frontend.country')
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="affiliation" value="{{ __('Affiliation') }}" />
                <textarea name="affiliation" id="affiliation" class="border-gray-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md block mt-1 w-full"></textarea>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
