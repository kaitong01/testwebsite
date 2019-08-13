<?php


$nav = array();


$items = array();
$items[] = array('id'=>'/settings/tours/country', 'name'=>'ประเทศ', 'count'=>0);
$items[] = array('id'=>'/settings/tours/route', 'name'=>'เส้นทาง', 'count'=>0);
$items[] = array('id'=>'/settings/tours/wholesale', 'name'=>'โฮลเซลล์', 'count'=>0);
$items[] = array('id'=>'/settings/tours/category', 'name'=>'ประเภททัวร์', 'count'=>0);
$nav[] = array('title'=>'ทัวร์', 'items'=>$items);


$items = array();
$items[] = array('id'=>'/settings/blogs/category', 'name'=>'ประเภทบทความ', 'count'=>0);
$nav[] = array('title'=>'บทความ', 'items'=>$items);

$currTab = !empty($slot) ? $slot:'';


?><div class="layout__box o__has-columns">

	<div class="navleft layout__box o__has-rows">

		<div class="navleft-header pt-3 px-3 mb-2 layout__box"><h1 class="navleft-header-title">การตั้งค่า</h1></div>


		<div class="navleft-body"><?php

			foreach ($nav as $val) {

				echo '<ul class="navleft-nav">';

				if( isset($val['title']) ){
					echo '<li class="navleft-item head"><span>'.$val['title'].'</span></li>';
				}
				
				foreach ($val['items'] as $key => $value) {


					$active = $currTab == $value['id']? ' active':'';

					echo '<li class="navleft-item'.$active.'">'.

						'<a href="'.$value['id'].'" class="navleft-link navleft-title">'.
							'<span class="navleft-text">'.$value['name'].'</span>'.
							'<span class="navleft-count">'.$value['count'].'</span>'.
						'</a>'.
					'</li>';
					
				}

				echo '</ul>';
			}	

			

		?></div>

	</div>

</div>