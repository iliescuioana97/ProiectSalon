<?php

class MP_Entrepreneur_Plugin_Testimonials {
	public function __construct() {
		add_action( 'init', array( $this, 'testimonials_register' ) );
	}

	function testimonials_register() {
		$args = array(
			'label'           => __( 'Testimonials', 'mp-entrepreneur' ),
			'singular_label'  => __( 'Testimonial', 'mp-entrepreneur' ),
			'public'          => true,
			'show_ui'         => true,
			'capability_type' => 'post',
			'hierarchical'    => false,
			'rewrite'         => true,
			'supports'        => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'testimonials', $args );
	}
}

new MP_Entrepreneur_Plugin_Testimonials();