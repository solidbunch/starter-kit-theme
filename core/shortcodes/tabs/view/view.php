<?php $type = ( $data["atts"]["position"] == 'vertical' ) ? 'vertical ' : 'default '; ?>

<div class="fruitful_tabs type-<?php echo $type; ?> style-<?php echo $type; ?>" data-type="<?php echo $type; ?>">

	<?php echo wpb_js_remove_wpautop( $data['content'] ); ?>

</div>
