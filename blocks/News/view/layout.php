<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>

<div class="news-block">
    <?php echo $data['newsData'] ?? ''; ?>
    <div><?php echo $data['newsCategory'] ?? ''; ?></div>
</div>
