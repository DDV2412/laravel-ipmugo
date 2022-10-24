<div class="h-28 shadow-md" style="background-image: url('https://img.wallpapersafari.com/desktop/1366/768/52/6/yzmaux.jpg'); background-size: cover; background-repeat: no-repeat">
    <div class="max-w-4xl sm:mx-auto pt-4 text-center mx-2">
        <p class="font-medium italic text-3xl py-4 text-orange-500">Digital Library</p>
        <form action="{{ route('search') }}" class="flex items-center">
            <x-jet-input id="query" value="{{ Request::query('query') }}" class="block w-full" type="text" name="query" placeholder="Search Journal, Article..."/>
            <button class="bg-blue-500 hover:bg-blue-300 p-3 focus:outline-none text-white rounded-md shadow-md ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </button>
        </form>
    </div>
</div>
