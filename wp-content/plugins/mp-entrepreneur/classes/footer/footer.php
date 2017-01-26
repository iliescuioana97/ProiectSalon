<?php

/*
 * Class MP_Entrepreneur_Plugin_Footer
 *
 * add actions for default widgets if footer
 */

class MP_Entrepreneur_Plugin_Footer {

	private $args;
	private $instance;

	public function __construct() {
		$this->args     = array(
			'before_title' => '<h4 class="widget-title">',
			'after_title'  => '</h4>'
		);
		$this->instance = array(
			'text'            => __( 'The company provides top world natural products and high class treatments for over 3 years. We are sure that you deserve excellent service and deliver it with a great pleasure.', 'mp_entrepreneur' ),
			'facebook_url'    => '#',
			'twitter_url'     => '#',
			'linkedin_url'    => '#',
			'google_plus_url' => '#',
			'instagram_url'   => '#',
			'rss_url'         => '#',
			'logo'            => true
		);


		add_action( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'footer_default_widget_about', array(
			$this,
			'default_widget_about'
		) );

	}

	/*
	 * get dafault MP_Entrepreneur_Plugin_Widget_About
	 */

	public function default_widget_about() {
		wp_cache_delete( 'mp_entrepreneur_widget_about', 'widget' );
		the_widget( 'MP_Entrepreneur_Plugin_Widget_About', $this->instance, $this->args );
	}


}

new MP_Entrepreneur_Plugin_Footer();
