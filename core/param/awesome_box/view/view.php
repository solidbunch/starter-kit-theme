<?php 

$base_child  = ffblank\helper\awesome::awesome_font_list();
$settings    = $data['settings'];
$value       = $data['value'];
$button_text = ($value=='')? 'Add icon' : 'Change icon';

foreach ($base_child as $key => $val):

	$awesome.='<div class="param_awesome" title="'.$key.'" att_class="'.$val.'">
				<i class="'.$val.'"></i>
				<span class="name_awesome">'.$key.'</span>
			</div>';

endforeach; ?>
<div class="awesome_block">
	<button class="add_awesome"><?php echo $button_text ?></button>
	<div class="box_awesome">
		<input class="search_awesome" type="text" placeholder="Search icon">
		 <?php echo $awesome ?>
	</div>
	<input name="<?php echo esc_attr( $settings['param_name'] ); ?>" class="wpb_vc_param_value wpb-textinput <?php echo	esc_attr( $settings['param_name']) ?> <?php echo esc_attr( $settings['type'] ) ?>_field" type="text"  value="<?php echo $value ?>" />
</div>	
<i class="icon_add_i <?php echo $value ?>"></i>	

<style>
	.param_awesome {
	    display: inline-block;
	    width: 49px;
	    padding: 5px;
	    height: 75px;
	    text-align: center;
	    vertical-align: text-bottom;
	    cursor:pointer;
	    border: 1px solid transparent;
	}

	.param_awesome i.fa.fa-road {
	    vertical-align: text-top;
	}

	.param_awesome span.name_awesome {
	    display: block;
	    word-wrap: break-word;
	}
	body .awesome_block .box_awesome .search_awesome{
		width: 169px;
	    display: block;
	    margin: 10px 0;
	}
	.box_awesome{
		display:none;
	}
	.awesome_block.active .box_awesome{					
		display:block;					
	}
	.param_awesome.active{
		border: 1px solid #000;
	}
	.param_awesome.active span{
		font-weight: bold;
	}

</style>