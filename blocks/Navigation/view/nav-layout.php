<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>

<nav class="navbar <?php
    echo $data['attributes']['expand'] ?? 'navbar-expand-lg';
    echo !empty($data['blockClass']) ? ' ' . $data['blockClass'] : '';
?>">
    <button
        class="navbar-toggler ms-auto"
        type="button"
        data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar-<?php echo $data['attributes']['menuId'] ?? ''; ?>"
        aria-controls="offcanvasNavbar-<?php echo $data['attributes']['menuId'] ?? ''; ?>"
        aria-label="<?php esc_attr_e('Toggle navigation', 'starter-kit'); ?>"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end"
         tabIndex="-1" id="offcanvasNavbar-<?php echo $data['attributes']['menuId'] ?? ''; ?>"
    >
        <div class="offcanvas-header">
            <button
                type="button"
                class="btn-close ms-auto"
                data-bs-dismiss="offcanvas"
                aria-label="<?php esc_attr_e('Close', 'starter-kit'); ?>"
            >
            </button>
        </div>
        <div class="offcanvas-body">
            <?php echo $data['menuTemplate'] ?? ''; ?>
        </div>
    </div>
</nav>
