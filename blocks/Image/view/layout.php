<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>

<figure
    <?php if (!empty($data['className'])) { ?>
        class="<?php echo $data['className']; ?>"
    <?php } ?>
    >
    <?php echo $data['imgHtml'] ?? ''; ?>
</figure>
