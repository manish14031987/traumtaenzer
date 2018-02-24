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
        'mw_veranstindex' => $_POST['event_id'],
        'mw_name' => $_POST['mw_name'],
        'mw_email' => $_POST['mw_email'],
        'mw_wunsch' => $_POST['xmusic']);
    $mydb->insert( $tablename, $data);
    wp_die(); // this is required to terminate immediately and return a proper response
}

 



function extra_post_info_page(){
?>
 <div class="wrap">
<h1>Music wishe setting</h1>
<form method="post" action="options.php">

  <?php settings_fields( 'prfx-settings-group' ); // set plugin option group for the form ?>

  <?php $tanzveranstaltung_options = get_option( 'tanzveranstaltung_options' ); // get plugin options from the database ?>

  
  <table class="form-table">
    <tbody>
             
      <tr valign="top">
        <th scope="row">Number of wishes per event</th>
        <td>
          <input type="text" class="font-color-field" name="tanzveranstaltung_options[option_wishes_per_page]" value="<?php echo esc_attr( $tanzveranstaltung_options['option_wishes_per_page'] ); ?>" >
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">Thank you message</th>
        <td>            
          <small>You can change  your thank you message.</small>
          <br>
          <textarea rows="7" cols="50" name="tanzveranstaltung_options[option_custom_message]" id="tanzveranstaltung_options[option_custom_message]"><?php echo esc_textarea( $tanzveranstaltung_options['option_custom_message'] ); ?></textarea>
        </td>
      </tr>
    </tbody>  
  </table>
  
  <?php @submit_button(); ?>

</form>
</div>
<?php
//  admin_data();
}



add_action( 'wp_ajax_mw_event_id', 'mw_event_id' );

function mw_event_id() {
  // echo "string";
  echo do_shortcode( '[traumtaenzer_form event_id="'.$_REQUEST['event_id'].'"]' );
  die();
   
}
