<?php


$navs = array();


$items = array();
// $items[] = array('id'=>'/', 'name'=>'หน้าแรก', 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24"><path d="M9 5v6H5V5h4m10 8v6h-4v-6h4m2-10h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"></path></svg>');
$items[] = array('id'=>'/booking', 'name'=>'การจอง', 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"></path><path d="M14.5 13a2.5 2.5 0 0 0 0 5 2.5 2.5 0 0 0 0-5z"></path></svg>');
$items[] = array('id'=>'/products', 'name'=>'แพ็คเกจทัวร์', 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24"><path d="M3 3v18h18V3H3zm3 3h12v6H6V6zm12 12H6v-1h12v1zm0-2H6v-1h12v1z"></path></svg>');
// $items[] = array('id'=>'/customers', 'name'=>'ลูกค้า', 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24"><path d="m12 4.4h12v16.6h-24v-0.9c-0.1-2.6 1.3-5 3.6-6.1 0.2-0.1 0.4-0.2 0.6-0.4 0-0.1-0.1-0.2-0.1-0.2-0.7-0.8-1.1-1.8-1.1-2.9 0-2.3 1.8-4.2 4.1-4.2h0.8c2.1 0.5 3.5 2.5 3.3 4.6-0.1 0.9-0.5 1.8-1.1 2.5l-0.1 0.2 0.6 0.3c2 1 3.3 3 3.3 5.2h8.3v-12.9h-10.2v-1.8zm-10.2 14.8h10.2c0.1-1.6-0.9-3-2.3-3.6-0.7-0.5-1.5-0.9-1.5-1.8 0-0.5 0.2-0.9 0.6-1.3 0.4-0.5 0.6-1 0.7-1.6 0.2-1.4-0.7-2.6-1.9-2.9h-0.5c-1.4 0-2.4 1.1-2.4 2.5 0 0.7 0.3 1.4 0.7 1.9 0.3 0.4 0.5 0.8 0.6 1.3 0 1-0.8 1.4-1.5 1.8-1 0.6-2.7 1.4-2.7 3.7zm20.4 0h-9.2l0.4 0.1v-0.1h8.8zm-7.4-10.2h1.8v2.8h-1.8v-2.8zm3.7 0h1.8v2.8h-1.8v-2.8zm-3.7 4.6h1.8v2.8h-1.8v-2.8zm3.7 0h1.8v2.8h-1.8v-2.8z"></path></svg>');
$navs[] = array('title'=>'', 'items'=>$items);


$items = array();
$items[] = array('id'=>'/store', 'name'=>'คลังแพคเกจทัวร์', 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24"><path d="m5 22c-1-0.2-1.8-1-2-2v-18h2v18l12.8 0.1c1.2 0 1.2 0.1 1.2-1.1v-14c0-0.9 0-1-1-1h-7l-4-1 5 0.2c0.2 1.7 0.7 3.3 1.5 4.8 0 0.1 0 0.2 0.1 0.3 0 0-0.2 0.6-0.6 0.6-0.1 0-0.8-0.9-1-1l-1.8-0.7-0.4 2.4c-0.1 0.2-0.3 0.4-0.6 0.4-0.2 0-0.4-0.1-0.5-0.3-1.1-2-1.7-4.3-1.7-6.7 0.1-0.5 0.5-0.9 1-1h10c1.5-0.2 2.8 0.9 3 2.4v0.6 13.9c0.1 1.6-1 2.9-2.6 3.1h-0.4-13zm2-4v-2h6v2h-6zm0-4v-2h10v2h-10z"/></svg>');
$items[] = array('id'=>'/cart', 'name'=>'นำเข้าข้อมูล', 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24"><path d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8z"></path><circle cx="12" cy="15" r="2"></circle></svg>');
$navs[] = array('title'=>'EXPLORE', 'items'=>$items);



$items = array();
$items[] = array('id'=>'/business', 'name'=>'ข้อมูลหน้าร้าน', 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24"><path d="M18.36 9l.6 3H5.04l.6-3h12.72M20 4H4v2h16V4zm0 3H4l-1 5v2h1v6h10v-6h4v6h2v-6h1v-2l-1-5zM6 18v-4h6v4H6z"></path></svg>');
$items[] = array('id'=>'/site', 'name'=>'เว็บไซต์', 'icon' => '<svg class="t6gojc" width="24" height="24" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM4 9h10.5v3.5H4V9zm0 5.5h10.5V18H4v-3.5zM20 18h-3.5V9H20v9z"></path></svg>');
$items[] = array('id'=>'/blogs', 'name'=>'บทความ', 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H4V4h16v12zm-9.5-2H18v-2h-5.5zm3.86-5.87c.2-.2.2-.51 0-.71l-1.77-1.77c-.2-.2-.51-.2-.71 0L6 11.53V14h2.47l5.89-5.87z"></path></svg>');
$navs[] = array('title'=>'SHOP ', 'items'=>$items);



$items = array();
// $items[] = array('id'=>'', 'name'=>'ข้อมูลหน้าร้าน', 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24"><path d="M3 3v18h18V3H3zm3 3h12v6H6V6zm12 12H6v-1h12v1zm0-2H6v-1h12v1z"></path></svg>');
$items[] = array('id'=>'/settings', 'name'=>'การตั้งค่า', 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24"><path d="M13.85 22.25h-3.7c-.74 0-1.36-.54-1.45-1.27l-.27-1.89c-.27-.14-.53-.29-.79-.46l-1.8.72c-.7.26-1.47-.03-1.81-.65L2.2 15.53c-.35-.66-.2-1.44.36-1.88l1.53-1.19c-.01-.15-.02-.3-.02-.46 0-.15.01-.31.02-.46l-1.52-1.19c-.59-.45-.74-1.26-.37-1.88l1.85-3.19c.34-.62 1.11-.9 1.79-.63l1.81.73c.26-.17.52-.32.78-.46l.27-1.91c.09-.7.71-1.25 1.44-1.25h3.7c.74 0 1.36.54 1.45 1.27l.27 1.89c.27.14.53.29.79.46l1.8-.72c.71-.26 1.48.03 1.82.65l1.84 3.18c.36.66.2 1.44-.36 1.88l-1.52 1.19c.01.15.02.3.02.46s-.01.31-.02.46l1.52 1.19c.56.45.72 1.23.37 1.86l-1.86 3.22c-.34.62-1.11.9-1.8.63l-1.8-.72c-.26.17-.52.32-.78.46l-.27 1.91c-.1.68-.72 1.22-1.46 1.22zm-3.23-2h2.76l.37-2.55.53-.22c.44-.18.88-.44 1.34-.78l.45-.34 2.38.96 1.38-2.4-2.03-1.58.07-.56c.03-.26.06-.51.06-.78s-.03-.53-.06-.78l-.07-.56 2.03-1.58-1.39-2.4-2.39.96-.45-.35c-.42-.32-.87-.58-1.33-.77l-.52-.22-.37-2.55h-2.76l-.37 2.55-.53.21c-.44.19-.88.44-1.34.79l-.45.33-2.38-.95-1.39 2.39 2.03 1.58-.07.56a7 7 0 0 0-.06.79c0 .26.02.53.06.78l.07.56-2.03 1.58 1.38 2.4 2.39-.96.45.35c.43.33.86.58 1.33.77l.53.22.38 2.55z"></path><circle cx="12" cy="12" r="3.5"></circle></svg>');
$navs[] = array('title'=>'Setting ', 'items'=>$items);


echo '<div class="account-group">
    <div class="d-flex align-items-center">
        <div class="avatar avatar-'.Auth::user()->user_avatar.'"></div>
        <div class="content">'.
            '<div class="title">'.Auth::user()->name.'</div>'.
            // <div class="subtitle">ผู้ดูแล</div>
        '</div>
    </div>
</div>';


foreach ($navs as $val) {


    echo '<ul class="navbar-nav navbar-sidenav page-navigation-sidenav">';
    if( !empty($val['title']) ){

        echo '<li class="nav-item head"><span>'.$val['title'].'</span></li>';
    }

    foreach ($val['items'] as $key => $value) {

        //
    ?>
    <li class="nav-item{{request()->is( trim($value['id'],'/'), trim($value['id'],'/').'/*' )? ' active':''}}">
        <a class="nav-link" href="<?=$value['id']?>">
            <span class="nav-link-icon"><?=$value['icon']?></span>
            <span class="nav-link-text"><?=$value['name']?></span>
        </a>
    </li>
    <?php }


    echo '</ul>';
} ?>
