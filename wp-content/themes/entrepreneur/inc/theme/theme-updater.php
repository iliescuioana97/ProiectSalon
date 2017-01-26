<?php

/**
 * Load theme updater functions.
 * Action is used so that child themes can easily disable.
 * 
 * @package WordPress
 * @subpackage Entrepreneur
 * @since Entrepreneur 1.0.0
 */

function mp_entrepreneur_updater() {
    require( get_template_directory() . '/classes/theme/theme-updater.php' );
}

add_action('after_setup_theme', 'mp_entrepreneur_updater');
