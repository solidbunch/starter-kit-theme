<?php 
$select_input_items = $data['select_input_items'];
$coins              = $data['coins'];
$required           = $data['required'];
$code_buy           = $data['code_buy'];

if ( count($select_input_items) > 1 ) : ?>
    <div class="form-builder-item select-coin-item">
        <div class="field-select">
            <select class="select_currency_field">
                <?php foreach ( $select_input_items as $key => $select_input_item ): ?>
					<option value="<?php echo trim( $select_input_item ); ?>" <?php echo ( $key === 0 ) ? 'selected' : ''; ?> data-symbol="<?php echo get_shortcode_currency_symbol( $select_input_item ); ?>"><?php echo trim( $select_input_item ); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php endif; ?>

<div class="form-builder-item select-coin-item">
	<div class="field-select">
		<input type="hidden" name="field_<?php echo esc_attr( $data['atts']['el_id'] ); ?>_f_label" value="<?php echo esc_attr( $data['atts']['label'] ); ?>"/>
		<select class="select_coin_field">

		<?php if ( $coins->have_posts() ) ?>
			<?php foreach ( $coins->posts as $coin_post ) { ?>
				<?php 
				$code              = fw_get_db_post_option( $coin_post->ID, 'code' ); 
				$currency_name     = fw_get_db_post_option( $coin_post->ID, 'currency_name' ); 
				$coins_margin_meta = fw_get_db_post_option( $coin_post->ID, 'the_coin_margin' );	
				$coins_margin_meta = ($coins_margin_meta === '0' || ($coins_margin_meta !== '' && (float)$coins_margin_meta))
					? (float)$coins_margin_meta : null;
				
				$coin_margin = ($coins_margin_meta !== null && $coins_margin_meta >= 0)
					? $coins_margin_meta : (($coins_margin_default !== null && $coins_margin_default >= 0)
						? $coins_margin_default : 0);
						
				if (!empty($code)) {
					$selected = '';
					if ($code_buy == $code) {
						$selected = ' selected="selected"';
					}
				?>
					<option value="<?php echo $code; ?>"<?php echo $selected; ?> data-id="<?php echo $coin_post->ID; ?>" data-margin="<?php echo $coin_margin; ?>" data-name="<?php echo $currency_name; ?>"><?php echo $currency_name; ?> (<?php echo $code; ?>)</option>
				<?php } ?>
			<?php }  ?>

		</select>
	</div>
</div>

<div class="form-builder-item select-coin-item clearfix">
	<div class="field-text-small">
		<input type="number" class="sell_curr" <?php echo $required; ?> placeholder="<?php echo trim( $select_input_items[0] ); ?>" step="0.01" min="0.01" max="10000000" />
		<input type="hidden" class="sell_code" value="<?php echo trim( $select_input_items[0] ); ?>"/>
		<input type="hidden" class="sell_code_default" value="<?php echo trim( $select_input_items[0] ); ?>"/>
	</div>
	<div class="buy_coin_label field-text-small-label">
		<?php echo trim( $select_input_items[0] ); ?> = <?php echo $code_buy;?>
	</div>
	<div class="field-text-small">
		<input type="number" <?php echo $required; ?> class="buy_curr" placeholder="<?php echo $code_buy;?>" step="0.00001" min="0" max="1000000"/>
		<input type="hidden" class="buy_code" value="<?php echo $code_buy; ?>"/>
		
		<input type="hidden" <?php echo $required; ?> <?php echo implode( ' ', $data['attributes'] ); ?> class="result_coins" value="<?php echo $code_buy; ?>"/>
	</div>
	<div class="clearfix"></div>
	<div class="select-coin-msg"></div>
</div>
