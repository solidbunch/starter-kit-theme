<?php 
	$coin_code =  fw_get_db_post_option( get_the_id(), 'code' );
	$currency_name =  fw_get_db_post_option( get_the_id(), 'currency_name' );
 ?>
<?php if ($atts['is_hidden_price_button']): ?>
    <div class="grid-item columns-8">
        <a href="<?php echo get_permalink(); ?>">
            <div class="inside">
                <?php if( has_post_thumbnail() ): ?>
                <div class="thumb">
                    <?php the_post_thumbnail(); ?>
                </div>
                <?php endif; ?>

				<h4><?php echo $currency_name; ?></h4>
            </div>
        </a>
    </div>
<?php else: ?>
    <div class="grid-item">
        <div class="inside">
            <?php if( has_post_thumbnail() ): ?>
            <div class="thumb">
                <?php the_post_thumbnail(); ?>
            </div>
            <?php endif; ?>

			<h4><?php echo $currency_name; ?></h4>

            <div class="exchange-price">
                <span class="price"><?php esc_html_e( 'LOADING PRICE...', 'bvc'); ?></span>
				<span class="qty"><?php esc_html_e( 'PER 1 ', 'bvc'); ?> <?php echo $coin_code; ?></span>
            </div>

            <a href="<?php echo get_permalink(); ?>" class="button"><?php esc_html_e( 'BUY', 'bvc'); ?> <i class="fa fa-angle-right"></i></a>

        </div>
		<input type="hidden" class="coin_code" value="<?php echo $coin_code; ?>">
		<input type="hidden" class="coin_id" value="<?php echo get_the_id(); ?>">
    </div>
<?php endif; ?>