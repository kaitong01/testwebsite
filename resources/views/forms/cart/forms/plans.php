<?php

$seriesPlansForm = '<div data-plugin="seriesPlansForm" data-options="'.htmlentities(json_encode(array(
    'data'=> !empty($series->plans)? json_decode($series->plans, 1): []
))).'"><ul class="travel-plan" role="listsbox"></ul></div>';
