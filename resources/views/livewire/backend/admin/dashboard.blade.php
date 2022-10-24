@section('title', 'Dashboard')
<div class="px-2">
    <div class="sm:grid grid-cols-4 gap-4 items-center">
        <div class="sm:mx-2 rounded-md shadow-md p-2 bg-blue-500 flex items-center justify-start mb-2 sm:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
            </svg>
            <div class="ml-4">
                <p class="font-semibold text-xl text-white">{{ $users }}</p>
                <p class="text-sm text-white">Subscribers</p>
            </div>
        </div>
        <div class="sm:mx-2 rounded-md shadow-md p-2 bg-blue-500 flex items-center justify-start mb-2 sm:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" class="w-10 h-10 text-white" fill="currentColor"><path d="M 5 3 C 3.895 3 3 3.895 3 5 L 3 20 C 3 21.105 3.895 22 5 22 L 9 22 L 9 26 C 9 26.552 9.448 27 10 27 C 10.3377 27 10.621648 26.821033 10.802734 26.564453 L 10.818359 26.570312 L 14.25 22 L 25 22 C 26.105 22 27 21.105 27 20 L 27 5 C 27 3.895 26.105 3 25 3 L 5 3 z M 11.5 9 C 12.881 9 14 10.119 14 11.5 L 14 12 C 14 14.214 12.899594 16.269094 11.058594 17.496094 L 10.554688 17.832031 L 9.4453125 16.167969 L 9.9492188 15.832031 C 10.647219 15.367031 11.186063 14.728094 11.539062 13.996094 C 11.525062 13.996094 11.513 14 11.5 14 C 10.119 14 9 12.881 9 11.5 C 9 10.119 10.119 9 11.5 9 z M 18.5 9 C 19.881 9 21 10.119 21 11.5 L 21 12 C 21 14.214 19.899594 16.269094 18.058594 17.496094 L 17.554688 17.832031 L 16.445312 16.167969 L 16.949219 15.832031 C 17.647219 15.367031 18.186063 14.728094 18.539062 13.996094 C 18.525063 13.996094 18.513 14 18.5 14 C 17.119 14 16 12.881 16 11.5 C 16 10.119 17.119 9 18.5 9 z"/></svg>
            <div class="ml-4">
                <p class="font-semibold text-xl text-white">{{ $cite }}</p>
                <p class="text-sm text-white">Cite</p>
            </div>
        </div>
        <div class="sm:mx-2 rounded-md shadow-md p-2 bg-blue-500 flex items-center justify-start mb-2 sm:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd" />
            </svg>
            <div class="ml-4">
                <p class="font-semibold text-xl text-white">{{ $download }}</p>
                <p class="text-sm text-white">Download</p>
            </div>
        </div>
        <div class="sm:mx-2 rounded-md shadow-md p-2 bg-blue-500 flex items-center justify-start mb-2 sm:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 20 20" fill="currentColor">
                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
            </svg>
            <div class="ml-4">
                <p class="font-semibold text-xl text-white">{{ $share }}</p>
                <p class="text-sm text-white">Share</p>
            </div>
        </div>
    </div>
   <div class="sm:grid grid-cols-6 gap-4 items-center sm:mx-2"> 
      <div class="mt-1 rounded-md shadow-md pt-2 mb-4 px-2 sm:col-span-4">
         {!! $chart->container() !!}
      </div>
      <div class="mt-1 rounded-md shadow-md pt-2 mb-4 px-2 sm:col-span-2 py-3">
         {!! $chartDown->container() !!}
      </div>
   </div>


   <div class="sm:mx-2 font-semibold text-xl mb-2">10 Top Article Views</div>
   <div class="sm:mx-2 shadow overflow-x-auto border-b border-gray-200 sm:rounded-md mb-8">
      <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-blue-500">
          <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
              <div class="flex items-center" style="cursor:pointer">
                  <span>{{ __('ID') }}</span>
              </div>
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
              <divclass="flex items-center" style="cursor:pointer">
                  <span>{{ __('Title') }}</span>
              </divclass=>
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
              <div class="flex items-center" style="cursor:pointer">
                  <span>{{ __('DOI') }}</span>
              </div>
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
              <div class="flex items-center" style="cursor:pointer">
                  <span>{{ __('Issue') }}</span>
              </div>
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
            <div class="flex items-center" style="cursor:pointer">
                <span>{{ __('Views') }}</span>
            </div>
        </th>
          </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200 text-sm">
      
      @foreach ($popular as $item)
      <tr>
         <td class="px-6 py-2 whitespace-nowrap">
             {{ $item->article->id }}
         </td>
         <td class="px-6 py-2">
            <a href="{{ route('articleDetail', ['abbreviation' => $item->article->repository->abbreviation, 'id' => $item->article->id]) }}">
                {{ $item->article->title }}
            </a>
            <div class="text-gray-500 italic text-xs">
                @foreach ($item->article->author as $author)
                           {{ $author->firstname }} {{ $author->lastname }},
                @endforeach
            </div>
        </td>
        <td class="px-6 py-2 whitespace-nowrap">
            {{ $item->article->doi }}
        </td>
        <td class="px-6 py-2 whitespace-nowrap">
            {{ $item->article->original }}
        </td>
        <td class="px-6 py-2 whitespace-nowrap">
            {{ $item->count }}
        </td>
      </tr>
      @endforeach
      
          
      </tbody>
      </table>
   </div>
   <div class="sm:mx-2 font-semibold text-xl mb-2">10 Top Article Downloads</div>
   <div class="sm:mx-2 shadow overflow-x-auto border-b border-gray-200 sm:rounded-md">
      <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-blue-500">
          <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
              <div class="flex items-center" style="cursor:pointer">
                  <span>{{ __('ID') }}</span>
              </div>
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
              <divclass="flex items-center" style="cursor:pointer">
                  <span>{{ __('Title') }}</span>
              </divclass=>
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
              <div class="flex items-center" style="cursor:pointer">
                  <span>{{ __('DOI') }}</span>
              </div>
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
              <div class="flex items-center" style="cursor:pointer">
                  <span>{{ __('Issue') }}</span>
              </div>
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
            <div class="flex items-center" style="cursor:pointer">
                <span>{{ __('Views') }}</span>
            </div>
        </th>
          </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200 text-sm">
      
      @foreach ($downloads as $item)
      <tr>
         <td class="px-6 py-2 whitespace-nowrap">
             {{ $item->article->id }}
         </td>
         <td class="px-6 py-2">
            <a href="{{ route('articleDetail', ['abbreviation' => $item->article->repository->abbreviation, 'id' => $item->article->id]) }}">
                {{ $item->article->title }}
            </a>
            <div class="text-gray-500 italic text-xs">
                {{ $item->article->author->implode('name', ', ') }}
            </div>
        </td>
        <td class="px-6 py-2 whitespace-nowrap">
            {{ $item->article->doi }}
        </td>
        <td class="px-6 py-2 whitespace-nowrap">
            {{ $item->article->original }}
        </td>
        <td class="px-6 py-2 whitespace-nowrap">
            {{ $item->count }}
        </td>
      </tr>
      @endforeach
      
          
      </tbody>
      </table>
   </div>
</div>

<script src="{{ $chart->cdn() }}"></script>

{{ $chart->script() }}
<script src="{{ $chartDown->cdn() }}"></script>

{{ $chartDown->script() }}
