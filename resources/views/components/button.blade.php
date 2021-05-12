<button {{ $attributes->merge(['type' => 'submit', 'class' => 'mt-5 bg-green-500 text-white hover:bg-green-600 disabled:bg-gray-200 transition disabled:text-gray-400 font-bold py-2 px-4 rounded inline-flex items-center']) }}>
    {{ $slot }}
</button>
