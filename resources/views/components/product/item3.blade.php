<div class="product-item three-column">
    <div class="item-card">

        <div class="row no-gutters">
            <div class="col-4">
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
            </div>
            <div class="col-8">


                <div class="product-item-body pl-2 layout__box o__has-rows" style="height: 127px;padding-bottom:2px">
                    <div class=" layout__box">
                        <a title="{{ $data->name }}" href="/store/tours/{{ $data->id }}"><span class="product-item-code">{{ $data->code }}</span></a>

                        <h3 class="product-item-title y-ellipsis clamp-2" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><a title="{{ $data->name }}" href="/store/tours/{{ $data->id }}" style="overflow: hidden; overflow-wrap: break-word;"><span>{{ $data->name }}</span></a></h3>
                    </div>

                    <div class="layout__box o__flexes-to-1">
                        <table class="product-item-table product-detail-meta"><tbody>
                            <?php

                            if( !empty($data->period_start) ){
                                $periodStart = explode(',', $data->period_start);
                                $periodEnd = explode(',', $data->period_start);
                                $periodPrice = explode(',', $data->period_price);

                                foreach ($periodStart as $key => $value) {

                                    echo '<tr>
                                        <td class="td-index">'.($key+1).'.</td>
                                        <td class="td-date">'.Fn::periodDate( $periodStart[$key], $periodEnd[$key] ).'</td>
                                        <td class="td-price">'.number_format($periodPrice[$key]).'</td>
                                    </tr>';

                                    if( $key==1 ) break;
                                }
                            }

                            ?>
                        </tbody></table>

                    </div>

                    <div class="product-item-sub layout__box"><span style="font-size: 10px;font-weight: bold;"><a href="/store/wholesale/{{ $data->wholesale_id }}">{{ $data->wholesale_name }}</a></span></div>
                </div>
            </div>


        </div>

        {{-- <div class="d-flex justify-content-end p-1">
            <div></div>
            <div class="product-item-actions ml-2">
                <button class="btn btn-primary btn-block btn-sm"><span class="d-flex justify-content-center align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg><span class="ml-1">เพิ่มลงในตะกร้า</span></span></button>
            </div>
        </div> --}}

    </div>
</div>
