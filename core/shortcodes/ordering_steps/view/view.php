<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 10.11.2017
 * Time: 13:07
 */

    $number = $atts['number'];
    $image_url = wp_get_attachment_image_url( $atts['image'], array(32,32) );
    $title_text =  $atts['title'];
    $description = $atts['text'];
    $btn = vc_build_link($atts['call_to_action_btn']);
    $is_visible_dots = !$atts['is_hidden_dots'];
?>

<div class="ordering-step_wrapper">
    <div class="step-number_wrapper">
        <?php if($is_visible_dots): ?>
            <div class="dots">
                <i class="fa fa-circle" aria-hidden="true"></i>
                <i class="fa fa-circle" aria-hidden="true"></i>
                <i class="fa fa-circle" aria-hidden="true"></i>
                <i class="fa fa-circle" aria-hidden="true"></i>
                <i class="fa fa-circle" aria-hidden="true"></i>
                <i class="fa fa-circle" aria-hidden="true"></i>
            </div>
        <?php endif; ?>
		<?php echo $number;?>
    </div>
    <div class="title_wrapper">
        <img src="<?=$image_url;?>" alt="" class="title-icon">
        <h3 class="step-title"><?=$title_text;?></h3>
    </div>
    <div class="description"><?=$description;?></div>
    <div class="link_wrapper">
        <a class="button btn-arrowed" href="<?=$btn['url'];?>" target="<?=$btn['target'];?>" rel="<?=$btn['rel'];?>"><?=$btn['title'];?></a>
    </div>
</div>
