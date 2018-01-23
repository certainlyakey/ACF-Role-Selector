<?php

/*
Plugin Name: Advanced Custom Fields: User Role Selector
Plugin URI: https://github.com/danielpataki/ACF-Role-Selector
Description: A field for Advanced Custom Fields which allows you to select a user role
Version: 3.0.2
Author: Daniel Pataki
Author URI: http://danielpataki.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


add_action('plugins_loaded', 'acfurs_load_textdomain');
/**
 * Load Text Domain
 *
 * Loads the textdomain for translations
 *
 * @author Daniel Pataki
 * @since 3.0.0
 *
 */
function acfurs_load_textdomain() {
	load_plugin_textdomain( 'acf-role-selector-field', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
}


add_action('acf/include_field_types', 'include_field_types_role_selector');
/**
 * ACF 5 Field
 *
 * Loads the field for ACF 5
 *
 * @author Daniel Pataki
 * @since 3.0.0
 *
 */
function include_field_types_role_selector( $version ) {
	include_once('acf-role_selector-v5.php');
}

add_action('acf/register_fields', 'register_fields_role_selector');
/**
 * ACF 4 Field
 *
 * Loads the field for ACF 4
 *
 * @author Daniel Pataki
 * @since 3.0.0
 *
 */
function register_fields_role_selector() {
	include_once('acf-role_selector-v4.php');
}

?>
