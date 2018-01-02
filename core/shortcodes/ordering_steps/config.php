<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 10.11.2017
 * Time: 12:27
 */

vc_map( array(
    'name' => esc_html__( 'Ordering steps', 'bvc' ),
    'base' => 'bvc_ordering_steps',
    'icon' => '',
    'category' => esc_html__( 'BVC Elements', 'bvc' ),
    'description' => esc_html__( 'Add an ordering step', 'bvc' ),
    'params' => array(

        /**
         *  Main tab
         **/
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Hide dots?', 'bvc' ),
            'description' => esc_html__( 'Check to hide dots before this column.', 'bvc' ),
            'param_name' => 'is_hidden_dots',
            'group' => esc_html__('Main', 'bvc'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Step number', 'bvc' ),
            'description' => esc_html__( 'Write the number of step.', 'bvc' ),
            'param_name' => 'number',
            'value' => '',
            'holder'		=> 'h2',
            'group' => esc_html__('Main', 'bvc'),
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Title icon Image', 'bvc'),
            'param_name' => 'image',
            'value' => '',
            'description' => esc_html__('Select image from media library.', 'bvc'),
            //'holder'		=> 'img',
            //'class'		=> 'vc_element-icon',
            'group' => esc_html__('Main', 'bvc'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Step Title', 'bvc' ),
            'description' => esc_html__( 'Write the Title of step.', 'bvc' ),
            'param_name' => 'title',
            'value' => '',
            'holder'		=> 'h2',
            'group' => esc_html__('Main', 'bvc'),
        ),
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Step text', 'bvc' ),
            'description' => esc_html__( 'Write the Title of step.', 'bvc' ),
            'param_name' => 'text',
            'value' => '',
            'group' => esc_html__('Main', 'bvc'),
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__( 'Call to action Button', 'bvc' ),
            'description' => esc_html__( 'Add link and Text for the button.', 'bvc' ),
            'param_name' => 'call_to_action_btn',
            'value' => '',
            'group' => esc_html__('Main', 'bvc'),
        ),

    )
));
