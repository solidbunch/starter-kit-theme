<?php

/**
 * @array $data shortcode output data from controller
 **/

$atts     = $data['atts'];

extract($atts);

$content  = isset( $data['content'] ) ? $data['content'] : '';
$columns  = $data['columns'];
$iterator = count( $columns );

?>

<div id="ff-pricing-tables-<?php echo $atts['id']; ?>" class="ff fruitful_pricing_tables" >
	<div class="ff-container">
		<div class="ff-row row">

			<?php foreach ($columns as $column) : ?>

			<div class="ff-col col">

				<div class="ff fruitful_pricing_table" style="<?php echo $bcolor; ?>">
					<h4 class="ff-title" style="<?php echo $bcolor; ?>"><?php echo $column['title']; ?></h4>

					<div class="ff-features">

						<?php

							$features_exploded = explode(',', $column['features']);
							$features_list = implode( '<br>', $features_exploded );
							echo $features_list;

						?>

					</div>

					<div class="ff-table-price">
						<div class="ff-currency"><?php echo $column['currency']; ?></div>
						<div class="ff-price"><?php echo $column['price']; ?></div>
						<div class="ff-period"><?php echo $column['period']; ?></div>

					</div>

					<a href="<?php echo $column['button_url']; ?>" class="ff-button"><?php echo $column['button_title']; ?></a>
				</div>

			</div>

			<?php endforeach; ?>

			<div class="ff-w-100"></div>

		</div>
	</div>
</div>

<style>
	<?php if ( !empty( $border_color ) ) : ?>
	.ff.fruitful_pricing_table,
	.ff.fruitful_pricing_table .ff-title{
		border-color: <?php echo $border_color; ?>!important;
	}
	<?php endif; ?>

	<?php if ( !empty( $border_radius ) ) : ?>
	.ff.fruitful_pricing_table {
		border-radius: <?php echo $border_radius; ?>!important;
	}
	<?php endif; ?>

	<?php if ( !empty( $border_width ) ) : ?>
	.ff.fruitful_pricing_table,
	.ff.fruitful_pricing_table .ff-title{
		border-width: <?php echo $border_width; ?>!important;
	}
	<?php endif; ?>

	<?php if ( !empty( $header_bg_color ) ) : ?>
	.ff.fruitful_pricing_table .ff-title{
		background-color: <?php echo $header_bg_color; ?>!important;
	}
	<?php endif; ?>

	<?php if ( !empty( $header_text_color ) ) : ?>
	.ff.fruitful_pricing_table .ff-title{
		color: <?php echo $header_text_color; ?>!important;
	}
	<?php endif; ?>

	<?php if ( !empty( $button_bg_color ) ) : ?>
	.ff.fruitful_pricing_table .ff-button{
		background-color: <?php echo $button_bg_color; ?>!important;
	}
	<?php endif; ?>

	<?php if ( !empty( $button_hover_bg_color ) ) : ?>
	.ff.fruitful_pricing_table .ff-button:hover{
		background-color: <?php echo $button_hover_bg_color; ?>!important;
	}
	<?php endif; ?>

	<?php if ( !empty( $button_text_color ) ) : ?>
	.ff.fruitful_pricing_table .ff-button{
		color: <?php echo $button_text_color; ?>!important;
	}
	<?php endif; ?>

	<?php if ( !empty( $button_hover_text_color ) ) : ?>
	.ff.fruitful_pricing_table .ff-button:hover{
		color: <?php echo $button_hover_text_color; ?>!important;
	}
	<?php endif; ?>

	<?php if ( !empty( $button_border_color ) ) : ?>
	.ff.fruitful_pricing_table .ff-button{
		border: 1px solid <?php echo $button_border_color; ?>!important;
	}
	<?php endif; ?>

	<?php if ( !empty( $button_border_width ) ) : ?>
	.ff.fruitful_pricing_table .ff-button{
		border-width: <?php echo $button_border_width; ?>!important;
	}
	<?php endif; ?>
</style>
