<?php

// Init the widget
add_action( 'widgets_init', function () {
	register_widget( \ttt\widgets\social_icons\widget::class );
} );
