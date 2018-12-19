<?php
//dump($data);
?>
<div class="alert alert-<?php echo esc_attr( $data['atts']['style'] ); ?>" role="alert">
    <?php if (!empty($data['atts']['icon'])) { ?>
        <span class="<?php echo esc_attr($data['atts']['icon']); ?>"></span>
    <?php } ?>
	<?php echo wp_kses_post( $data['content'] ); ?>
</div>
