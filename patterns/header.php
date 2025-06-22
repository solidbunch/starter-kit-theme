<?php

/**
 * Title: Header
 * Slug: starter-kit/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Header with site logo and navigation.
 */

?>

<!-- wp:starter-kit/section {"modification":{"backgroundColor":"","textColor":"","tagName":"header",
   "colorTheme":"light"},"className":"sticky-top header","spacers":{"xs":{"valueRange":{"pt-xs":0,"pb-xs":0}},"sm":[],
   "md":[],"lg":{"valueRange":{"pt-lg":3,"pb-lg":3}},"xl":[],"xxl":[]}} -->
<header data-bs-theme="light" class="sticky-top header pt-0 pb-0 pt-lg-3 pb-lg-3">
    <!-- wp:starter-kit/container -->
    <div class="container">
        <!-- wp:starter-kit/row {"properties":{"xs":{"justifyContent":"between",
             "alignItems":"center"},"sm":[],"md":[],"lg":[],"xl":[],"xxl":[]}} -->
        <div class="row justify-content-between align-items-center">
            <!-- wp:starter-kit/column {"size":{"xs":{"mod":"auto"},"sm":[],"md":[],"lg":[],"xl":[],"xxl":[]}} -->
            <div class="col-auto">
                <!-- wp:starter-kit/image {"link":{"addLink":true,"targetBlank":false,"href":"/"},
                     "fetchPriority":"high","loadingLazy":false,"hidpi":false,"altText":"StarterKit logo",
                     "mainImage":{"id":"","url":"<?php
                        echo
                        esc_url(get_template_directory_uri() . '/assets/images/theme/starter-kit-logo.svg'); ?>",
                     "startWidth":300,"ratio":3.658536585365854,"width":235},
                     "srcSet":{"sm":{"viewPort":576,"enabled":false},
                     "md":{"viewPort":768,"enabled":false},"lg":{"viewPort":992,"enabled":false},
                     "xl":{"viewPort":1200,"enabled":false},"xxl":{"viewPort":1400,"enabled":false}},
                     "className":"mb-0"} /-->
            </div>
            <!-- /wp:starter-kit/column -->

            <!-- wp:starter-kit/column {"size":{"xs":{"mod":"auto"},"sm":[],"md":[],"lg":[],"xl":[],"xxl":[]},
                 "className":"d-flex align-items-center"} -->
            <div class="col-auto d-flex align-items-center">
                <!-- wp:starter-kit/navigation {"menuLocation":"header_menu","expand":"navbar-expand-lg"} /-->
                <!-- wp:starter-kit/button {"modification":{"buttonText":"Get Started","tagName":"button",
                "defaultClass":"btn","buttonSize":"btn-sm"},
                "className":"order-first order-lg-last","spacers":{"xs":{"valueRange":{"me-xs":2,"ms-xs":2}},
                "sm":[],"md":[],"lg":{"valueRange":{"me-lg":0,"ms-lg":3}},"xl":[],"xxl":[]}} -->
                <button class="btn btn-primary btn-sm order-first order-lg-last me-2 ms-2 me-lg-0 ms-lg-3">
                    <?php
                    esc_html_e('Get Started', 'starter-kit'); ?>
                </button>
                <!-- /wp:starter-kit/button -->

                <!-- wp:starter-kit/image {"link":{"addLink":true,"targetBlank":true,
                     "href":"https://github.com/solidbunch/starter-kit-foundation"},"hidpi":false,
                     "mainImage":{"id":"", "url":"<?php
                        echo
                        esc_url(get_template_directory_uri() . '/assets/images/theme/GitHub.svg'); ?>",
                     "startWidth":32,"ratio":1},"srcSet":{"sm":{"viewPort":576,"enabled":false},
                     "md":{"viewPort":768,"enabled":false},"lg":{"viewPort":992,"enabled":false},
                     "xl":{"viewPort":1200,"enabled":false},"xxl":{"viewPort":1400,"enabled":false}},
                     "className":"d-none d-lg-inline-flex mb-0",
                     "spacers":{"xs":{"valueRange":{"ms-xs":4}},"sm":[],"md":[],"lg":[],"xl":[],"xxl":[]}} /-->
            </div>
            <!-- /wp:starter-kit/column -->
        </div>
        <!-- /wp:starter-kit/row -->
    </div>
    <!-- /wp:starter-kit/container -->
</header>
<!-- /wp:starter-kit/section -->
