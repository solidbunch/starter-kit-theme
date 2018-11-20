<?php 
 
if ( isset($data['align']) && $data['align'] <> '' ) {
	echo '<div style="text-align: ' . esc_attr( $data['align'] ) . ';">';
}
?>
<button type="submit" id="<?php echo esc_attr($data['el_id']); ?>" class="button form-builder-submit">
	<?php echo wp_kses_post( $data['submit_button_text'] ); ?>
	<i class="fa fa-angle-right"></i>
</button>
<?php
if ( isset($data['align']) && $data['align'] <> '' ) {
	echo '</div>';
}
?>
