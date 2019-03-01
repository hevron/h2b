<?php
/**
 * H2B Post Builder Functions
 * - Sanitize H2B Post Builder Data
 * 
 * @since 1.0.0
 * @author David Chandra Purnama <david@genbumedia.com>
 * @copyright Copyright (c) 2016, Genbu Media
**/

/**
 * Sanitize H2B Post Builder Data
 * @since 1.0.0
 */



add_action('do_meta_boxes', 'wp_post_attribute_move_meta_box');

function wp_post_attribute_move_meta_box(){
    remove_meta_box( 'pageparentdiv', 'post', 'side' );
    add_meta_box('pageparentdiv', __('Post Attributes'), 'page_attributes_meta_box', 'post', 'side', 'high');
}

 
 
function h2bpb_sanitize( $input ){

	/* If data is not array, return. */
	if( !is_array( $input ) ){
		return null;
	}

	/* Output var */
	$output = array();

	/* Loop the data submitted */
	foreach( $input as $row_order => $row_data ){

		/* Only if row type is set */
		if( isset( $row_data['type'] ) && $row_data['type'] ){

			/* Get type of row ("col-1" or "col-2") */
			$row_type = esc_attr( $row_data['type'] );

			/* Row with 1 Column */
			if( 'col-0' == $row_type ){

				/* Sanitize value for "content" field. */
				$output[$row_order]['method'] = wp_kses_post( $row_data['method'] );
				$output[$row_order]['content-intro'] = wp_kses_post( $row_data['content-intro'] );
				$output[$row_order]['type'] = $row_type;
			}
			
			/* Row with 1 Column */
			if( 'col-1' == $row_type ){

				/* Sanitize value for "content" field. */
				$output[$row_order]['content-featured-img'] = wp_kses_post( $row_data['content-featured-img'] );
				$output[$row_order]['content-0'] = wp_kses_post( $row_data['content-0'] );
				$output[$row_order]['content'] = wp_kses_post( $row_data['content'] );
				$output[$row_order]['type'] = $row_type;
			}

			/* Row with 2 Columns */
			elseif( 'col-2' == $row_type ){

				/* Sanitize value for "content-1" */
				$output[$row_order]['content-1'] = wp_kses_post( $row_data['content-1'] );
				$output[$row_order]['type'] = $row_type;
			}
		}
	}

	return $output;
}


/**
 * Enable Default Content Filter
 * @since 1.0.0
 */
function h2bpb_default_content_filter( $content ){
	if( $content ){
		global $wp_embed;
		$content = $wp_embed->run_shortcode( $content );
		$content = $wp_embed->autoembed( $content );
		$content = wptexturize( $content );
		$content = convert_smilies( $content );
		$content = convert_chars( $content );
		$content = wptexturize( $content );
		$content = do_shortcode( $content );
		$content = shortcode_unautop( $content );
		if( function_exists('wp_make_content_images_responsive') ) { /* WP 4.4+ */
			$content = wp_make_content_images_responsive( $content );
		}
		$content = wpautop( $content );
	}
	return $content;
}

