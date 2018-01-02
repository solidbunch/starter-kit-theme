<?php $atts = vc_map_get_attributes($this->getShortcode(), $atts); ?>
<?php
if (isset($atts['align']) && $atts['align'] <> '') {
	echo '<div style="text-align: ' . esc_attr($atts['align']) . ';">';
}
?>
<button type="submit" id="<?php echo esc_attr($atts['el_id']); ?>" class="button form-builder-submit">
	<?php echo wp_kses_post($atts['submit_button_text']); ?>
	<i class="fa fa-angle-right"></i>
</button>

<?php
if (isset($atts['align']) && $atts['align'] <> '') {
	echo '</div>';
}
?>
