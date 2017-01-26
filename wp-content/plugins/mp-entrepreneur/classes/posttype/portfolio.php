<?php

class MP_Entrepreneur_Plugin_Portfolio {
	public function __construct() {
		add_action( 'init', array( $this, 'portfolio_register' ) );
	}

	function portfolio_register() {
		$this->categories_register();
		flush_rewrite_rules( true );
		$args = array(
			'label'           => __( 'Gallery', 'mp-entrepreneur' ),
			'singular_label'  => __( 'Gallery', 'mp-entrepreneur' ),
			'public'          => true,
			'show_ui'         => true,
			'capability_type' => 'post',
			'hierarchical'    => false,
			'rewrite'         => true,
			'supports'        => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'portfolio', $args );
	}

	public function categories_register() {
		$labels_cat = array(
			'name'                       => _x( 'Categories', 'taxonomy general name', 'mp-entrepreneur' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name', 'mp-entrepreneur' ),
			'search_items'               => __( 'Search Categories', 'mp-entrepreneur' ),
			'popular_items'              => __( 'Popular Categories', 'mp-entrepreneur' ),
			'all_items'                  => __( 'All Categories', 'mp-entrepreneur' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Category', 'mp-entrepreneur' ),
			'update_item'                => __( 'Update Category', 'mp-entrepreneur' ),
			'add_new_item'               => __( 'Add New Category', 'mp-entrepreneur' ),
			'new_item_name'              => __( 'New Category Name', 'mp-entrepreneur' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'mp-entrepreneur' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'mp-entrepreneur' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories', 'mp-entrepreneur' ),
			'not_found'                  => __( 'No categories found.', 'mp-entrepreneur' ),
			'menu_name'                  => __( 'Categories', 'mp-entrepreneur' ),
		);

		$args_cat = array(
			'hierarchical'          => false,
			'labels'                => $labels_cat,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => true,
		);

		register_taxonomy( 'categories_portfolio', 'portfolio', $args_cat );
	}

}

new MP_Entrepreneur_Plugin_Portfolio();