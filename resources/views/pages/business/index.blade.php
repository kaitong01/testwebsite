@extends('layouts.admin')

@section('title', 'ตั้งค่าเว็บไซต์ของคุณ')

@section('content')

    @component('components.columns', [
        'navleft'=> ''
    ])

        @slot('nav')
            @component('components.navleft', [
                'title' => 'ตั้งค่าเว็บไซต์ของคุณ',

                'current' => isset( $page_current_tab ) ? $page_current_tab: '',

                "items" => [

                    [
                        "name" => "การตั้งค่า",
                        "items" => [
                            // ["id"=> "/business/overview", "name" => "ภาพรวม"],
                            ["id"=> "/business/settings", "name" => "ข้อมูล"],
                            // ["id"=> "/business/plans", "name" => "Premium Plan"],
                            // ["id"=> "/business/domains", "name" => "โดเมน"],
                            // ["id"=> "/business/mailboxes", "name" => "อีเมลธุรกิจ"],
                            // ["id"=> "/business/payments", "name" => "การชำระเงิน"],
                            ["id"=> "/business/seo", "name" => "SEO"],
                            // ["id"=> "/business/social", "name" => "โซเชียล"],
                            // ["id"=> "/business/notifications", "name" => "การแจ้งเตือน"],
                            // ["id"=> "/business/authorization", "name" => "ผู้ใช้"],
                        ]
                    ],
                    [
                        "name" => "การตั้งค่าขั้นสูง",
                        "items" => [
                            ["id"=> "/business/embeds", "name" => "การติดตาม"], //วิเคราะห์
                            // ["id"=> "/business/inbox/settings", "name" => "ตั้งค่ากล่องจดหมาย"],
                            // ["id"=> "/business/invoices/settings", "name" => "ใบเสนอราคา & ใบเรียกชำระเงิน"],
                        ]
                    ],
                ],
            ])

            @endcomponent

        @endslot




        <?php if( !empty( $page_current_tab ) ) { ?>

            <?php if( $page_current_tab=='/business/settings' ){ ?>
                @include('pages.business.settings.index')
            <?php } elseif( $page_current_tab=='/business/embeds' ){?>
                @include('pages.business.embeds.index')
            <?php } elseif( $page_current_tab=='/business/seo' ){?>
                @include('pages.business.seo.index')
            <?php } ?>

        <?php } ?>

    @endcomponent

@endsection
