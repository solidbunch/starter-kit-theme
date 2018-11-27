<?php

//dump($data);

$atts  = $data['atts'];

?>

<div id="starter-kit-pricing-table-<?php echo $atts['id']; ?>" class="starter-kit-pricing-tables" >
    <div class="row">

        <?php foreach ($data['columns'] as $column) : ?>

        <div class="starter-kit-col col">

            <div class="starter-kit-pricing-table">
                <h4 class="starter-kit-title" style="<?php echo $bcolor; ?>"><?php echo $column['title']; ?></h4>

                <div class="starter-kit-features">
                    <?php
                        $features_exploded = explode(',', $column['features']);
                        $features_list = implode( '<br>', $features_exploded );
                        echo $features_list;
                    ?>
                </div>

                <div class="starter-kit-prices">
                    <div class="starter-kit-currency"><?php echo $column['currency']; ?></div>
                    <div class="starter-kit-price"><?php echo $column['price']; ?></div>
                    <div class="starter-kit-period"><?php echo $column['period']; ?></div>
                </div>

                <a href="<?php echo $column['button_url']; ?>" class="starter-kit-button"><?php echo $column['button_title']; ?></a>
            </div>

        </div>

        <?php endforeach; ?>

        <div class="ff-w-100"></div>

    </div>
</div>

<style>
	<?php if ( !empty( $atts['border_color'] ) ) : ?>
	.starter-kit-pricing-table,
	.starter-kit-pricing-table .starter-kit-title{
		border-color: <?php echo $atts['border_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['border_radius'] ) ) : ?>
	.starter-kit-pricing-table {
		border-radius: <?php echo $atts['border_radius']; ?>px !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['border_width'] ) ) : ?>
	.starter-kit-pricing-table,
	.starter-kit-pricing-table .starter-kit-title{
		border-width: <?php echo $atts['border_width']; ?>px !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['header_bg_color'] ) ) : ?>
	.starter-kit-pricing-table .starter-kit-title{
		background-color: <?php echo $atts['header_bg_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['header_text_color'] ) ) : ?>
	.starter-kit-pricing-table .starter-kit-title{
		color: <?php echo $atts['header_text_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_bg_color'] ) ) : ?>
	.starter-kit-pricing-table .starter-kit-button{
		background-color: <?php echo $atts['button_bg_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_hover_bg_color'] ) ) : ?>
	.starter-kit-pricing-table .starter-kit-button:hover{
		background-color: <?php echo $atts['button_hover_bg_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_text_color'] ) ) : ?>
	.starter-kit-pricing-table .starter-kit-button{
		color: <?php echo $atts['button_text_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_hover_text_color'] ) ) : ?>
	.starter-kit-pricing-table .starter-kit-button:hover{
		color: <?php echo $atts['button_hover_text_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_border_color'] ) ) : ?>
	.starter-kit-pricing-table .starter-kit-button{
		border: 1px solid <?php echo $atts['button_border_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_border_width'] ) ) : ?>
	.starter-kit-pricing-table .starter-kit-button{
		border-width: <?php echo $atts['button_border_width']; ?>px !important;
	}
	<?php endif; ?>
</style>
