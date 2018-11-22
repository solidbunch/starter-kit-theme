<?php
    $type = ( $data["atts"]["position"] == 'vertical' ) ? 'vertical ' : 'default ';
    $class = $data['atts']['classes'].' type-'.$type.' style-'.$type;
?>

<div class="<?php echo esc_attr($class); ?>" data-type="<?php echo $type; ?>">

	<?php
	    echo do_shortcode( $data['content'] );
    ?>

</div>