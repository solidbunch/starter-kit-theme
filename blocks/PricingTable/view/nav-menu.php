<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>

<ul class="navbar-nav">
    <?php foreach ($data['menuTree'] as $item) { ?>
        <li class="nav-item<?php echo $item->children ? ' dropdown' : ''; ?>">
            <?php if ($item->children) { ?>
                <a
                    class="<?php echo implode(' ', $item->classes); ?>"
                    <?php echo !empty($item->current) ? ' aria-current="page"' : ''; ?>
                    href="<?php echo esc_url($item->url); ?>"
                    <?php echo $item->attr_title ? 'title="' . esc_attr($item->attr_title) . '"' : ''; ?>
                    role="button" data-bs-toggle="dropdown" aria-expanded="false"
                >
                    <?php esc_html_e($item->title); ?>
                </a>
                <ul class="dropdown-menu">
                    <?php foreach ($item->children as $child) { ?>
                        <li>
                            <a
                                class="<?php echo implode(' ', $child->classes); ?>"
                                <?php echo !empty($child->current) ? ' aria-current="page"' : ''; ?>
                                href="<?php echo esc_url($child->url); ?>"
                                <?php echo $child->attr_title ? 'title="' . esc_attr($child->attr_title) . '"' : ''; ?>
                            >
                                <?php esc_html_e($child->title); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <a
                    class="<?php echo implode(' ', $item->classes); ?>"
                    <?php echo !empty($item->current) ? ' aria-current="page"' : ''; ?>
                    href="<?php echo esc_url($item->url); ?>"
                    <?php echo $item->attr_title ? 'title="' . esc_attr($item->attr_title) . '"' : ''; ?>
                >
                    <?php esc_html_e($item->title); ?>
                </a>
            <?php } ?>
        </li>
    <?php } ?>
</ul>
