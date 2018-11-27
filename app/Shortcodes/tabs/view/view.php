<?php
    $type = ( $data["atts"]["position"] == 'vertical' ) ? 'vertical ' : 'default ';
    $classes = $data['atts']['classes'].' type-'.$type.' style-'.$type;
?>

<div class="<?php echo esc_attr($classes); ?>" data-type="<?php echo $type; ?>">

	<?php
	    echo do_shortcode( $data['content'] );
    ?>

</div>