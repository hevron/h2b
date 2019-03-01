<?php
/**
 * Front End Output
 * @since 1.0.0
**/

/* Filter Content as early as possible, but after all WP code filter runs. */
add_filter( 'the_content', 'h2bpb_filter_content', 10.5 );

/**
 * Filter Content
 * @since 1.0.0
**/
function h2bpb_filter_content( $content ){

	/* In single page when H2B Post Builder template selected. */
	if( !is_admin() && is_singular('post') && 'templates/page-builder.php' == get_page_template_slug( get_the_ID() ) ){

		/* Add content with shortcode, autoembed, responsive image, etc. */
		$content = h2bpb_default_content_filter( h2bpb_get_content() );
	}

	/* Return content */
	return $content;
}

/**
 * H2B Post Builder Content Output
 * This need to be use in the loop.
 * @since 1.0.0
**/
function h2bpb_get_content(){

	/* Get saved rows data and sanitize it */
	$row_datas = h2bpb_sanitize( get_post_meta( get_the_ID(), 'h2bpb', true ) );

	/* return if no rows data */
	if( !$row_datas ){
		return '';
	}

	/* Content */
	$content = '';
	
	
	/* Loop for each rows */
	foreach( $row_datas as $order => $row_data ){
		$order = intval( $order );

		/* === Row with 1 column === */
		/* === Row with 2 columns === */
		if( 'col-0' == $row_data['type'] ){
			
			$method_opt = $row_data['method'];
			
			$content .= '<div class="h2bpb-row h2bpb-row-' . $order . ' h2bpb-col-1 intro">' . "\r\n";
			$content .= '<div class="row-content-intro">' . "\r\n\r\n";
			$content .= $row_data['content-intro'] . "\r\n\r\n";
			$content .= '</div>' . "\r\n";
			$content .= '</div>' . "\r\n\r\n";
		}
		elseif( 'col-1' == $row_data['type'] ){
			$content .= '<div class="h2bpb-row h2bpb-row-' . $order . ' h2bpb-col-1 persist-area">' . "\r\n";
			
			$content .= '<div class="row-t-header">';
			
			$content .= '<div class="row-content-title persist-header">';
			$content .= '<span class="opt-block">';
			$content .= '<label class="method-opt-label">';
			$content .= $method_opt;
			$content .= '</label>';
			$content .= '<span class="method-row-content-order">';
			$content .= $order;
			$content .= '</span>';
			$content .= '</span>';
			$content .= $row_data['content-0'];
			$content .= '</div>' . "\r\n";
			
			if (!empty($row_data['content-featured-img'])) {
				$content .= '<div class="row-content-image">';
				$content .= ' <img src=' . $row_data['content-featured-img'] . ' alt="Featured Image"> ';
				$content .= '</div>' . "\r\n";
			}
			
			$content .= '</div>' . "\r\n";
			
			$content .= '<div class="row-content">' . "\r\n\r\n";
			$content .= $row_data['content'] . "\r\n\r\n";
			$content .= '</div>' . "\r\n";
			
			$content .= '</div>' . "\r\n\r\n";
		}
		/* === Row with 2 columns === */
		elseif( 'col-2' == $row_data['type'] ){
			$content .= '<div class="h2bpb-row h2bpb-row-' . $order . ' h2bpb-col-1">' . "\r\n";
			$content .= '<div class="row-content-1">' . "\r\n\r\n";
			$content .= $row_data['content-1'] . "\r\n\r\n";
			$content .= '</div>' . "\r\n";
			$content .= '</div>' . "\r\n\r\n";
		}
	}
	return $content;
}


/* === FRONT-END SCRIPTS === */

/* Enqueue Script */
add_action( 'wp_enqueue_scripts', 'h2b_pbbase_front_end_scripts' );

/**
 * Admin Scripts
 * @since 1.0.0
 */
function h2b_pbbase_front_end_scripts(){

	/* In a page using H2B Post Builder */
	if( is_singular('post') && ( 'templates/page-builder.php' == get_page_template_slug( get_queried_object_id() ) ) ){
		
		/* Load Editor/H2B Post Builder Toggle Script */
		wp_enqueue_script( 'h2b-main-how', H2B_PBBASE_URI . 'assets/js/main-how.js', array( 'jquery' ), H2B_PBBASE_VERSION );
		
		/* Enqueue CSS & JS For H2B Post Builder */
		wp_enqueue_style( 'h2b-page-builder', H2B_PBBASE_URI. 'assets/css/page-builder.css', array(), H2B_PBBASE_VERSION );
	}
}
