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

function form_creation(){
 
?>
<h3 style="font-weight: bold;">Add music wish for event index 10 </h3>
<div id="message_wish" style="display: none;color: green;"></div>
<form method="post" id="traumtaenzer_form">
Name: <input type="text" name="mw_name" placeholder="Name"><br>
Email: <input type="text" name="mw_email" placeholder="Email"><br>
3X Music: <input type="text" name="3xmusic" placeholder="Your wish"><br><br>
<button type="button" id="traumtaenzer_submit">Submit</button> 
</form>
<script type="text/javascript">
     //jQuery('#traumtaenzer_submit').submit(function(){ 
    jQuery("#traumtaenzer_submit").click(function(){
       // alert('submitted');
        add_music_wish();
     
  });   
function add_music_wish(){

    mw_name = jQuery('input[name=mw_name]').val();
    mw_email = jQuery('input[name=mw_email]').val();
    xmusic = jQuery('input[name=3xmusic]').val();

    
     jQuery.ajax({
         type : "post",
         dataType : "json",
         url : "<?php echo admin_url('admin-ajax.php');?>",
         data : {
                    action: "mw_music",
                    nonce:  "<?php echo wp_create_nonce( "unique_id_nonce" );?>",
                    mw_name: mw_name,
                    mw_email: mw_email,
                    xmusic: xmusic
                },
         success: function(response) {
            console.log('complated');
            jQuery('#message_wish').html('Thank you !!! Your wish has been added to this event');
            jQuery('#message_wish').show(500);
            setTimeout(function(){ jQuery('#message_wish').hide(500);},5000);
            jQuery('#traumtaenzer_form').trigger("reset");
         }
      })
}
jQuery("#traumtaenzer_form").keydown(function(e){
        document.onkeypress = keyPress;
        function keyPress(e){
            var x = e || window.event;
            var key = (x.keyCode || x.which);       
            if(key == 13 || key == 3){
                var button_value = jQuery('input:button').val();
                 add_music_wish();
                
            }
        }
    });
</script>
<?php
}
add_shortcode('traumtaenzer_form', 'form_creation');

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

 
 function all_wishes($attr){
    global $wpdb;
   $event_id = $attr['event'];
   $mydb = new wpdb('root', '', 'traumtaenzer2', 'localhost');
   /*$all_wishes_data = $mydb->get_results('SELECT
   musikwunsch.mw_wunsch
    FROM
    musikwunsch
    WHERE mw_veranstindex = "'.$event_id.'"	');
   $all_wish = '<h3>All wishes for event '.$event_id.'</h3>';
   	foreach ($all_wishes_data as $single_wish) {
   		# code...
   		$all_wish .= $single_wish->mw_wunsch.'<br>';
   	}*/
   //print_r( $query[0]);
   	$customPagHTML     = "";
   	$query             = "SELECT * FROM musikwunsch";
	$total_query     = "SELECT COUNT(1) FROM (${query}) AS combined_table";
	$total             = $mydb->get_var( $total_query );
	$items_per_page = 4;
	$page             = isset( $_GET['wishes'] ) ? abs( (int) $_GET['wishes'] ) : 1;
	$offset         = ( $page * $items_per_page ) - $items_per_page;
	$all_wishes_data         = $mydb->get_results( "SELECT
   musikwunsch.mw_wunsch
    FROM
    musikwunsch
    WHERE mw_veranstindex = '".$event_id."' ORDER BY mw_index DESC LIMIT ${offset}, ${items_per_page}" );
	$totalPage         = ceil($total / $items_per_page);

	$all_wish = '<h3>All wishes for event '.$event_id.'</h3>';
   	foreach ($all_wishes_data as $single_wish) {
   		# code...
   		$all_wish .= $single_wish->mw_wunsch.'<br>';
   	}

	if($totalPage > 1){
	$customPagHTML     =  '<div><span>Page '.$page.' of '.$totalPage.'</span><div class="text-right">'.paginate_links( array(
	'base' => add_query_arg( 'wishes', '%#%' ),
	'format' => '',
	'prev_text' => __('&laquo;'),
	'next_text' => __('&raquo;'),
	'total' => $totalPage,
	'current' => $page
	)).'</div></div>';
	}

   $all_wish .=$customPagHTML;
   return $all_wish;

}
add_shortcode('all_wishes_event', 'all_wishes');




// options will be set in admin backend. I can add an option for musikwunsch_page_id and musikwuensche_page_id for the rewrite rules

$tanzveranstaltung_page_id = get_option('tanzveranstaltung_page_id');

/*
 * TANZVERANSTALTUNG URL-REWRITE
 */
//wp-root/tanzveranstaltung/<jahr>/<monat>/<tag>/<bezeichnung>-<index>
function tanzveranstaltung_custom_rewrite_basic()
{
    global $tanzveranstaltung_page_id;
    add_rewrite_rule('^tanzveranstaltung/([0-9]+)/([0-9]+)/([0-9]+)/(\w+)\-([0-9]+)/?', 'index.php?page_id=' . $tanzveranstaltung_page_id . '&vjahr=$matches[1]&vmonat=$matches[2]&vtag=$matches[3]&vbezeichnung=$matches[4]&vindex=$matches[5]', 'top');
}

add_action('init', 'tanzveranstaltung_custom_rewrite_basic');

/*
 * Custom permalink tags for get_query_var function
 * https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
 */
function tanzveranstaltung_query_vars($query_vars)
{
    $query_vars[] = 'vjahr';
    $query_vars[] = 'vmonat';
    $query_vars[] = 'vtag';
    $query_vars[] = 'vbezeichnung';
    $query_vars[] = 'vindex';
    return $query_vars;
}

add_filter('query_vars', 'tanzveranstaltung_query_vars');
/*
 * END TANZVERANSTALTUNG URL-REWRITE
 */

function tt_veranstaltung_shortcode($atts)
{
    $atts = array(
        'veranstjahr' => get_query_var('vjahr'),
        'veranstmonat' => get_query_var('vmonat'),
        'veransttag' => get_query_var('vtag'),
        'veranstbezeichnung' => str_replace('_', ' ', get_query_var('vbezeichnung')),
        'veranstindex' => get_query_var('vindex')
    );
   // return $atts['musikwuensche_page_id'];
    global $wochentage;
    $veranst = ttfindVeranst($atts);
    if (empty($veranst)) {
        return 'Nichts gefunden';
    } else {

        return $veranst[0]->titel1;

    }
}

add_shortcode('tt_veranstaltung', 'tt_veranstaltung_shortcode');

function ttfindVeranst($atts)
{

    $veranstindex = $atts['veranstindex'];

    $mydb = new wpdb('root', '', 'traumtaenzer2', 'localhost');

    $query = $mydb->get_results('SELECT
veranst.`index` as veranstindex,
veranst.datum,
veranst.beginn,
veranst.titel1,
veranst.titel2,
veranst.standort,
veranst.info,
veranst.link,
veranst.dj,
veranst.standort2,
veranst.titel3,
veranst.standortindex,
veranst.sonderveranstaltung,
veranst.link2,
veranst.textlink2,
veranst.ende,
veranst.infointern,
veranst.gruppe,
veranst.export,
veranst.vorverkauf,
veranst.faelltaus,
veranst.ausverkauft,
veranst.standortkurz,
veranst.vorankuendigung,
veranst.startseite,
veranst.ticketlink
FROM
veranst
WHERE (veranst.anzeigen = 1) and veranst.`index` = "' . $veranstindex . '"');
    return $query;
}

