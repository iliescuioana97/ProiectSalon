<?php

class MP_Entrepreneur_Plugin_Portfolio_Meta {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ), 10, 3 );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
		$post_types = array( 'portfolio' );     //limit meta box to certain post types
		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'portfolio_meta_box_sub_title'
				, __( 'Subtitle', 'mp-entrepreneur' )
				, array( $this, 'render_meta_box_sub_title_portfolio' )
				, $post_type
				, 'advanced'
				, 'high'
			);
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id, $post, $update ) {
		
		if ( 'portfolio' != $post->post_type ) {
			return;
		}

		/*
		 * We need to verify this came from the our screen and with proper sub_titleization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['entrepreneur_inner_custom_box_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['entrepreneur_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'entrepreneur_inner_custom_box' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		//     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, its safe for us to save the data now. */


		$mydata = sanitize_text_field( $_POST['portfolio_sub_title'] );

		// Update the meta field.
		update_post_meta( $post_id, '_portfolio_sub_title', $mydata );

	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_sub_title_portfolio( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'entrepreneur_inner_custom_box', 'entrepreneur_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$portfolioText = get_post_meta( $post->ID, '_portfolio_sub_title', true );

		// Display the form, using the current value.
		echo '<table class="form-table"><tbody><tr><td style="padding-left:0; padding-right:0;"><input  type="text" id="portfolio_sub_title" name="portfolio_sub_title" class="large-text" value="' . esc_html( $portfolioText ) . '"></td></tr></tbody></table>';
	}


}

new MP_Entrepreneur_Plugin_Portfolio_Meta();
