<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    traumtaenzer
 * @subpackage traumtaenzer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    traumtaenzer
 * @subpackage traumtaenzer/public
 * @author     Your Name <email@example.com>
 */
class traumtaenzer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $traumtaenzer    The ID of this plugin.
	 */
	private $traumtaenzer;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $traumtaenzer       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $traumtaenzer, $version ) {

		$this->traumtaenzer = $traumtaenzer;
		$this->version = $version;
		add_shortcode( 'traumtaenzer_form', array( $this, 'form_creation' ) );
		add_shortcode( 'all_wishes_event', array( $this, 'all_wishes' ) );
		add_action('init', array( $this, 'tanzveranstaltung_custom_rewrite_basic'));
		add_shortcode('tt_veranstaltung', array( $this, 'tt_veranstaltung_shortcode'));
		add_filter('query_vars', array( $this, 'tanzveranstaltung_query_vars'));
		


	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in traumtaenzer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The traumtaenzer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->traumtaenzer, plugin_dir_url( __FILE__ ) . 'css/traumtaenzer-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in traumtaenzer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The traumtaenzer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->traumtaenzer, plugin_dir_url( __FILE__ ) . 'js/traumtaenzer-public.js', array( 'jquery' ), $this->version, false );

	}

	

	public function form_creation() {
		?>
		<h3 style="font-weight: bold;">Add music wish for event index 10 </h3>
		<div id="traumtaenzer_error" style="display: none;color: red;"></div>
		<div id="message_wish" style="display: none;color: green;"></div>
		<form method="post" id="traumtaenzer_form">
		<div class="form-group"><label>Name:</label> <input type="text" name="mw_name" id="mw_name" ></div>
		<div class="form-group"><label>Email:</label> <input type="text" name="mw_email"  id="mw_email"></div>
		<div class="form-group"><label>3X Music:</label> <input type="text" name="3xmusic" id="3xmusic" ></div>
		<button type="button" id="traumtaenzer_submit" onclick="traumtaenzer_submit_form()">Submit</button> 
		</form>
		<script type="text/javascript">
		     //jQuery('#traumtaenzer_submit').submit(function(){ 
		    /*jQuery("#traumtaenzer_submit").click(function(){
		       // alert('submitted');
		        add_music_wish();
		     
		  });  */ 
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
		            thnxmsg = '<?php echo get_option( "tanzveranstaltung_options")["option_custom_message"]; ?>';
		            if(thnxmsg==''){ thnxmsg = 'Thank you. Your wish has been added for this page';}
		            jQuery('#message_wish').html(thnxmsg);
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
		                 traumtaenzer_submit_form();
		                
		            }
		        }
		    });
		</script>
		<?php
	}

	
 public function all_wishes($attr){
    global $wpdb;
	   $event_id = $attr['event'];
	   $mydb = new wpdb('root', '', 'traumtaenzer2', 'localhost');
	   	$customPagHTML     = "";
	   	$query             = "SELECT * FROM musikwunsch";
		$total_query     = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		$total             = $mydb->get_var( $total_query );
	  $items_per_page = get_option( "tanzveranstaltung_options")["option_wishes_per_page"];
	  if(empty($items_per_page)){
	    $items_per_page = 5;
	  }
		//$items_per_page = 5  ;
		$page             = isset( $_GET['wishes'] ) ? abs( (int) $_GET['wishes'] ) : 1;
		$offset         = ( $page * $items_per_page ) - $items_per_page;
		$all_wishes_data         = $mydb->get_results( "SELECT
	   musikwunsch.mw_wunsch
	    FROM
	    musikwunsch
	    WHERE mw_veranstindex = '".$event_id."' ORDER BY mw_index DESC LIMIT ${offset}, ${items_per_page}" );
		$totalPage         = ceil($total / $items_per_page);

		$all_wish = '<div id="traumtaenzer_container"> <h3>All wishes for event '.$event_id.'</h3> <ul class="traumtaenzer-ul">';
	   	foreach ($all_wishes_data as $single_wish) {
	   		# code...
	   		$all_wish .= '<li>'.$single_wish->mw_wunsch.'</li>';
	   	}
	    $all_wish .= '</ul>';
		if($totalPage > 1){
		$customPagHTML     =  '<div><span>Page '.$page.' of '.$totalPage.'</span><div class="text-right">'.paginate_links( array(
		'base' => add_query_arg( 'wishes', '%#%' ),
		'format' => '',
		'prev_text' => __('&laquo;'),
		'next_text' => __('&raquo;'),
		'total' => $totalPage,
		'current' => $page
		)).'</div></div></div>';
		}

	   $all_wish .=$customPagHTML;
	   return $all_wish;

	}



	// options will be set in admin backend. I can add an option for musikwunsch_page_id and musikwuensche_page_id for the rewrite rules

	

	/*
	 * TANZVERANSTALTUNG URL-REWRITE
	 */
	//wp-root/tanzveranstaltung/<jahr>/<monat>/<tag>/<bezeichnung>-<index>
	public function tanzveranstaltung_custom_rewrite_basic()
	{
		$tanzveranstaltung_page_id = get_option('tanzveranstaltung_page_id');
	    global $tanzveranstaltung_page_id;
	    add_rewrite_rule('^tanzveranstaltung/([0-9]+)/([0-9]+)/([0-9]+)/(\w+)\-([0-9]+)/?', 'index.php?page_id=' . $tanzveranstaltung_page_id . '&vjahr=$matches[1]&vmonat=$matches[2]&vtag=$matches[3]&vbezeichnung=$matches[4]&vindex=$matches[5]', 'top');
	}



	/*
	 * Custom permalink tags for get_query_var function
	 * https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
	 */
	public function tanzveranstaltung_query_vars($query_vars)
	{
	    $query_vars[] = 'vjahr';
	    $query_vars[] = 'vmonat';
	    $query_vars[] = 'vtag';
	    $query_vars[] = 'vbezeichnung';
	    $query_vars[] = 'vindex';
	    return $query_vars;
	}
	/*
	 * END TANZVERANSTALTUNG URL-REWRITE
	 */

	public function tt_veranstaltung_shortcode($atts)
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

public function ttfindVeranst($atts)
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

	
	
}
//die();