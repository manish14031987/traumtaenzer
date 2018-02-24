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
	 	jQuery('#traumtaenzer_form input').removeClass('traumtaenzer_error');
	 	flag = true;
	 	if(mw_name == '')
	 	{
	 		jQuery('#mw_name').addClass('traumtaenzer_error');
	 		flag = false;
	 	}
	 	if(mw_email == '')
	 	{
	 		jQuery('#mw_email').addClass('traumtaenzer_error');
	 		flag = false;

	 	}
	 	if(xmusic == '')
	 	{
	 		jQuery('#3xmusic').addClass('traumtaenzer_error');
	 		flag = false;
	 	}
	 	if(flag)
	 	{
	 		add_music_wish();
	 	}
	 	
	 };

	 /*if(mw_email =='' || mw_name == '' || xmusic == ''){
	 	 		jQuery('#traumtaenzer_error').html('All fill all details.');
	 	 		jQuery('#traumtaenzer_error').show(500);
            	setTimeout(function(){ jQuery('#traumtaenzer_error').hide(500);},5000);
	 		}
	 		else{
	 				add_music_wish();
	 		}
	 	}*/