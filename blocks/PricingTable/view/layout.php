<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>
<div class="container">
    <div class="row">
        <?php for ($i = 0; $i < 5; $i++): ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
                <div class="card h-100 border-success border-2 bg-white">
                    <div class="card-body d-flex flex-column px-3 px-md-4">
                        <div class="content col pb-4">
                            <h3 class="text-center">Foundation Free</h3>
                            <ul class="list-unstyled mb-4 list_marked fw-medium">
                                <li>Contemporary file structure</li>
                                <li>Contemporary file structure</li>
                                <li>file structure</li>
                                <li>Contemporary</li>
                            </ul>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Excepturi laboriosam quibusdam dolores, porro nihil quae odio magni aut nobis, rem ab debitis. Minima commodi magnam omnis id, incidunt fuga quos!</p>
                        </div>
                        <div class="footer col-auto">
                            <h5 class="text-center mb-4">$1050</h5>
                            <button class="btn btn-outline-success w-100 py-3">Download</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>
