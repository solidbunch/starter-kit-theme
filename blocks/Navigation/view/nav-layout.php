<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>

<nav>
    <?php foreach ($data['menuItems'] as $menuItem) { ?>
        <a href="<?php echo esc_url($menuItem->url); ?>">
            <?php echo esc_html($menuItem->title); ?>
        </a>
    <?php }; ?>
</nav>
