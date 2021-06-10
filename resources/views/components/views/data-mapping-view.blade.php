
<div class="grid grid-cols-11 gap-0 pt-3">

    <div class="col-span-5">
        <div class="text-m px-2 leading-tight">Input model</div>
        <x-views.data-model-view :fields="$inputFields" :showEdit="__(false)" :showDelete="__(false)" :showSwap="__(false)" :showCreate="__(false)" :resource="$resource ?? ''"/>
    </div>
    <div class="col-span-1 text-center align-middle">
        <x-icons.svg-chevron-right class="h-5 w-5 mr-2 inline align-middle h-full"></x-icons.svg-chevron-right>
    </div>
    <div class="col-span-5">
        <div class="text-m px-2 leading-tight">Result output model</div>
        <x-views.data-model-view :mapping="$mapping" :mappingFields="$mappingFields" :fields="$outputFields" :showEdit="__(false)" :showDelete="__(false)" :showCreate="__(false)" :showSwap="__(false)" :resource="$resource ?? ''"></x-views.data-model-view>
    </div>

</div>