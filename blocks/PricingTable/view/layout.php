<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

// pt-4 pb-4 pt-sm-5 pb-sm-5
?>
<div class="container pricing_section<?php echo !empty($data['blockClass']) ? ' ' . $data['blockClass'] : ''; ?>">
    <div class="row justify-content-center">
        <?php foreach ($data['pricingPackages'] as $postID => $pricingPackage) { ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
                <div class="card h-100 border-2 bg-white border-<?php echo $pricingPackage['border_color']; ?>">
                    <div class="card-body d-flex flex-column px-3 px-md-4">
                        <div class="content col pb-4">
                            <h3 class="text-center"><?php echo $pricingPackage['title'] ?? ''; ?></h3>
                            <?php if (!empty($pricingPackage['features'])) { ?>
                            <ul class="list-unstyled mb-4 list_marked fw-medium">
                                <?php foreach ($pricingPackage['features'] as $feature) { ?>
                                    <li><?php echo $feature['text'] ?? ''; ?></li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                            <?php echo $pricingPackage['content'] ?? ''; ?>
                        </div>
                        <div class="footer col-auto">
                            <h5 class="text-center mb-4"><?php echo $pricingPackage['price'] ?? ''; ?></h5>
                            <?php
                            // Create checkout URL with package info
                            $packageSlug = sanitize_title($pricingPackage['title']);
                            $price = $pricingPackage['price'];
                            $checkoutUrl = add_query_arg([
                                'package' => $packageSlug,
                                'price' => $price
                            ], home_url('/checkout'));
                            ?>
                            <a
                                href="<?php echo esc_url($checkoutUrl); ?>"
                                class="w-100 py-3 btn btn-<?php
                                echo $pricingPackage['button_style'] ? $pricingPackage['button_style'] . '-' : '';
                                echo $pricingPackage['button_color'] ?? 'primary'; ?>"
                            >
                                <?php echo $pricingPackage['button_text'] ?? 'Choose Plan'; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

