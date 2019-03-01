<?php
/**
 * H2B Post Builder
 * - Register Page Template
 * - Add H2B Post Builder Control
 * - Save H2B Post Builder Data
 * - Admin Scripts
 * 
 * @since 1.0.0
 * @author David Chandra Purnama <david@genbumedia.com>
 * @copyright Copyright (c) 2016, Genbu Media
**/

/* === REGISTER PAGE TEMPLATE === */

/* Add page templates */
add_filter( 'theme_post_templates', 'h2b_pbbase_register_page_template' );

/**
 * Register Page Template: H2B Post Builder
 * @since 1.0.0
 */
function h2b_pbbase_register_page_template( $templates ){
	$templates['templates/page-builder.php'] = 'H2B Post Builder';
	return $templates;
}


/* === ADD H2B Post Builder CONTROL === */

/* Add H2B Post Builder form after editor */
add_action( 'edit_form_after_editor', 'h2b_pbbase_editor_callback', 10, 2 );

/**
 * H2B Post Builder Control
 * Added after Content Editor in Page Edit Screen.
 * @since 1.0.0
 */
function h2b_pbbase_editor_callback( $post ){
	if( 'post' !== $post->post_type ){
		return;
	}
?>
	<div id="h2b-page-builder">

		<?php
			/* Get saved rows data and sanitize it */
			$row_datas = h2bpb_sanitize( get_post_meta( $post->ID, 'h2bpb', true ) );
			
			//Loop through the $posts array IF it is an array.
			if(is_array($row_datas)){
				foreach( $row_datas as $order => $row_data ){
					/* === Row with 1 column === */
					if( 'col-0' == $row_data['type'] ){
						?>	
					
						<div class="h2bpb-row">
							<div class="h2bpb-row-title steps-opt">
								<div id="H2B_method_selector">
									This article has:
									
									<?php if($row_data['method'] == 'method'): ?>
										
										<input class="h2b-radio" name="h2bpb[0][method]" data-field="Add a Method" value="method" type="radio" checked> Multiple Methods <a class="ac_question methods"></a>
										<input class="h2b-radio" name="h2bpb[0][method]" data-field="Add a Part" value="part" type="radio" > Multiple Parts <a class="ac_question parts"></a>
									
									<?php endif; if($row_data['method'] == 'part'): ?>
										
										<input class="h2b-radio" name="h2bpb[0][method]" data-field="Add a Method" value="method" type="radio"> Multiple Methods <a class="ac_question methods"></a>
										<input class="h2b-radio" name="h2bpb[0][method]" data-field="Add a Part" value="part" type="radio" checked> Multiple Parts <a class="ac_question parts"></a>
									
									<?php endif; ?>
								</div>
							</div>
							<!-- .h2bpb-row-title -->
							<div class="h2bpb-row-title">
								<h4>Introduction</h4>
							</div><!-- .h2bpb-row-title -->
							<div class="h2bpb-row-fields">
								<?php
									$settings = array(
										'textarea_name' => 'h2bpb[0][content-intro]', 
										'editor_class' => 'h2bpb-row-intro',
										'editor_height' => 225,
									);
									$editor_id = 'content-intro';
									$content = $row_data['content-intro'];
									
									wp_editor( $content, $editor_id, $settings);
								?>
								<input class="h2bpb-row-input" type="hidden" name="h2bpb[0][type]" data-field="type" value="col-0">
							</div><!-- .h2bpb-row-fields -->

						</div><!-- .h2bpb-row.h2bpb-col-1 -->
						<?php
					}
				}
			}
			else{
				?>	
				
					<div class="h2bpb-row">
						<div class="h2bpb-row-title steps-opt">
							<div id="H2B_method_selector">
								This article has: 
								<input class="h2b-radio" name="h2bpb[0][method]" data-field="Add a Method" value="method" type="radio"> Multiple Methods <a class="ac_question methods"></a>
								<input class="h2b-radio" name="h2bpb[0][method]" data-field="Add a Part" value="part" type="radio" checked> Multiple Parts <a class="ac_question parts"></a>
							</div>
						</div>
						<div class="h2bpb-row-title">
							<h4>Introduction</h4>
						</div><!-- .h2bpb-row-title -->
						<div class="h2bpb-row-fields">
							<?php
								$settings = array(
									'textarea_name' => 'h2bpb[0][content-intro]', 
									'editor_class' => 'h2bpb-row-intro',
									'editor_height' => 225,
								);
								$editor_id = 'content-intro';
								$content = '';
								
								wp_editor( $content, $editor_id, $settings);
							?>

							<input class="h2bpb-row-input" type="hidden" name="h2bpb[0][type]" data-field="type" value="col-0">
						</div><!-- .h2bpb-row-fields -->

					</div><!-- .h2bpb-row.h2bpb-col-1 -->
				<?php
			}
			
		?>
		
		<div class="h2bpb-rows">
			<?php h2bpb_render_rows( $post ); // display saved rows ?>
		</div><!-- .h2bpb-rows -->

		<div class="h2bpb-actions">
			<a href="#" class="h2bpb-add-row button-primary button-large h2b-method-act" data-template="col-1">Add Steps</a>
			<a href="#" class="h2bpb-add-row button-primary button-large" data-template="col-2">Add Conclusion</a>
		</div><!-- .h2bpb-actions -->

		<div class="h2bpb-templates" style="display:none;">

			<?php /* == This is the 1 column row template == */ ?>
			<div class="h2bpb-row h2bpb-col-1">

				<div class="h2bpb-row-title no-intro">
					<span class="h2bpb-handle dashicons dashicons-sort"></span>
					<span class="h2bpb-row-title-text"><h4 class="h2b-radio-rst">Part</h4></span> <span class="h2bpb-order">0</span>
					<span class="h2bpb-remove dashicons dashicons-trash"></span>
				</div><!-- .h2bpb-row-title -->

				<div class="h2bpb-row-fields">
					<div class="">
					<div class="f-image">
						<label for="meta-image" class="prh2b-row-title">Custom Slider Image:</label>
						<input type="text" name="" class="meta-image h2bpb-row-input" data-field="content-featured-img" />
						<input type="button" class="button meta-image-button" value="Choose or Upload an Image" />
						<p><small class="hrpro-description">If you're planning to display this post/page in the featured slider, you can set a custom slider image here.<br> If you leave this field blank, the slider will pick the featured image assigned to the post/page.</small><p>
					</div>
					</div>
					<div class="">
						<input spellcheck="true" autocomplete="off" type="text" class="h2bpb-row-input step-title" name="" data-field="content-0" placeholder="Step title">
					</div>
					<textarea id="content-0" class="h2bpb-row-input wp-editor-tarea content-not-set" name="" data-field="content" placeholder="Add HTML here..."></textarea>
					<input class="h2bpb-row-input" type="hidden" name="" data-field="type" value="col-1">
				</div><!-- .h2bpb-row-fields -->

			</div><!-- .h2bpb-row.h2bpb-col-1 -->

			<?php /* == This is the 2 columns row template == */ ?>
			<div class="h2bpb-row h2bpb-col-2">

				<div class="h2bpb-row-title">
					<span class="h2bpb-handle dashicons dashicons-sort"></span>
					<span class="h2bpb-order">0</span>
					<span class="h2bpb-row-title-text"> Conclusion</span>
					<span class="h2bpb-remove dashicons dashicons-trash"></span>
				</div><!-- .h2bpb-row-title -->

				<div class="h2bpb-row-fields">
					<textarea class="h2bpb-row-input" name="" data-field="content-1" placeholder="1st column content here..."></textarea>
					<input class="h2bpb-row-input" type="hidden" name="" data-field="type" value="col-2">
				</div><!-- .h2bpb-row-fields -->

			</div><!-- .h2bpb-row.h2bpb-col-2 -->

		</div><!-- .h2bpb-templates -->

		<?php wp_nonce_field( "h2bpb_nonce_action", "h2bpb_nonce" ) ?>

	</div><!-- .h2b-page-builder -->
<?php
}


/* === SAVE H2B Post Builder DATA === */

/* Save post meta on the 'save_post' hook. */
add_action( 'save_post', 'h2b_pbbase_save_post', 10, 2 );

/**
 * Save H2B Post Builder Data When Saving Page
 * @since 1.0.0
 */
function h2b_pbbase_save_post( $post_id, $post ){

	/* Stripslashes Submitted Data */
	$request = stripslashes_deep( $_POST );

	/* Verify/validate */
	if ( ! isset( $request['h2bpb_nonce'] ) || ! wp_verify_nonce( $request['h2bpb_nonce'], 'h2bpb_nonce_action' ) ){
		return $post_id;
	}
	/* Do not save on autosave */
	if ( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	/* Check post type and user caps. */
	$post_type = get_post_type_object( $post->post_type );
	if ( 'post' != $post->post_type || !current_user_can( $post_type->cap->edit_post, $post_id ) ){
		return $post_id;
	}

	/* == Save, Delete, or Update H2B Post Builder Data == */

	/* Get (old) saved H2B Post Builder data */
	$saved_data = get_post_meta( $post_id, 'h2bpb', true );

	/* Get new submitted data and sanitize it. */
	$submitted_data = isset( $request['h2bpb'] ) ? h2bpb_sanitize( $request['h2bpb'] ) : null;

	/* New data submitted, No previous data, create it  */
	if ( $submitted_data && '' == $saved_data ){
		add_post_meta( $post_id, 'h2bpb', $submitted_data, true );
	}
	/* New data submitted, but it's different data than previously stored data, update it */
	elseif( $submitted_data && ( $submitted_data != $saved_data ) ){
		update_post_meta( $post_id, 'h2bpb', $submitted_data );
	}
	/* New data submitted is empty, but there's old data available, delete it. */
	elseif ( empty( $submitted_data ) && $saved_data ){
		delete_post_meta( $post_id, 'h2bpb' );
	}

	/* == Get Selected Page Template == */
	$page_template = isset( $request['page_template'] ) ? esc_attr( $request['page_template'] ) : null;

	/* == H2B Post Builder Template Selected, Save to Post Content == */
	if( 'templates/page-builder.php' == $page_template ){

		/* H2B Post Builder content without row/column wrapper */
		$pb_content = h2bpb_format_post_content_data( $submitted_data );

		/* Post Data To Save */
		$this_post = array(
			'ID'           => $post_id,
			'post_content' => sanitize_post_field( 'post_content', $pb_content, $post_id, 'db' ),
		);

		/**
		 * Prevent infinite loop.
		 * @link https://developer.wordpress.org/reference/functions/wp_update_post/
		 */
		remove_action( 'save_post', 'h2b_pbbase_save_post' );
		wp_update_post( $this_post );
		add_action( 'save_post', 'h2b_pbbase_save_post' );
	}

	/* == Always delete H2B Post Builder data if page template not selected == */
	else{
		delete_post_meta( $post_id, 'h2bpb' );
	}
}


/**
 * Format H2B Post Builder Content Without Wrapper Div.
 * This is added to post content.
 * @since 1.0.0
**/
function h2bpb_format_post_content_data( $row_datas ){

	/* return if no rows data */
	if( !$row_datas ){
		return '';
	}

	/* Output */
	$content = '';

	/* Loop for each rows */
	foreach( $row_datas as $order => $row_data ){
		$order = intval( $order );

		/* === Row with 1 column === */
		if( 'col-0' == $row_data['type'] ){
			$content .= $row_data['method'] . "\r\n\r\n";
			$content .= $row_data['content-intro'] . "\r\n\r\n";
		}
		/* === Row with 1 column === */
		elseif( 'col-1' == $row_data['type'] ){
			$content .= $row_data['content-featured-img'] . "\r\n\r\n";
			$content .= $row_data['content-0'] . "\r\n\r\n";
			$content .= $row_data['content'] . "\r\n\r\n";
		}
		/* === Row with 2 columns === */
		elseif( 'col-2' == $row_data['type'] ){
			$content .= $row_data['content-1'] . "\r\n\r\n";
		}
	}
	return $content;
}


/**
 * Render Saved Rows
 * @since 1.0.0
 */
function h2bpb_render_rows( $post ){

	/* Get saved rows data and sanitize it */
	$row_datas = h2bpb_sanitize( get_post_meta( $post->ID, 'h2bpb', true ) );

	/* Default Message */
	$default_message = 'Please add row to start!';

	/* return if no rows data */
	if( !$row_datas ){
		echo '<p class="h2bpb-rows-message">' . $default_message . '</p>';
		return;
	}
	/* Data available, hide default notice */
	else{
		echo '<p class="h2bpb-rows-message" style="display:none;">' . $default_message . '</p>';
	}

	/* Loop for each rows */
	foreach( $row_datas as $order => $row_data ){
		$order = intval( $order );

		/* === Row with 1 column === */
		if( 'col-1' == $row_data['type'] ){
			?>
			<div class="h2bpb-row h2bpb-col-1">

				<div class="h2bpb-row-title no-intro">
					<span class="h2bpb-handle dashicons dashicons-sort"></span>
					<span class="h2bpb-row-title-text"><h4 class="h2b-radio-rst">Part</h4></span> <span class="h2bpb-order"><?php echo $order; ?></span>
					<span class="h2bpb-remove dashicons dashicons-trash"></span>
				</div><!-- .h2bpb-row-title -->

				<div class="h2bpb-row-fields">
					<div class="f-image">
						<label for="meta-image" class="prh2b-row-title">Custom Slider Image:</label>
						<input type="text" id="meta-image-<?php echo $order; ?>" name="h2bpb[<?php echo $order; ?>][content-featured-img]" class="meta-image h2bpb-row-input" data-field="content-featured-img" value="<?php echo esc_html( $row_data['content-featured-img'] ); ?>"/>
						<input type="button" id="meta-image-button-<?php echo $order; ?>"  class="button meta-image-button" value="Choose or Upload an Image" />
						<p><small class="hrpro-description">If you're planning to display this post/page in the featured slider, you can set a custom slider image here.<br> If you leave this field blank, the slider will pick the featured image assigned to the post/page.</small></p>
					</div>
					<div class="">
						<input spellcheck="true" autocomplete="off" type="text" class="h2bpb-row-input step-title" name="h2bpb[<?php echo $order; ?>][content-0]" data-field="content-0" value="<?php echo esc_html( $row_data['content-0'] ); ?>" placeholder="Step title">
					</div>
					<textarea id="content-<?php echo $order; ?>" class="h2bpb-row-input wp-editor-tarea" name="h2bpb[<?php echo $order; ?>][content]" data-field="content" placeholder="Add HTML here..."><?php echo esc_textarea( $row_data['content'] ); ?></textarea>
					<input class="h2bpb-row-input" type="hidden" name="h2bpb[<?php echo $order; ?>][type]" data-field="type" value="col-1">
				</div><!-- .h2bpb-row-fields -->

			</div><!-- .h2bpb-row.h2bpb-col-1 -->
			<?php
		}
		/* === Row with 2 columns === */
		elseif( 'col-2' == $row_data['type'] ){
			?>
			<div class="h2bpb-row h2bpb-col-2">

				<div class="h2bpb-row-title">
					<span class="h2bpb-handle dashicons dashicons-sort"></span>
					<span class="h2bpb-order"><?php echo $order; ?></span>
					<span class="h2bpb-row-title-text">Conclusion</span>
					<span class="h2bpb-remove dashicons dashicons-trash"></span>
				</div><!-- .h2bpb-row-title -->

				<div class="h2bpb-row-fields">
					<textarea class="h2bpb-row-input" name="h2bpb[<?php echo $order; ?>][content-1]" data-field="content-1" placeholder="1st column content here..."><?php echo esc_textarea( $row_data['content-1'] ); ?></textarea>
					<input class="h2bpb-row-input" type="hidden" name="h2bpb[<?php echo $order; ?>][type]" data-field="type" value="col-2">
				</div><!-- .h2bpb-row-fields -->

			</div><!-- .h2bpb-row.h2bpb-col-2 -->
			<?php
		}
	}
}


/* === ADMIN SCRIPTS === */

/* Admin Script */
add_action( 'admin_enqueue_scripts', 'h2b_pbbase_admin_scripts' );

/**
 * Admin Scripts
 * @since 1.0.0
 */
function h2b_pbbase_admin_scripts( $hook_suffix ){
	global $post_type;

	/* In Page Edit Screen */
	if( 'post' == $post_type && in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ){

		/* Load Editor/H2B Post Builder Toggle Script */
		wp_enqueue_script( 'h2b-pbbase-admin-editor-toggle', H2B_PBBASE_URI . 'assets/js/admin-editor-toggle.js', array( 'jquery' ), H2B_PBBASE_VERSION );
		/* Enqueue CSS & JS For H2B Post Builder */
		wp_enqueue_style( 'h2b-pbbase-admin', H2B_PBBASE_URI. 'assets/css/admin-page-builder.css', array(), H2B_PBBASE_VERSION );
		
		wp_enqueue_script( 'h2b-pbbase-admin', H2B_PBBASE_URI. 'assets/js/admin-page-builder.js', array( 'jquery', 'jquery-ui-sortable' ), H2B_PBBASE_VERSION, true );
		wp_localize_script( 'h2b-pbbase-admin', 'meta_image',
            array(
                'title' => __( 'Choose or Upload an Image'),
                'button' => __( 'Use this image'),
            )
        );
        wp_enqueue_script( 'h2b-pbbase-admin' );
	}
}