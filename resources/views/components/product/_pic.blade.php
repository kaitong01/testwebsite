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
