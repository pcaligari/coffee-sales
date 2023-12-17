@push('other-scripts')
    <script>
        // Going old-skool with Jquery - would be lovely as a react view instead though
        function getPrice() {
            $.ajax(
                {
                    url: "/getPrice?units=" + $("#qty").val() + "&unitCost=" + $("#unit").val(),
                    success: function(response) {
                        $("#sellingPriceContent").text(response);
                    },
                    error: function(xhr) {
                        alert("Something went wrong - please try again");
                    }
                }
            )
        }

        function changeAction() {
            if (!isNaN(parseInt($("#qty").val())) && !isNaN(parseFloat($("#unit").val()))) {
                getPrice();
            }
        }

        $(document).on("change", '#unit', function(){
            if (isNaN(parseFloat($("#unit").val()))) {
                alert('Unit Cost must be a price e.g 10.50');
                return;
            }

            changeAction();
        });

        $(document).on("change", '#qty', function(){
            if (isNaN(parseInt($("#qty").val()))) {
                alert('Quantity must be a whole number');
                return;
            }

            changeAction();
        });

    </script>
@endpush
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
                            <x-label for="product" :value="__('Product')"></x-label>
                            <select name="product_id" id="product">
                                <option value="1">Gold Coffee</option>
                                <option value="2">Aribic Coffee</option>
                            </select>
                        </div>
                        <div class="flex-col">
                            <x-label for="qty" :value="__('Quantity')"></x-label>
                            <input type="number" id="qty" class="block mt-1" name="quantity" required />
                        </div>
                        <div class="flex-col">
                            <x-label for="unit" :value="__('Unit Cost (£)')"></x-label>
                            <input type="text" id="unit" class="block mt-1"  name="unitCost" required/>
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

                <br/><br/>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Previous Sales') }}
                </h2>

                <table>
                    <thead>
                        <tr>
                            <td>Product</td>
                            <td>Quantity</td>
                            <td>Unit Cost</td>
                            <td>Selling Price</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach( $ledger as $row)
                        <tr>
                            <td>{{$row->name}}</td>
                            <td>{{$row->quantity}}</td>
                            <td>{{$row->unitCost}}</td>
                            <td>{{$row->salesPrice}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</x-app-layout>
