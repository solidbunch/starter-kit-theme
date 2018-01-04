<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 10.11.2017
 * Time: 12:27
 */

vc_map( array(
    'name' => esc_html__( 'Ordering steps', 'fruitfulblanktextdomain' ),
    'base' => 'fruitfulblankprefix_ordering_steps',
    'icon' => '',
    'category' => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
    'description' => esc_html__( 'Add an ordering step', 'fruitfulblanktextdomain' ),
    'params' => array(

        /**
         *  Main tab
         **/
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Hide dots?', 'fruitfulblanktextdomain' ),
            'description' => esc_html__( 'Check to hide dots before this column.', 'fruitfulblanktextdomain' ),
            'param_name' => 'is_hidden_dots',
            'group' => esc_html__('Main', 'fruitfulblanktextdomain'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Step number', 'fruitfulblanktextdomain' ),
            'description' => esc_html__( 'Write the number of step.', 'fruitfulblanktextdomain' ),
            'param_name' => 'number',
            'value' => '',
            'holder'		=> 'h2',
            'group' => esc_html__('Main', 'fruitfulblanktextdomain'),
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Title icon Image', 'fruitfulblanktextdomain'),
            'param_name' => 'image',
            'value' => '',
            'description' => esc_html__('Select image from media library.', 'fruitfulblanktextdomain'),
            //'holder'		=> 'img',
            //'class'		=> 'vc_element-icon',
            'group' => esc_html__('Main', 'fruitfulblanktextdomain'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Step Title', 'fruitfulblanktextdomain' ),
            'description' => esc_html__( 'Write the Title of step.', 'fruitfulblanktextdomain' ),
            'param_name' => 'title',
            'value' => '',
            'holder'		=> 'h2',
            'group' => esc_html__('Main', 'fruitfulblanktextdomain'),
        ),
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Step text', 'fruitfulblanktextdomain' ),
            'description' => esc_html__( 'Write the Title of step.', 'fruitfulblanktextdomain' ),
            'param_name' => 'text',
            'value' => '',
            'group' => esc_html__('Main', 'fruitfulblanktextdomain'),
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__( 'Call to action Button', 'fruitfulblanktextdomain' ),
            'description' => esc_html__( 'Add link and Text for the button.', 'fruitfulblanktextdomain' ),
            'param_name' => 'call_to_action_btn',
            'value' => '',
            'group' => esc_html__('Main', 'fruitfulblanktextdomain'),
        ),

    )
));
