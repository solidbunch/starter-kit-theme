<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>



<section class="section_doc d-flex flex-wrap align-items-start py-5">
    <aside class="sidebar col-12 py-3">
        <button class="btn btn-primary navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDocs" aria-controls="offcanvasDocs" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas-lg offcanvas-start " tabindex="-1" id="offcanvasDocs" aria-labelledby="offcanvasDocsLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDocsLabel">Docs:</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#offcanvasDocs"></button>
            </div>
            <div class="offcanvas-body">
                <div class="offcanvas_content">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="py-3 px-lg-3">
                            <h5><?= $i ?>  title</h5>
                            <ul class="list-unstyled list_doc">
                                <li><a href="#"> Lorem, ipsum dolor sit amet dolor sit amet</a></li>
                                <li><a href="#"  class="active">  sit amet</a></li>
                                <li><a href="#"> Lorem, ipsum</a></li>
                            </ul>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </aside>
    <article class="col">
        <div class="container">
        <?php for ($i = 0; $i < 100; $i++): ?>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis libero illo fuga labore architecto eveniet, nam officia similique error perferendis enim, vitae, iure saepe. Quaerat odio ipsum saepe. Magni, rerum!</p>
        <?php endfor; ?>
        </div>
    </article>
</section>

