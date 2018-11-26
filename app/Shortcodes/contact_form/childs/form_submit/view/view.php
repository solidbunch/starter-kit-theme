<?php 
 
if ( !empty($data['atts']['align']) ) {
	echo '<div style="text-align: ' . esc_attr( $data['atts']['align'] ) . ';">';
}
?>
<button type="submit" id="<?php echo esc_attr($data['atts']['el_id']); ?>" class="button form-builder-submit">
	<?php echo wp_kses_post( $data['atts']['submit_button_text'] ); ?>
	<i class="fa fa-angle-right"></i>
</button>
<?php
if ( !empty($data['align']) ) {
	echo '</div>';
}
?>
