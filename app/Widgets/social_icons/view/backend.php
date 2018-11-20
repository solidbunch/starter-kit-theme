<p>
	<label for="<?php echo esc_attr( $data['widget']->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget title:', 'starter-kit' ); ?></label>
	<input type="text" class="widefat title" id="<?php echo esc_attr( $data['widget']->get_field_id( 'title' ) ); ?>"
	       name="<?php echo esc_attr( $data['widget']->get_field_name( 'title' ) ); ?>"
	       value="<?php echo esc_attr( $data['instance']['title'] ); ?>"/>
</p>