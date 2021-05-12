<div class="py-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

        @if($header ?? false)
            <h2 class="font-semibold text-l text-green-500 leading-tight pb-3">
                {{ $header }}
            </h2>
        @endif

        @if($list->count() > 0)
            <table class="table-fixed w-full divide-y divide-gray-600">
                <thead>
                    <tr>
                        {{ $headers }}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @foreach($list as $model)
                        <tr>
                            @foreach($fields as $field)
                                <td class="text-center py-2">
                                    {{ $model->$field }}
                                </td>
                            @endforeach
                            <td class="text-center py-2">
                                @if($showView ?? true)
                                    <a class="inline-block mr-2 hover:text-green-500 transition"href="/{{ $resource }}/{{ $model->id }}">
                                        <x-svg-view class="h-5 w-5"></x-svg-view>
                                    </a>
                                @endif
                                @if($showEdit ?? true)
                                    <a class="inline-block mr-2 hover:text-green-500 transition" href="/{{ $resource }}/{{ $model->id }}/edit">
                                        <x-svg-edit class="h-5 w-5"></x-svg-edit>
                                    </a>
                                @endif
                                @if($showDelete ?? true)
                                    <form class="inline-block" method="POST" action="/{{ $resource }}/{{ $model->id }}">
                                        @csrf

                                        <input name="_method" type="hidden" value="DELETE">

                                        <a class="inline-block cursor-pointer hover:text-red-600 transition" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <x-svg-delete class="h-5 w-5"></x-svg-delete>
                                        </a>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">No entries here yet...</p>
                        <p class="text-sm">Click on the 'add new' button below to get started!</p>
                    </div>
                </div>
            </div>
        @endif

        @if($showCreate ?? true)
            <a @if($nestedResource ?? false) href="/{{ $nestedResource }}/create" @else href="/{{ $resource }}/create" @endif class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <x-svg-plus class="h-5 w-5 mr-2"></x-svg-plus>
                <span>Add new</span>
            </a>
        @endif
    </div>
</div>