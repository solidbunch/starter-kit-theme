<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>

<figure class="<?php echo $data['className'] ?? ''; ?>">
    <?php echo $data['imgHtml'] ?? ''; ?>
</figure>
