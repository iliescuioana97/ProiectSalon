<?php

/**
 * Easy Digital Downloads Theme Updater
 *
 * @package WordPress
 * @subpackage Entrepreneur
 * @since Entrepreneur 1.0.0
 */
// Includes the files needed for the theme updater
if (!class_exists('MP_Entrepreneur_EDD_Updater_Admin')) {
    include( dirname(__FILE__) . '/theme-updater-admin.php' );
}
$mp_entrepreneur_info = wp_get_theme();
$mp_entrepreneur_name = $mp_entrepreneur_info->get('Name');
$mp_entrepreneur_slug = get_template();
$mp_entrepreneur_version = $mp_entrepreneur_info->get('Version');
$mp_entrepreneur_author = $mp_entrepreneur_info->get('Author');
$remote_api_url = $mp_entrepreneur_info->get('AuthorURI');
// Loads the updater classes
$updater = new MP_Entrepreneur_EDD_Updater_Admin(
        // Config settings
        $config = array(
    'remote_api_url' => $remote_api_url, // Site where EDD is hosted
    'item_name' => $mp_entrepreneur_name, // Name of theme
    'theme_slug' => $mp_entrepreneur_slug, // Theme slug
    'version' => $mp_entrepreneur_version, // The current version of this theme
    'author' => $mp_entrepreneur_author, // The author of this theme
    'download_id' => '', // Optional, used for generating a license renewal link
    'renew_url' => '' // Optional, allows for a custom license renewal link
        ),
        // Strings
        $strings = array(
    'theme-license' => __('Theme License',  'entrepreneur' ),
    'enter-key' => __('Enter your theme license key.',  'entrepreneur' ),
    'license-key' => __('License Key',  'entrepreneur' ),
    'license-action' => __('License Action',  'entrepreneur' ),
    'deactivate-license' => __('Deactivate License',  'entrepreneur' ),
    'license-error' => __('Errors',  'entrepreneur' ),
    'license-is-inactive' => __('License is inactive.',  'entrepreneur' ),
    'site-is-inactive' => __('Site is inactive.',  'entrepreneur' ),
    'license-valid-until' => __("Valid until",  'entrepreneur' ),
    'license-valid-lifetime' => __("Valid (Lifetime)",  'entrepreneur' ),
    'license-key-is-disabled' => __('License key is disabled.',  'entrepreneur' ),
    'license-key-expired' => __('License key has expired.',  'entrepreneur' ),
    'license-key-invalid' => __('License status is invalid.',  'entrepreneur' ),
    'item-name-mismatch' => __("Your License Key does not match the installed theme.",  'entrepreneur' ),
    'action' => __('Action',  'entrepreneur' ),
    'license-unknown' => __('License  is unknown.',  'entrepreneur' ),
    'status' => __('Status',  'entrepreneur' ),
    'activate-license' => __('Activate License',  'entrepreneur' ),
    'update-notice' => __("Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.",  'entrepreneur' ),
    'update-available' => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.',  'entrepreneur' )
        )
);
