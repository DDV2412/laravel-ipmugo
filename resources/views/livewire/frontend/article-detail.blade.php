@section('title', $article->title)

<div>
   <div class="h-28 shadow-md" style="background-image: url('https://img.wallpapersafari.com/desktop/1366/768/52/6/yzmaux.jpg'); background-size: cover; background-repeat: no-repeat">
   </div>
   <div class="max-w-7xl mx-auto -mt-20 mb-16">
     <button wire:click="back()" class="mx-2 focus:outline-none">Back</button>
      <div class="mx-2 mt-2">
         <div class="p-4 bg-white rounded-md shadow-md">
            <h1 class="font-semibold text-2xl pb-2">{{ $article->title }}</h1>
            <div class="sm:flex items-center">
               <p class="text-sm italic text-gray-500">{{ $article->publisher }}</p>
               <div class="mx-4 flex items-center">
                  <button wire:click="citeNow()" x-data="{ tooltip: false }" class="relative z-30 inline-flex rounded-md text-blue-500 hover:bg-gray-200 p-2 mb-2 sm:mb-0">
                     <svg x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" class="w-5 h-5" fill="currentColor"><path d="M 5 3 C 3.895 3 3 3.895 3 5 L 3 20 C 3 21.105 3.895 22 5 22 L 9 22 L 9 26 C 9 26.552 9.448 27 10 27 C 10.3377 27 10.621648 26.821033 10.802734 26.564453 L 10.818359 26.570312 L 14.25 22 L 25 22 C 26.105 22 27 21.105 27 20 L 27 5 C 27 3.895 26.105 3 25 3 L 5 3 z M 11.5 9 C 12.881 9 14 10.119 14 11.5 L 14 12 C 14 14.214 12.899594 16.269094 11.058594 17.496094 L 10.554688 17.832031 L 9.4453125 16.167969 L 9.9492188 15.832031 C 10.647219 15.367031 11.186063 14.728094 11.539062 13.996094 C 11.525062 13.996094 11.513 14 11.5 14 C 10.119 14 9 12.881 9 11.5 C 9 10.119 10.119 9 11.5 9 z M 18.5 9 C 19.881 9 21 10.119 21 11.5 L 21 12 C 21 14.214 19.899594 16.269094 18.058594 17.496094 L 17.554688 17.832031 L 16.445312 16.167969 L 16.949219 15.832031 C 17.647219 15.367031 18.186063 14.728094 18.539062 13.996094 C 18.525063 13.996094 18.513 14 18.5 14 C 17.119 14 16 12.881 16 11.5 C 16 10.119 17.119 9 18.5 9 z"/></svg>
                     <div class="relative" x-cloak x-show.transition.origin.top="tooltip">
                       <div class="absolute top-0 z-10 p-2 -mt-1 text-sm min-w-full text-white whitespace-nowrap transform -translate-x-1/2 -translate-y-full bg-blue-500 rounded-lg shadow-lg">
                         {{ __('Cite This') }}
                       </div>
                       <svg class="absolute left-5 z-10 w-6 h-6 text-blue-500 transform -translate-x-12 -translate-y-3 fill-current stroke-current" width="8" height="8">
                        <rect x="12" y="-10" width="8" height="8" transform="rotate(45)" />
                      </svg>
                     </div>
                   </button>
                   @if (Route::has('login'))
                    @auth
                      <button wire:click="saveInLibrary({{ $article->id }})" x-data="{ tooltip: false }" class="relative z-30 inline-flex rounded-md text-blue-500 hover:bg-gray-200 p-2 mb-2 sm:mb-0">
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
                      <a href="{{ route('login') }}" x-data="{ tooltip: false }" class="relative z-30 inline-flex rounded-md text-blue-500 hover:bg-gray-200 p-2 mb-2 sm:mb-0">
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
                      <button x-data="{ tooltip: false }" class="relative z-30 inline-flex rounded-md text-blue-500 hover:bg-gray-200 p-2 mb-2 sm:mb-0 focus:outline-none">
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
                  @if ($article->file_PDF == '')
                      
                  @else
                  <a href="{{ Storage::url($article->file_PDF) }}" wire:click="downloadArticle()" class="relative z-30 inline-flex rounded-md bg-red-500 mb-2 sm:mb-0 text-xs px-4 py-2 ml-3 text-white">
                    {{ __('PDF') }}
                  </a>
                  @endif
               </div>
            </div>
            <p class="text-sm italic text-gray-500">
              
              @foreach ($authors as $author)
                {{ $author->firstname }} {{ $author->lastname }},
              @endforeach
              
            </p>
            <p class="text-sm py-1">{{ $article->repository->repoTitle }}, {{ $article->issue }}
            @if (!empty($article->pages))
              , pp. {{ $article->pages }}
            @else
                
            @endif
              
            </p>

            <p class="font-semibold py-2">Abstract</p>
            <p class="text-sm text-justify">{{ $article->description }}</p>
            <p class="text-sm mt-4 italic">{{ $article->subject->implode('subject', '; ') }}</p>

            <div class="mt-8 border-t-2">
              <p class="text-md font-semibold mt-4 pb-2">{{ __('Publisher: ') }}{{ $article->publisher }}</p>

              <p class="text-sm pb-2">{{ __('Publish Date: ') }}{{ $article->date }}</p>
               <a href="https://doi.org/{{ $article->doi }}" class="text-sm">
                  @if($article->doi == '')
                  @else
                  {{ __('DOI: ') }}{{ $article->doi }}
                  @endif
               </a>
               <p class="text-sm pt-2">{{ __('Publish Year: ') }}{{ $article->year }}</p>
            </div>
         </div>
      </div>
   </div>

   <x-jet-dialog-modal wire:model="citeThis">
      <x-slot name="title">
          <div class="flex justify-between">
              {{ __('Cite this Article') }}
          </div>
      </x-slot>

      <x-slot name="content">
      <div class="flex justify-end">
        <button id="copyCite" wire:click="citeCopy()"  x-data="{ tooltip: false }" class="relative shadow-md z-30 inline-flex rounded-md text-blue-500 hover:bg-gray-200 p-2 mb-2 sm:mb-0">
          <svg x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" />
            <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z" />
          </svg>
          <div class="relative" x-cloak x-show.transition.origin.top="tooltip">
            <div class="absolute top-0 z-10 p-2 -mt-1 text-sm min-w-full text-white whitespace-nowrap transform -translate-x-1/2 -translate-y-full bg-blue-500 rounded-lg shadow-lg">
              {{ __('Copy Cite') }}
            </div>
            <svg class="absolute left-5 z-10 w-6 h-6 text-blue-500 transform -translate-x-12 -translate-y-3 fill-current stroke-current" width="8" height="8">
              <rect x="12" y="-10" width="8" height="8" transform="rotate(45)" />
            </svg>
          </div>
        </button>
      </div>
          <div id="text" class="block p-4 mt-1 w-full border-gray-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md">
            
            @foreach ($authors as $author)
                <?php
                $str = str_split($author->firstname);
                echo (string)$str[0], '. ', $author->lastname,',';
                ?>
            @endforeach
            
            ."{{ $article->title }}". <span class="italic">{{ $article->repository->repoTitle }}</span>, vol. {{ $article->volume }}, no. {{ $article->nomor }}, 
            @if (!empty($article->pages))
              pp. {{ $article->pages }}, 
            @else
                
            @endif
          {{ $article->year }}
          @if (!empty($article->doi))
              , doi: {{ $article->doi }}
          @else
              
          @endif
          .</div>
      </x-slot>

      <x-slot name="footer">
          <x-jet-button wire:click="$toggle('citeThis')" wire:loading.attr="disabled">
              {{ __('close') }}
          </x-jet-button>
      </x-slot>
  </x-jet-dialog-modal>

  <script>
    function copyText(htmlElement){
      if(!htmlElement){
        return;
      }

      let elementText = htmlElement.innerText;
      let inputElement = document.createElement('input');
      inputElement.setAttribute('value', elementText);
      document.body.appendChild(inputElement);
      inputElement.select();
      document.execCommand('copy');
      inputElement.parentNode.removeChild(inputElement);
    }

    document.querySelector('#copyCite').onclick = 
    function()
    {
      copyText(document.querySelector('#text'));
    }
  </script>
</div>
