<?php

$form = new Form();
$formSEO = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')

    ->field("seo_title")
        ->label('ใส่ชื่อเพจที่จะให้แสดงในผลการค้นหาหรือบนแท็บบราวเซอร์ (70 ตัวอักษร)')
        ->addClass('form-control input-seo input-title-seo')
        ->autocomplete("off")
        ->maxlength( 70 )
        ->value( !empty($data->seo_title) ? $data->seo_title:'' )


    ->field("seo_description")

        ->label('เพจนี้เกี่ยวกับอะไร เพิ่มคำบรรยายเพจ (320 ตัวอักษร)')
        ->addClass('form-control input-seo input-content-seo')
        ->autocomplete("off")
        ->type('textarea')
        ->maxlength( 320 )
        ->attr('data-plugins', 'autosize')
        ->value( !empty($data->seo_description) ? $data->seo_description:'' )


    ->field("permalink")
        ->label('ใส่ URL เพจของคุณ')

        ->text(

            '<div class="seourl-wrap d-flex justify-content-between align-items-center">'.
                '<div class="seourl-base">/tours/</div>'.
                '<div class="seourl-input">'.
                    '<input id="permalink" class="form-control input-seo input-url-seo" autocomplete="off" type="text" name="permalink" value="'.(!empty($data->permalink)? $data->permalink:'').'" />'.
                '</div>'.
            '</div>'
        )

    ->hr( '<div class="control-google-preview d-none" ref="preview">'.

        '<div class="header">ดูตัวอย่างบน Google</div>'.
        '<div class="preview">'.

            '<div class="preview-content">'.
                '<div class="title"></div>'.
                '<div class="url"></div>'.
                '<div class="description"></div>'.
            '</div>'.
        '</div>'.

    '</div>' )
->html();
