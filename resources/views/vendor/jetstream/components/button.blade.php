<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-300 active:bg-blue-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-300 disabled:opacity-25 transition shadow-md']) }}>
    {{ $slot }}
</button>
