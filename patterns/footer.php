<?php

/**
 * Title: Footer
 * Slug: starter-kit/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Footer with logo and links.
 */

?>

<!-- wp:starter-kit/section {"modification":{"backgroundColor":"","textColor":"",
"tagName":"footer","colorTheme":"dark"},"className":"footer"} -->
<footer data-bs-theme="dark" class="footer">
    <!-- wp:starter-kit/container {"spacers":{"xs":{"valueRange":{"pt-xs":3,"pb-xs":3}},"sm":[],"md":[],"lg":[],"xl":[],
    "xxl":[]}} -->
    <div class="container pt-3 pb-3">
        <!-- wp:starter-kit/row {"properties":{"xs":{"alignItems":"center"},"sm":[],"md":[],"lg":[],"xl":[],
        "xxl":[]}} -->
        <div class="row align-items-center">
            <!-- wp:starter-kit/column {"size":{"xs":{"mod":"custom","valueRange":12},"sm":[],"md":[],
            "lg":{"mod":"auto"},"xl":[],"xxl":{"mod":""}},"className":"text-center"} -->
            <div class="col-12 col-lg-auto text-center">
                <!-- wp:starter-kit/image {"link":{"addLink":true,"targetBlank":false,"href":"/"},"hidpi":false,
                "altText":"StarterKit logo white",
                "mainImage":{"id":"","url":"<?php
                   echo
                   esc_url(get_template_directory_uri() . '/assets/images/theme/starter-kit-logo-white.svg'); ?>",
                "startWidth":184,"ratio":3.607843137254902},"srcSet":{"sm":{"viewPort":576,"enabled":false},
                "md":{"viewPort":768,"enabled":false},"lg":{"viewPort":992,"enabled":false},
                "xl":{"viewPort":1200,"enabled":false},"xxl":{"viewPort":1400,"enabled":false}},"className":"mb-0"} /-->
            </div>
            <!-- /wp:starter-kit/column -->

            <!-- wp:starter-kit/column {"size":{"xs":{"mod":"custom","valueRange":12},"sm":{"mod":"","valueRange":12},
            "md":[],"lg":{"mod":"default"},"xl":[],"xxl":[]},"className":"d-flex justify-content-center flex-wrap"} -->
            <div class="col-12 col-lg d-flex justify-content-center flex-wrap">
                <!-- wp:starter-kit/navigation {"menuLocation":"bottom_menu"} /-->
            </div>
            <!-- /wp:starter-kit/column -->

            <!-- wp:starter-kit/column {"size":{"xs":{"mod":"custom","valueRange":12},"sm":[],"md":[],
            "lg":{"mod":"auto"},"xl":[],"xxl":[]},
            "className":"d-flex align-items-center  justify-content-center  flex-wrap"} -->
            <div class="col-12 col-lg-auto d-flex align-items-center justify-content-center flex-wrap">
                <!-- wp:starter-kit/paragraph {"className":"mb-0"} -->
                <p class="mb-0"><a href="mailto:contact@starter-kit.io">contact@starter-kit.io</a></p>
                <!-- /wp:starter-kit/paragraph -->

                <!-- wp:starter-kit/image {"link":{"addLink":true,"targetBlank":true,
                "href":"https://github.com/solidbunch/starter-kit-foundation"},
                "hidpi":false,"altText":"SolidBunch Github link",
                "mainImage":{"id":"","url":"<?php
                   echo esc_url(get_template_directory_uri() . '/assets/images/theme/GitHub-white.svg'); ?>",
                "startWidth":32,"ratio":1},"srcSet":{"sm":{"viewPort":576,"enabled":false},
                "md":{"viewPort":768,"enabled":false},"lg":{"viewPort":992,"enabled":false},
                "xl":{"viewPort":1200,"enabled":false},"xxl":{"viewPort":1400,"enabled":false}},
                "className":"ms-3 mb-0"} /-->

                <!-- wp:starter-kit/image {"link":{"addLink":true,"targetBlank":true,"href":"https://www.linkedin.com"},
                "hidpi":false,"altText":"SolidBunch Linkedin",
                "mainImage":{"id":"","url":"<?php
                   echo esc_url(get_template_directory_uri() . '/assets/images/theme/Linkedin-white.svg'); ?>",
                "startWidth":27,"ratio":0.8181818181818182},"srcSet":{"sm":{"viewPort":576,"enabled":false},
                "md":{"viewPort":768,"enabled":false},"lg":{"viewPort":992,"enabled":false},
                "xl":{"viewPort":1200,"enabled":false},"xxl":{"viewPort":1400,"enabled":false}},
                "className":"ms-3 mb-0"} /-->
            </div>
            <!-- /wp:starter-kit/column -->
        </div>
        <!-- /wp:starter-kit/row -->
    </div>
    <!-- /wp:starter-kit/container -->
</footer>
<!-- /wp:starter-kit/section -->
