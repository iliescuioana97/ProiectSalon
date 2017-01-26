<?php

/**
 * Theme updater admin page and functions.
 * 
 * @package WordPress
 * @subpackage Entrepreneur
 * @since Entrepreneur 1.0.0
 */
class MP_Entrepreneur_EDD_Updater_Admin {

    /**
     * Variables required for the theme updater
     *
     * @type string
     */
    protected $remote_api_url = null;
    protected $theme_slug = null;
    protected $version = null;
    protected $author = null;
    protected $download_id = null;
    protected $renew_url = null;
    protected $strings = null;

    /**
     * Initialize the class.
     */
    function __construct($config = array(), $strings = array()) {

        $config = wp_parse_args($config, array(
            'remote_api_url' => '',
            'theme_slug' => get_template(),
            'item_name' => '',
            'license' => '',
            'version' => '',
            'author' => '',
            'download_id' => '',
            'renew_url' => ''
        ));

        // Set config arguments
        $this->remote_api_url = $config['remote_api_url'];
        $this->item_name = $config['item_name'];
        $this->theme_slug = sanitize_key($config['theme_slug']);
        $this->version = $config['version'];
        $this->author = $config['author'];
        $this->download_id = $config['download_id'];
        $this->renew_url = $config['renew_url'];

        // Populate version fallback
        if ('' == $config['version']) {
            $theme = wp_get_theme($this->theme_slug);
            $this->version = $theme->get('Version');
        }

        // Strings passed in from the updater config
        $this->strings = $strings;

        add_action('admin_init', array($this, 'theme_updater'));
        add_action('admin_init', array($this, 'theme_register_option'));
        add_action('admin_init', array($this, 'theme_license_action'));
        add_action('admin_menu', array($this, 'theme_license_menu'));
        add_action('update_option_' . $this->theme_slug . '_license_key', array($this, 'theme_activate_license'), 10, 2);
        add_filter('http_request_args', array($this, 'theme_disable_wporg_request'), 5, 2);
    }

    /**
     * Creates the updater class.
     */
    function theme_updater() {

        /* If there is no valid license key status, don't allow updates. */
        if (get_option($this->theme_slug . '_license_key_status', false) != 'valid') {
            return;
        }

        if (!class_exists('MP_Entrepreneur_EDD_Updater')) {
            // Load our custom theme updater
            include( dirname(__FILE__) . '/theme-updater-class.php' );
        }

        new MP_Entrepreneur_EDD_Updater(
                array(
            'remote_api_url' => $this->remote_api_url,
            'version' => $this->version,
            'license' => trim(get_option($this->theme_slug . '_license_key')),
            'item_name' => $this->item_name,
            'author' => $this->author
                ), $this->strings
        );
    }

    /**
     * Adds a menu item for the theme license under the appearance menu.
     */
    function theme_license_menu() {

        $strings = $this->strings;

        add_theme_page(
                $strings['theme-license'], $strings['theme-license'], 'manage_options', $this->theme_slug . '-license', array($this, 'theme_license_page')
        );
    }

    /**
     * Outputs the markup used on the theme license page.
     */
    function theme_license_page() {
        $isLicensePage = apply_filters('theme_filters_license_page', true);
        if ($isLicensePage) {
            $strings = $this->strings;
            $license = trim(get_option($this->theme_slug . '_license_key'));
            if ($license) {
                $eddLicense = $this->theme_check_license($license);
            }
            $status = get_option($this->theme_slug . '_license_key_status', false);
            ?>
            <div class="wrap">
                <h2><?php echo $strings['theme-license'] ?></h2>
                <form method="post" action="options.php">

                    <?php settings_fields($this->theme_slug . '-license'); ?>

                    <table class="form-table">
                        <tbody>

                            <tr valign="top">
                                <th scope="row" valign="top">
                                    <?php echo $strings['license-key']; ?>
                                </th>

                                <td>
                                    <input id="<?php echo $this->theme_slug; ?>_license_key" name="<?php echo $this->theme_slug; ?>_license_key" type="password" class="regular-text" value="<?php echo $license; ?>" />
                                    <?php if ($license) { ?>
                                        <i style="display:block;"><?php echo str_repeat("&#8226;", 20) . substr($license, -7); ?></i>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php if (!empty($eddLicense['errors'])) { ?>
                                <tr valign="top">
                                    <th scope="row" valign="top">
                                        <?php echo $strings['license-error'] ?>
                                    </th>
                                    <td>
                                        <?php echo join("<br />", $eddLicense['errors']) ?>
                                    </td>
                                </tr>

                            <?php } else if ($license) { ?>
                                <tr valign="top">
                                    <th scope="row" valign="top">
                                        <?php echo $strings['status']; ?>
                                    </th>
                                    <td>
                                        <?php
                                        if (isset($eddLicense['data']->license)) {
                                            switch ($eddLicense['data']->license) {
                                                case 'inactive' : echo $strings['license-is-inactive'];
                                                    break;
                                                case 'site_inactive' : echo $strings['site-is-inactive'];
                                                    break;
                                                case 'valid' :
                                                    if ($eddLicense['data']->expires !== 'lifetime') {
                                                        $date = ($eddLicense['data']->expires) ? new DateTime($eddLicense['data']->expires) : false;
                                                        $expires = ($date) ? ' ' . $date->format('d.m.Y') : '';
                                                        echo $strings['license-valid-until'] . $expires;
                                                    } else {
                                                        echo $strings['license-valid-lifetime'];
                                                    }
                                                    break;
                                                case 'disabled' : echo $strings['license-key-is-disabled'];
                                                    break;
                                                case 'expired' : echo $strings['license-key-expired'];
                                                    break;
                                                case 'invalid' : echo $strings['license-key-invalid'];
                                                    break;
                                                case 'item_name_mismatch' :echo $strings['item-name-mismatch'];
                                                    break;
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php if (isset($eddLicense['data']->license) && in_array($eddLicense['data']->license, array('inactive', 'site_inactive', 'valid'))) { ?>
                                    <tr valign="top">
                                        <th scope="row" valign="top">
                                            <?php echo $strings['action']; ?>
                                        </th>
                                        <td>
                                            <?php
                                            if (isset($eddLicense['data']->license)) {
                                                if ($eddLicense['data']->license === 'inactive' || $eddLicense['data']->license === 'site_inactive') {
                                                    wp_nonce_field($this->theme_slug . '_nonce', $this->theme_slug . '_nonce');
                                                    ?>
                                                    <input type="submit" class="button-secondary" name="<?php echo $this->theme_slug; ?>_license_activate" value="<?php echo $strings['activate-license']; ?>"/>
                                                    <?php
                                                } elseif ($eddLicense['data']->license === 'valid') {
                                                    wp_nonce_field($this->theme_slug . '_nonce', $this->theme_slug . '_nonce');
                                                    ?>
                                                    <input type="submit" class="button-secondary" name="<?php echo $this->theme_slug; ?>_license_deactivate" value="<?php echo $strings['deactivate-license']; ?>" />
                                                    <?php
                                                } elseif ($eddLicense['data']->license === 'expired') {
                                                    
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php submit_button(); ?>
                </form>
                <?php
            }
        }

        /**
         * Registers the option used to store the license key in the options table.
         */
        function theme_register_option() {
            register_setting(
                    $this->theme_slug . '-license', $this->theme_slug . '_license_key', array($this, 'theme_sanitize_license')
            );
        }

        /**
         * Sanitizes the license key.
         *
         * @param string $new License key that was submitted.
         * @return string $new Sanitized license key.
         */
        function theme_sanitize_license($new) {

            $old = get_option($this->theme_slug . '_license_key');

            if ($old && $old != $new) {
                // New license has been entered, so must reactivate
                delete_option($this->theme_slug . '_license_key_status');
                delete_transient($this->theme_slug . '_license_message');
            }

            return $new;
        }

        /**
         * Makes a call to the API.
         *
         * @param array $api_params to be used for wp_remote_get.
         * @return array $response decoded JSON response.
         */
        function theme_get_api_response($api_params) {

            // Call the custom API.
            $response = wp_remote_post($this->remote_api_url, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

            // Make sure the response came back okay.
            if (is_wp_error($response)) {
                return false;
            }

            $response = json_decode(wp_remote_retrieve_body($response));

            return $response;
        }

        /**
         * Activates the license key.
         */
        function theme_activate_license() {

            $license = trim(get_option($this->theme_slug . '_license_key'));

            // Data to send in our API request.
            $api_params = array(
                'edd_action' => 'activate_license',
                'license' => $license,
                'item_name' => urlencode($this->item_name)
            );

            $license_data = $this->theme_get_api_response($api_params);

            // $response->license will be either "active" or "inactive"
            if ($license_data && isset($license_data->license)) {
                update_option($this->theme_slug . '_license_key_status', $license_data->license);
                delete_transient($this->theme_slug . '_license_message');
            }
        }

        /**
         * Deactivates the license key.
         */
        function theme_deactivate_license() {

            // Retrieve the license from the database.
            $license = trim(get_option($this->theme_slug . '_license_key'));

            // Data to send in our API request.
            $api_params = array(
                'edd_action' => 'deactivate_license',
                'license' => $license,
                'item_name' => urlencode($this->item_name)
            );

            $license_data = $this->theme_get_api_response($api_params);

            // $license_data->license will be either "deactivated" or "failed"
            if ($license_data && ( $license_data->license == 'deactivated' )) {
                delete_option($this->theme_slug . '_license_key_status');
                delete_transient($this->theme_slug . '_license_message');
            }
        }

        /**
         * Constructs a renewal link
         */
        function theme_get_renewal_link() {

            // If a renewal link was passed in the config, use that
            if ('' != $this->renew_url) {
                return $this->renew_url;
            }

            // If download_id was passed in the config, a renewal link can be constructed
            $license_key = trim(get_option($this->theme_slug . '_license_key', false));
            if ('' != $this->download_id && $license_key) {
                $url = esc_url($this->remote_api_url);
                $url .= '/checkout/?edd_license_key=' . $license_key . '&download_id=' . $this->download_id;
                return $url;
            }

            // Otherwise return the remote_api_url
            return $this->remote_api_url;
        }

        /**
         * Checks if a license action was submitted.
         */
        function theme_license_action() {

            if (isset($_POST[$this->theme_slug . '_license_activate'])) {
                if (check_admin_referer($this->theme_slug . '_nonce', $this->theme_slug . '_nonce')) {
                    $this->theme_activate_license();
                }
            }

            if (isset($_POST[$this->theme_slug . '_license_deactivate'])) {
                if (check_admin_referer($this->theme_slug . '_nonce', $this->theme_slug . '_nonce')) {
                    $this->theme_deactivate_license();
                }
            }
        }

        /**
         * Checks if license is valid and gets expire date.
         * 
         * @return string $message License status message.
         */
        function theme_check_license() {
            $license = trim(get_option($this->theme_slug . '_license_key'));
            $strings = $this->strings;
            $result = array(
                'errors' => array(),
                'data' => array()
            );
            $apiParams = array(
                'edd_action' => 'check_license',
                'license' => $license,
                'item_name' => urlencode($this->item_name),
                'url' => home_url()
            );

            // Call the custom API.
            $response = wp_remote_get(add_query_arg($apiParams, $this->remote_api_url), array('timeout' => 15, 'sslverify' => false));
            if (is_wp_error($response)) {
                $errors = $response->get_error_codes();
                foreach ($errors as $key => $code) {
                    $result['errors'][$code] = $response->get_error_message($code);
                }
                return $result;
            }

            $licenseData = json_decode(wp_remote_retrieve_body($response));
            if (!is_null($licenseData)) {
                $result['data'] = $licenseData;
            } else {
                $result['errors']['json_decode'] = $strings['license-unknown'];
            }

            return $result;
        }

        /**
         * Disable requests to wp.org repository for this theme.
         */
        function theme_disable_wporg_request($r, $url) {

            // If it's not a theme update request, bail.
            if (0 !== strpos($url, 'https://api.wordpress.org/themes/update-check/1.1/')) {
                return $r;
            }

            // Decode the JSON response
            $themes = json_decode($r['body']['themes']);

            // Remove the active parent and child themes from the check
            $parent = get_option('template');
            $child = get_option('stylesheet');
            unset($themes->themes->$parent);
            unset($themes->themes->$child);

            // Encode the updated JSON response
            $r['body']['themes'] = json_encode($themes);

            return $r;
        }

    }
    