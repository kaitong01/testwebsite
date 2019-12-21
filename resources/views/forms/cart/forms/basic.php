<?php



$form = new Form();
$formBasic = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert form-series')

    ->field("country_id")
    ->label( 'ประเทศ*' )
    ->autocomplete('off')
    ->addClass('form-control disabled')
    ->attr('disabled', '1')
    ->select( $countryList ?? [] )
    // ->attr('data-plugin', 'SelectCountry')
    ->value( $series->country_id?? '' )

// ->field("route_id")
//     ->label( 'เส้นทาง' )
//     ->autocomplete('off')
//     ->addClass('form-control')
//     ->select( [] )

->field("airline_id")
    ->label( 'สายการบิน' )
    ->autocomplete('off')
    ->addClass('form-control disabled')
    ->attr('disabled', '1')
    ->select( $airlineList ?? [] )
    ->value( $series->airline_id ?? '' )


->hr( '<div class="form-hr white"><span>ทัวร์</span></div>' )


->field("code")
    ->label( 'โค้ด' )
    ->autocomplete('off')
    ->addClass('form-control')
    ->value( $series->code ?? '' )


->field("name")
    ->label( 'ชื่อ*' )
    ->autocomplete('off')
    ->addClass('form-control input-title')
    ->value( $series->name ?? '' )

->field("days")
    ->label( 'จำนวนวัน*' )
    ->autocomplete('off')
    ->addClass('form-control')
    ->attr('data-plugin', 'input__number')
    ->maxlength(2)
    ->value( $series->days ?? '' )


->field("nights")
    ->label( 'จำนวนคืน*' )
    ->autocomplete('off')
    ->addClass('form-control')
    ->attr('data-plugin', 'input__number')
    ->maxlength(2)
    ->value( $series->nights ?? '' )


->field("price_at")
    ->label( 'ราคาเริ่มต้น*' )
    ->autocomplete('off')
    ->addClass('form-control')
    ->attr('data-plugin', 'input__number')
    ->value( $series->price_at ?? '' )



->field("description")
    ->type( 'textarea' )
    ->label( 'ไฮไลท์*' )
    ->autocomplete('off')
    ->addClass('form-control input-content')
    ->attr('data-plugin', 'autosize')
    ->value( $series->highlight ?? '' )

->html();
