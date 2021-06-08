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
                        <td class="text-center py-2 truncate">
                            {{ $model->$field }}
                        </td>
                    @endforeach
                    <td class="text-center py-2">

                        <x-buttons.table-action :active="$showView ?? true" :action="__('/' . $resource . '/' . $model->id)" :icon="__('view')"/>

                        <x-buttons.table-action :active="$showEdit ?? true" :action="__('/' . $resource . '/' . $model->id . '/edit')" :icon="__('edit')"/>

                        <x-buttons.table-action :active="$showDelete ?? true" :method="__('DELETE')" :action="__('/' . $resource . '/' . $model->id)" :icon="__('delete')" :danger="__(true)"/>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <x-alerts.empty/>
@endif

@if($nestedResource ?? false)
    <x-buttons.link :active="$showCreate ?? true" :action="__('/' . $nestedResource . '/create')" :caption="__('Add new')" :icon="__('plus')"/>
@else
    <x-buttons.link :active="$showCreate ?? true" :action="__('/' . $resource . '/create')" :caption="__('Add new')" :icon="__('plus')"/>
@endif


