<?php 

if ( isset($data['align']) && $data['align'] <> '' ) {
	echo '<div style="text-align: ' . esc_attr( $data['align'] ) . ';">';
}
?>
<button type="submit" id="<?php echo esc_attr( $data['el_id'] ); ?>" class="button form-builder-submit button-buy">
	<?php echo wp_kses_post( $data['buy_button_text'] ); ?>
	<i class="fa fa-angle-right"></i>
</button>
<?php if ( $data['sell'] ) { ?>
<span class="sell-link-text"><?php echo $data['sell_link_text']; ?></span>
<span class="buy-link-text"><?php echo $data['buy_link_text']; ?></span>
<button type="submit" id="<?php echo esc_attr( $data['el_id'] ); ?>" class="button form-builder-submit button-sell">
	<?php echo wp_kses_post( $data['sell_button_text'] ); ?>
	<i class="fa fa-angle-right"></i>
</button>
<input type="hidden" <?php if ( !empty($data['input_id']) ) {?>name="field_<?php echo esc_attr( $data['input_id'] ); ?>_f_label"<?php } ?> value="<?php echo esc_attr( $data['input_label'] ); ?>"/>
<input type="hidden" id="operation_to" <?php if ( !empty($data['input_id']) ) {?>name="field_<?php echo esc_attr($data['input_id']); ?>"<?php } ?> value="<?php echo $operation; ?>"/>
<?php } ?>
<?php
if ( isset($data['align']) && $data['align'] <> '' ) {
	echo '</div>';
}
?>
