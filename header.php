<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<?php echo apply_filters('get_composer_layout', 'header'); ?>
