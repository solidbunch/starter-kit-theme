<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>
<div class="container">
    <p class="no-data">
        <?php echo $data['message'] ?? ''; ?>
    </p>
</div>
