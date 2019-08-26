<div class="product-item">
    <div class="item-card">
        <a href="/store/tours/{{ $data->id }}" class="product-item-pic pic">
            @if ( !empty( $data->gallery ) )
            <?php
                $img = '';
                $gallery = json_decode( $data->gallery, 1);

                if( !empty($gallery[0]['path']) ){
                    $img = asset("storage/{$gallery[0]['path']}");
                }
                else if( !empty( $gallery[0]['url'] ) ) {
                    $img = $gallery[0]['url'];
                }

                if( !empty( $img ) ){
                    echo '<img src="'.$img.'" alt="">';
                }
            ?>

            @endif
        </a>
        <div class="product-item-body">
            <a href="/store/tours/{{ $data->id }}"><span class="product-item-code">{{ $data->code }}</span></a>
            <h3 class="product-item-title"><a title="{{ $data->name }}" class="" href="/store/tours/{{ $data->id }}" style="overflow: hidden; overflow-wrap: break-word;">{{ $data->name }}</a></h3>

            <div class="d-flex justify-content-between align-items-center">
                    <div class="product-item-price">{{number_format( $data->price_at )}}</div>
                    <div class="product-item-days">{{ $data->plan_days }}</div>
            </div>

            <span class="product-item-sub"><span><a href="/store/wholesale/{{ $data->wholesale_id }}">{{ $data->wholesale_name }}</a></span></span>

            <div class="product-item-actions">
                {{-- @component('components.product.actions.', ['data'=>$data]) @endcomponent --}}
                <button class="btn btn-primary btn-block btn-sm"><span class="d-flex justify-content-center align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg><span class="ml-1">เพิ่มลงในตะกร้า</span></span></button>
            </div>
        </div>
    </div>
</div>
