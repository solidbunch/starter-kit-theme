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
    <?php if (!empty($data['link']['addLink']) && !empty($data['link']['href'])) { ?>
        <a href="<?php echo $data['link']['href']; ?>"<?php echo !empty($data['link']['targetBlank']) ? ' target="_blank"' : ''; ?>>
            <?php echo $data['imgHtml'] ?? ''; ?>
        </a>
    <?php } else { ?>
        <?php echo $data['imgHtml'] ?? ''; ?>
    <?php } ?>
</figure>


