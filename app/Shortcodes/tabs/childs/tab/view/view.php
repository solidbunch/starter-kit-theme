<div class="starter-kit_tabs_tab">
	<div class="starter-kit-inside">
		<h4 class="starter-kit-title">
			<?php if ( $data['atts']['icon'] <> '' ): ?>
                <i class="<?php echo esc_attr( $data['atts']['icon'] ); ?>"></i>
			<?php endif; ?>
            <?php echo wp_kses_post($data['atts']['title']) ?>
        </h4>
		<div class="starter-kit-tab-content">
			<?php echo wp_kses_post($data["content"]) ?>
		</div>
	</div>
</div>
