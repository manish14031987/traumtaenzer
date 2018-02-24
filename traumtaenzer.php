<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           traumtaenzer
 *
 * @wordpress-plugin
 * Plugin Name:       Traumtaenzer
 * Plugin URI:        http://example.com/traumtaenzer-uri/
 * Description:       This is a Music wishes post for an event. 
 * Version:           1.0.0
 * Author:            Manish
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       traumtaenzer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'traumtaenzer_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-traumtaenzer-activator.php
 */
function activate_traumtaenzer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-traumtaenzer-activator.php';
	traumtaenzer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-traumtaenzer-deactivator.php
 */
function deactivate_traumtaenzer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-traumtaenzer-deactivator.php';
	traumtaenzer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_traumtaenzer' );
register_deactivation_hook( __FILE__, 'deactivate_traumtaenzer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-traumtaenzer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_traumtaenzer() {

	$plugin = new traumtaenzer();
	$plugin->run();

}
run_traumtaenzer();


add_action( 'wp_ajax_mw_music', 'add_mw_music' );

function add_mw_music() {
   global $wpdb;
   $mydb = new wpdb('root', '', 'traumtaenzer2', 'localhost');
    $tablename='musikwunsch';

    $data=array(
        'mw_veranstindex' => '10',
        'mw_name' => $_POST['mw_name'],
        'mw_email' => $_POST['mw_email'],
        'mw_wunsch' => $_POST['xmusic']);
    $mydb->insert( $tablename, $data);
    wp_die(); // this is required to terminate immediately and return a proper response
}

 




