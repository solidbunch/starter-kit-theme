<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>

<figure>
    <?php echo $data['imgHtml'] ?? ''; ?>
</figure>
