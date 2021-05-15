<div class="py-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

        @if($header ?? false)
            <h2 class="font-semibold text-l text-green-400 leading-tight pb-3">
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
                                    <a class="inline-block mr-2 hover:text-green-400 transition"href="/{{ $resource }}/{{ $model->id }}">
                                        <x-icons.svg-view class="h-5 w-5"></x-icons.svg-view>
                                    </a>
                                @endif
                                @if($showEdit ?? true)
                                    <a class="inline-block mr-2 hover:text-green-400 transition" href="/{{ $resource }}/{{ $model->id }}/edit">
                                        <x-icons.svg-edit class="h-5 w-5"></x-icons.svg-edit>
                                    </a>
                                @endif
                                @if($showDelete ?? true)
                                    <form class="inline-block" method="POST" action="/{{ $resource }}/{{ $model->id }}">
                                        @csrf

                                        <input name="_method" type="hidden" value="DELETE">

                                        <a class="inline-block cursor-pointer hover:text-red-600 transition" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <x-icons.svg-delete class="h-5 w-5"></x-icons.svg-delete>
                                        </a>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <x-alerts.model-empty></x-alerts.model-empty>
        @endif

        @if($showCreate ?? true)
            <a @if($nestedResource ?? false) href="/{{ $nestedResource }}/create" @else href="/{{ $resource }}/create" @endif class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <x-icons.svg-plus class="h-5 w-5 mr-2"></x-icons.svg-plus>
                <span>Add new</span>
            </a>
        @endif
    </div>
</div>