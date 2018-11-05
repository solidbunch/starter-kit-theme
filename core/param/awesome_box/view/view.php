<?php
$base_child  = ffblank\helper\awesome::awesome_font_list();
$settings    = $data['settings'];
$value       = $data['value'];
$button_text = ( $value == '' ) ? esc_html__( 'Add icon', 'fruitfulblanktextdomain' ) : esc_html__( 'Change icon',
	'fruitfulblanktextdomain' ); ?>

<div class="awesome_block">
	<button class="add_awesome"><?php echo $button_text ?></button>
	<div class="box_awesome">
		<input class="search_awesome" type="text" placeholder="Search icon">

		<?php foreach ( $base_child as $key => $val ): ?>

			<div class="param_awesome" title="<?php echo $key ?>" att_class="<?php echo $val ?>">
				<i class="<?php echo $val ?>"></i>
				<span class="name_awesome"><?php echo $key ?></span>
			</div>

		<?php endforeach; ?>

	</div>
	<input name="<?php echo esc_attr( $settings['param_name'] ); ?>"
	       class="wpb_vc_param_value wpb-textinput <?php echo esc_attr( $settings['param_name'] ) ?> <?php echo esc_attr( $settings['type'] ) ?>_field"
	       type="hidden" value="<?php echo $value ?>"/>
</div>
<span class="view_icon <?php echo ( $value != '' ) ? 'active' : '' ?>">Icon: <i
		class="icon_add_i <?php echo $value ?>"></i></span>
