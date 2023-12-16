<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form id="salesForm" method="POST" action="{{ route('record.sales') }}">
                    @csrf
                    <div class="flex">
                        <div class="flex-col">
                            <x-label for="quantity" :value="__('Quantity')"></x-label>
                            <x-input id="quantity" class="block mt-1" type="number" name="quantity"
                                     :value="old('quantity')" required autofocus/>
                        </div>
                        <div class="flex-col">
                            <x-label for="unit" :value="__('Unit Cost (£)')"></x-label>
                            <x-input id="unit" class="block mt-1" type="currency" name="unitCost"
                                     :value="old('unitCost')" required />
                        </div>
                        <div class="flex-col">
                            <span id="fakeLabel" class="block font-medium text-sm text-gray-700">Selling Price</span>
                            <div id="sellingPriceContent"></div>
                        </div>
                        <div class="flex-col">
                            <x-button class="ml-3">
                                {{ __('Record Sale') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
