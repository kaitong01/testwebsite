<div class="products-grid">

    @isset($items)


        @foreach ($items as $item)

            @component('components.product.item' .( isset($itemStyle)? $itemStyle: '' ) , ['data' => $item]) @endcomponent

        @endforeach

    @endisset

</div>
