<?php

/**
 * @array $data shortcode output data from controller
 **/

$atts     = $data['atts'];
$content  = isset( $data['content'] ) ? $data['content'] : '';
$iterator = count( $data['image_blocks'] );
?>
<div class="row">
    <section id="features2" class="padding5">
        <div class="row text-center">
            <h2><?php echo $atts['heading_text'] ?></h2>
            <p class="after-header">
				<?php echo $atts['subheading_text'] ?>
            </p>
            <br/><br/>
            <div>
			<?php for ( $i = 0; $i < $iterator; ++ $i ) : ?>
                <div class="col-xs-12 col-md-4 icon-wrapper <?php echo $i >= 3 ? 'top' : '' ?>">
                    <div class="hover panel">
                        <div class="front">
                            <div class="pad">
                                <div class="height-fix">
                                    <img alt="<?php echo $data['image_blocks'][ $i ]['alt'] ?>"
                                         src="<?php echo $data['image_blocks'][ $i ]['src'] ?>">
                                </div>
                                <h4><?php echo $data['image_blocks'][ $i ]['caption'] ?></h4>
                            </div>
                        </div>
                        <div class="back">
                            <div class="pad">
								<?php echo $data['image_blocks'][ $i ]['text'] ?>
                            </div>
                        </div>
                    </div>
                </div>
			<?php endfor; ?>
            </div>
            <br/><br/>
            <div class="clearfix"></div>
            <br/><br/>
            <a class="btn btn-orange free-trial" href="<?php echo $atts['button_target']?>"
               data-toggle="modal" data-target="<?php echo $atts['button_target']?>">
                <?php echo $atts['button_text'] ?>
            </a>
        </div>
    </section>
</div>