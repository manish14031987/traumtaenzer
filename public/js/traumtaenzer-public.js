(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 */
	//traumtaenzer_submit
	 

	 /*
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
//console.log('readysdsdsd');
})( jQuery );
	/*function check(){
	 	alert('hiiii');
	 }*/
	 function traumtaenzer_submit_form(){

	 	mw_name = jQuery('#mw_name').val();
	 	mw_email = jQuery('#mw_email').val();
	 	xmusic = jQuery('#3xmusic').val();
	 	//alert(mw_email + "  " + mw_email + "  " +xmusic);
	 	 add_music_wish();
	 };