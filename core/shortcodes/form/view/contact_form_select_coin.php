<?php if ( count($select_input_items) > 1 ) : ?>
    <div class="form-builder-item select-coin-item">
        <div class="field-select">
            <select class="select_currency_field">
                <?php foreach ($select_input_items as $key => $select_input_item): ?>
                    <option value="<?php echo trim($select_input_item); ?>" <?php echo ($key === 0) ? 'selected' : ''; ?>><?php echo trim($select_input_item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php endif; ?>

<div class="form-builder-item select-coin-item">
	<div class="field-select">
		<input type="hidden" name="field_<?php echo esc_attr($atts['el_id']); ?>_f_label" value="<?php echo esc_attr($atts['label']); ?>"/>
		<select class="select_coin_field">
		<?php if ($coins->have_posts()) ?>
			<?php foreach ($coins->posts as $coin_post) { ?>
				<?php $code = fw_get_db_post_option( $coin_post->ID, 'code' ); ?>
				<?php $currency_name = fw_get_db_post_option( $coin_post->ID, 'currency_name' ); ?>
				<?php if (!empty($code)) {
					$selected = '';
					if ($code_buy == $code) {
						$selected = ' selected="selected"';
					}
				?>
					<option value="<?php echo $code; ?>"<?php echo $selected; ?>><?php echo $currency_name; ?> (<?php echo $code; ?>)</option>
				<?php } ?>
			<?php }  ?>
		</select>
	</div>
</div>

<div class="form-builder-item select-coin-item clearfix">
	<div class="field-text-small">
		<input type="number" class="sell_curr" <?php echo $required; ?> placeholder="<?php echo trim($select_input_items[0]); ?>" step="0.01" min="0.01" max="10000000" />
		<input type="hidden" class="sell_code" value="<?php echo trim($select_input_items[0]); ?>"/>
	</div>
	<div class="buy_coin_label field-text-small-label">
		<?php echo trim($select_input_items[0]); ?> = <?php echo $code_buy;?>
	</div>
	<div class="field-text-small">
		<input type="number" <?php echo $required; ?> class="buy_curr" placeholder="<?php echo $code_buy;?>" step="0.00001" min="0" max="1000000"/>
		<input type="hidden" class="buy_code" value="<?php echo $code_buy; ?>"/>
		
		<input type="hidden" <?php echo $required; ?> <?php echo implode(' ', $attributes); ?> class="result_coins" value="<?php echo $code_buy; ?>"/>
	</div>
	<div class="clearfix"></div>
	<div class="select-coin-msg"></div>
</div>
