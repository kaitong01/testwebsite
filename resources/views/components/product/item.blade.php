<?php
use App\Http\Controllers\StoreController;
 ?>
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
            <?php
            $url = route('addtocart.store');
            ?>
            <div class="product-item-actions" data-plugin="choose_product" data-options="{{ json_encode([
                'id' => $data->id,
                 'url' => $url,
            ]) }}">
                {{-- @component('components.product.actions.', ['data'=>$data]) @endcomponent --}}
                <?php
                  $carts = StoreController::check_carts($data->id);
                ?>
                @if($carts==0||$carts=='')
                <button class="cart-btn btn btn-primary btn-block btn-sm"><span class="span-cart d-flex justify-content-center align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg><span class="ml-1">เพิ่มลงในตะกร้า</span></span></button>
                @elseif($carts==1)
                <button class="cart-btn btn btn-info btn-block btn-sm"><span class="span-cart d-flex justify-content-center align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg> <span class="ml-1">เพิ่มแล้ว</span></span></button>
                @else
                <button class="cart-btn btn btn-success btn-block btn-sm"><span class="span-cart d-flex justify-content-center align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg> <span class="ml-1">เผยแพร่แล้ว</span></span></button>
                @endif
            </div>
        </div>
    </div>
</div>
