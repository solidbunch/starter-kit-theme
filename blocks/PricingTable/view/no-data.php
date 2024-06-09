<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>
<nav class="navbar no-data">
    <?php echo $data['message'] ?? ''; ?>
</nav>
