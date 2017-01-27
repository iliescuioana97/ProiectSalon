<?php

/*
  Plugin Name: AdminPageEmplServices
 */

// Run 'Install' script on plugin activation
register_activation_hook(__FILE__, 'InstallScript');

function InstallScript() {
    require_once('install-script.php');
}

add_action('admin_menu', 'ss_add_pages');

function ss_add_pages() {
    add_menu_page('Staff & Services', 'Staff & Services', 'Subscriber', 'menu_Staff&Services', 'display_plugin_descrip_page');
    add_submenu_page('menu_Staff&Services', 'Services', 'Services', 10, 'service', 'display_services_page');
    add_submenu_page('menu_Staff&Services', 'Staff', 'Staff', 10, 'staff', 'display_staff_page');

    $SubMenu5 = add_submenu_page('', 'Manage Service', '', 'administrator', 'manage-service', 'display_manage_service_page');
    $SubMenu20 = add_submenu_page('', 'Manage Staff', '', 'administrator', 'manage-staff', 'display_manage_staff_page');

//service page
    function display_services_page() {
        require_once("menu-pages/service.php");
    }

//staff page
    function display_staff_page() {
        require_once("menu-pages/staff.php");
    }

//manage service page
    function display_manage_service_page() {
        require_once("menu-pages/manage-service.php");
    }

//manage staff page
    function display_manage_staff_page() {
        require_once("menu-pages/manage-staff.php");
    }

}
