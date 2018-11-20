<?php

// Init the widget
add_action( 'widgets_init', function () {
	register_widget( \StarterKit\Widgets\social_icons\widget::class );
} );
