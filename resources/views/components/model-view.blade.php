<div class="py-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

        @if(isset($header))
            <h2 class="font-semibold text-l text-indigo-600 leading-tight pb-3">
                {{ $header }}
            </h2>
        @endif

        <div class="grid grid-cols-4 gap-4">
            {{ $fields }}
        </div>

        <a href="/{{ $resource }}/{{ $model->id }}/edit" class="mt-5 bg-gray-100 hover:bg-indigo-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
            <x-svg-edit class="h-4 w-4 mr-2"></x-svg-edit>
            <span>Edit</span>
        </a>

    </div>
</div>