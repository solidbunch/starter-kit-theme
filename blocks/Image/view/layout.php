<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>

<figure<?php echo !empty($data['blockClass']) ? ' class="' . $data['blockClass'] . '"' : ''; ?>>
    <?php echo $data['imgHtml'] ?? ''; ?>
</figure>
