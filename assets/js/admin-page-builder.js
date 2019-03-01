/**
 * f(x) H2B Post Builder Base Admin JS
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @link https://shellcreeper.com/wp-page-builder-plugin-from-scratch/
 * @author David Chandra Purnama <david@genbumedia.com>
 * @copyright Copyright (c) 2016, Genbu Media
**/
jQuery( document ).ready( function( $ ){

	/* Function: Update Order */
	function h2bPB_UpdateOrder(){
		$('.h2b-radio').change(function() { 
				if ($(this).is(':checked')) {
					var field = $( this ).attr( 'data-field' );
					$('.h2b-radio-rst').val(this.value);
					$('.h2b-method-act').text(field);
					$('.h2b-radio-rst').text(this.value);
				} else {
					$('.h2b-radio-rst').val('false');
				}
			})
		.change();
		/* In each of rows */
		$('.h2bpb-rows > .h2bpb-row').each( function(i){

			/* Increase num by 1 to avoid "0" as first index. */
			var num = i + 1;
			
			/* Add id to each group section */
			$( this ).attr( 'id', 'container-' + num + '');
			
			/* Update order number in row title */
			$( this ).find( '.h2bpb-order' ).text( num );

			/* In each input in the row */
			$( this ).find( '.h2bpb-row-input' ).each( function(i) {

				/* Get field id for this input */
				var field = $( this ).attr( 'data-field' );

				/* Update name attribute with order and field name.  */
				$( this ).attr( 'name', 'h2bpb[' + num + '][' + field + ']');
			});
			
			
			$( this ).find( '.content-not-set' ).each( function(i) {

				$( this ).attr( 'id', 'content-' + num + '');
			});
			
			//Fix wp_editor
			$( this ).find( '.wp-editor-tarea' ).each( function(i) {
				
				var textAreaID = $(this).attr('id');
				
				// Reinitialize the editor: Remove the editor then add it back
				tinymce.execCommand( 'mceRemoveEditor', false, textAreaID );
				tinymce.execCommand( 'mceAddEditor', false, textAreaID );
				tinyMCE.execCommand('mceAddControl', false, textAreaID); 
			});
			
			/* In each input in the row */
			$( this ).find( '.meta-image' ).each( function(i) {
				/* Update name attribute with order and field name.  */
				$( this ).attr( 'id', 'meta-image-' + num + '');
			});
			
			/* In each input in the row */
			$( this ).find( '.meta-image-button' ).each( function(i) {
				/* Update name attribute with order and field name.  */
				$( this ).attr( 'id', 'meta-image-button-' + num + '');
			});
		});
	}

	/* Update Order on Page load */
	h2bPB_UpdateOrder();

	/* Make Row Sortable */
	$( '.h2bpb-rows' ).sortable({
		handle: '.h2bpb-handle',
		cursor: 'grabbing',
		stop: function( e, ui ) {
			h2bPB_UpdateOrder();
		},
	});
	
	/* Add Row */
	$( 'body' ).on( 'click', '.h2bpb-add-row', function(e){
		e.preventDefault();
		
		/* Target the template. */
		var template = '.h2bpb-templates > .h2bpb-' + $( this ).attr( 'data-template' );

		/* Clone the template and add it. */
		$( template ).clone().appendTo( '.h2bpb-rows' );

		/* Hide Empty Row Message */
		$( '.h2bpb-rows-message' ).hide();

		/* Update Order */
		h2bPB_UpdateOrder();
	});

	/* Hide/Show Empty Row Message On Page Load */
	if( $( '.h2bpb-rows > .h2bpb-row' ).length ){
		$( '.h2bpb-rows-message' ).hide();
	}
	else{
		$( '.h2bpb-rows-message' ).show();
	}
	
	
	/* Upload picture */
	$( 'body' ).on( 'click', '.meta-image-button', function(e){
		var MetaImage = $(this).prev().attr("id"); // .text() instead of .val()
		
			var meta_image_frame;
			e.preventDefault();
			
			// If the frame already exists, re-open it.
			if ( meta_image_frame ) {
				meta_image_frame.open();
				return;
			}
	 
			// Sets up the media library frame
			meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
				title: meta_image.title,
				button: { text:  meta_image.button },
				library: { type: 'image' }
			});
	 
			// Runs when an image is selected.
			meta_image_frame.on('select', function(){
	 
				// Grabs the attachment selection and creates a JSON representation of the model.
				var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
	 
				// Sends the attachment URL to our custom image input field.
				$('#'+ MetaImage + '').val(media_attachment.url);
			});
	 
			// Opens the media library frame.
			meta_image_frame.open();
		
		/* Update Order */
		h2bPB_UpdateOrder();
	});
	
	/* Delete Row */
	$( 'body' ).on( 'click', '.h2bpb-remove', function(e){
		e.preventDefault();

		/* Delete Row */
		$( this ).parents( '.h2bpb-row' ).remove();
		
		/* Show Empty Message When Applicable. */
		if( ! $( '.h2bpb-rows > .h2bpb-row' ).length ){
			$( '.h2bpb-rows-message' ).show();
		}

		/* Update Order */
		h2bPB_UpdateOrder();
	});
	
});
