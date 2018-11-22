<div class="sk_tabs_tab">
	<div class="sk-inside">
		<h4 class="sk-title">
			<?php if ( $data['atts']['icon'] <> '' ): ?>
                <i class="<?php echo esc_attr( $data['atts']['icon'] ); ?>"></i>
			<?php endif; ?>
            <?php echo wp_kses_post($data['atts']['title']) ?>
        </h4>
		<div class="sk-tab-content">
			<?php echo wp_kses_post($data["content"]) ?>
		</div>
	</div>
</div>
