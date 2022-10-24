@section('title', 'About Us')
<div class="pt-16 pb-10 bg-blue-500">
    <div class="max-w-4xl mx-auto px-2">
        <div class="sm:flex items-start">
            <div class="flex-1 sm:mr-6">
                <h1 class="text-4xl text-white font-semibold pb-4">IPMUGO <br>Digital Library</h1>
                <p class="text-white pb-4 sm:pb-0">The goal of the IPMUGO Online Library is to provide published scientific articles for open societies through online archiving.  Through IPMUGO Online Library we want to provide a place for readers to get the full-text of open access articles they want quickly in one click. Achieving it will require the participation of open publishers, government officials, and technologists.
                <span class="mt-2">If you are interested to suggest a journal to be included in our coverage</span>
                </p>
                <a href="{{ route('contact') }}" class="mb-4 sm:mb-0 mt-4 inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-300 active:bg-orange-500 focus:outline-none focus:border-orange-500 focus:ring focus:ring-orange-300 disabled:opacity-25 transition shadow-md">{{ __('Contact Us Here') }}</a>
            </div>
            <div class="flex-1">
                <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=750&q=80" alt="" class="max-w-full rounded-md shadow-md">
            </div>
        </div>
    </div>
</div>
