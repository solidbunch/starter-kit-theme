<?php

$cfg = array();

$cfg['sidebar_positions'] = array(
	'right' => array(
		'icon_url' => 'right.png',
		'sidebars_number' => 1
	),
	'full' => array(
		'icon_url' => 'full.png',
		'sidebars_number' => 0
	),
);

$cfg['dynamic_sidebar_args'] = array(
	'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
	'after_widget'  => '<div class="clearfix"></div></div></div>',
	'before_title'  => '<h4 class="widget-title">',
	'after_title'   => '</h4>',
);

$cfg['show_in_post_types'] = false;