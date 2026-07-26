<?php

defined('ABSPATH') || exit;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="sticky-top header py-3">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <?php $logo = get_template_directory_uri() . '/assets/images/theme/starter-kit-logo.svg'; ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="d-inline-block mb-0">
                    <img
                        src="<?php echo esc_url($logo); ?>"
                        alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                    >
                </a>
            </div>
            <div class="col-auto d-flex align-items-center">
                <?php
                wp_nav_menu([
                    'theme_location' => 'header_menu',
                    'container'      => false,
                    'menu_class'     => 'navbar-nav',
                    'fallback_cb'    => false,
                ]);
                ?>
            </div>
        </div>
    </div>
</header>
