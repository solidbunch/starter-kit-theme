<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="main-wrapper">

	<?php
		do_action( 'StarterKit/before_header');
		do_action( 'StarterKit/header');
		do_action( 'StarterKit/after_header');
	?>
