/**
 * Toggle Content Editor/H2B Post Builder
 * @author David Chandra Purnama <david@genbumedia.com>
 * @copyright Copyright (c) 2016, Genbu Media
 */
jQuery( document ).ready( function($) {

	/* Editor Toggle Function */
	function h2bPb_Editor_Toggle(){
		if( 'templates/page-builder.php' == $( '#page_template' ).val() ){
			$( '#postdivrich' ).hide();
			$( '#h2b-page-builder' ).show();
		}
		else{
			$( '#postdivrich' ).show();
			$( '#h2b-page-builder' ).hide();
		}
	}

	/* Toggle On Page Load */
	h2bPb_Editor_Toggle();

	/* If user change page template drop down */
	$( "#page_template" ).change( function(e) {
		h2bPb_Editor_Toggle();
	});

});