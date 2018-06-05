<?php

	// Init the widget
	add_action( 'widgets_init', function() {
		register_widget( \ffblank\widgets\social_icons\widget::class );
	});
