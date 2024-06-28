<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>
<ul class="list-unstyled list_doc">
    <?php foreach ($data['docPages'][$data['parentPageId']] as $docPageId => $docPage) { ?>
        <li>
            <a href="<?php echo $docPage['link'] ?? ''; ?>"><?php echo $docPage['title'] ?? ''; ?></a>
            <?php if (!empty($data['docPages'][$docPageId])) {
                $this->loadBlockView(
                    'child-nav',
                    [
                        'docPages' => $data['docPages'],
                        'parentPageId' => $docPageId,
                    ],
                    null,
                    true
                );
            } ?>
        </li>
    <?php } ?>
</ul>

