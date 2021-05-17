<div class="border-2 border-indigo-{{ $level % 9 }}00 overflow-hidden sm:rounded-lg p-2 pl-4 pr-4 mt-4 mb-2">
    <div class="mr-3 inline-block">
        {{ $field->name }}
    </div>

    <div class="text-gray-400 inline-block">
        {{ $field->node_type }}@if($field->data_type ?? false), {{ $field->data_type }} @endif
    </div>

    <div class="inline-block text-gray-400 float-right">
        @if($showEdit ?? true)
            <a class="inline-block mr-2 hover:text-green-400 transition" href="/{{ $resource }}/{{ $field->id }}/edit">
                <x-icons.svg-edit class="h-5 w-5"></x-icons.svg-edit>
            </a>
        @endif
        @if($showDelete ?? true)
            <form class="inline-block" method="POST" action="/{{ $resource }}/{{ $field->id }}">
                @csrf

                <input name="_method" type="hidden" value="DELETE">

                <a class="inline-block cursor-pointer hover:text-red-600 transition" onclick="event.preventDefault(); this.closest('form').submit();">
                    <x-icons.svg-delete class="h-5 w-5"></x-icons.svg-delete>
                </a>
            </form>
        @endif
    </div>

    @if (count($field->children()->get()) > 0)
        <div class="gap-4 mt-3">
            @foreach($field->children()->get() as $child)
                <x-subpages.model-field :field="$child" :level="$level + 1" :showEdit="$showEdit" :showDelete="$showDelete" :resource="$resource ?? ''"></x-subpages.model-field>
            @endforeach
        </div>
	@endif
</div>
	