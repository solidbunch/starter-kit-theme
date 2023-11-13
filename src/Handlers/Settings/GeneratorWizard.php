<?php

namespace StarterKit\Handlers\Settings;

class GeneratorWizard
{

    public static function addMenuItem() {

        add_submenu_page(
            'options-general.php',
            __( 'Generator Wizard', 'starter-kit' ),
            __( 'Generator Wizard', 'starter-kit' ),
            'manage_options',
            'generator-wizard',
            [ self::class, 'generatorWizardPage' ]
        );
    }

    public static function generatorWizardPage(){

        // Check if the form is submitted
        if (isset($_POST['submit_button'])) {
            // Fetch the value of 'replace_with' from the form
            $replace_with = isset($_POST['replace_with']) ? sanitize_text_field($_POST['replace_with']) : '';

            // Process the value or perform your action here
            // For example, you can display the submitted value
            echo '<div>Submitted Value: ' . esc_html($replace_with) . '</div>';
        }


        ?>
        <div class="wrap">
            <h1><?php _e( 'Generator Wizard', 'starter-kit' ); ?></h1>
            <form method="post" action="">
                <?php wp_nonce_field('my_custom_admin_page_nonce'); ?>
                <input type="text" name="replace_with" id="replace_with" value="" />
                <input type="submit" name="submit_button" id="submit_button" value="Submit" />
            </form>
        </div>
        <?php
    }

}
