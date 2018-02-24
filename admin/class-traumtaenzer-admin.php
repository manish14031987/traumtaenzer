<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    traumtaenzer
 * @subpackage traumtaenzer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    traumtaenzer
 * @subpackage traumtaenzer/admin
 * @author     Your Name <email@example.com>
 */
class traumtaenzer_Admin {

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
	 * @param      string    $traumtaenzer       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $traumtaenzer, $version ) {

		$this->traumtaenzer = $traumtaenzer;
		$this->version = $version;
		add_action( 'admin_menu', array( $this, 'extra_post_info_menu' ));
		add_action( 'admin_init', array( $this, 'prfx_register_settings'));
		//add_action( 'admin_data',array( $this, 'extra_post_info_page' ));
		

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->traumtaenzer, plugin_dir_url( __FILE__ ) . 'css/traumtaenzer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->traumtaenzer, plugin_dir_url( __FILE__ ) . 'js/traumtaenzer-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function admin_data() {
		return 'hello this is admin data';
		}


	public function extra_post_info_menu(){

		  $page_title = 'WordPress Extra Post Info';
		  $menu_title = 'Music Wish Setting';
		  $capability = 'manage_options';
		  $menu_slug  = 'extra-post-info';
		  $function   = $this->extra_post_info_page();
		  $icon_url   = 'dashicons-media-code';
		  $position   = 4;

		  add_menu_page( $page_title,
		                 $menu_title, 
		                 $capability, 
		                 $menu_slug, 
		                 $function, 
		                 $icon_url, 
		                 $position );
	}

	public	function prfx_sanitize_options( $input ) {
		  $input['option_display_mode'] = wp_filter_nohtml_kses( $input['option_display_mode'] );
		  $input['option_font_size'] = sanitize_text_field( absint( $input['option_font_size'] ) );
		  $input['option_font_color'] = sanitize_text_field( $input['option_font_color'] );
		  $input['option_custom_css'] = esc_textarea( $input['option_custom_css'] );
		  return $input;
		}

	
		// action for registering setting options
		
		// function for registering prfx setting options
	public	function prfx_register_settings() {
		  register_setting( 'prfx-settings-group', 'tanzveranstaltung_options', 'prfx_sanitize_options' );
		}

	public	function extra_post_info_page(){
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




}
