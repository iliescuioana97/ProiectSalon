<?php
/**
 * About widget class
 *
 */
require_once 'Default.php';

class MP_Entrepreneur_Plugin_Widget_About extends MP_Entrepreneur_Plugin_Widget_Default {

	public function __construct() {
		$this->setClassName( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'widget_about' );
		$this->setName( __( 'About Us', 'mp-entrepreneur' ) );
		$this->setDescription( __( 'About us', 'mp-entrepreneur' ) );
		$this->setIdSuffix( 'about' );
		parent::__construct();
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title           = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text            = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$logo            = empty( $instance['logo'] ) ? false : $instance['logo'];
		$facebook_url    = empty( $instance['facebook_url'] ) ? false : $instance['facebook_url'];
		$twitter_url     = empty( $instance['twitter_url'] ) ? false : $instance['twitter_url'];
		$linkedin_url    = empty( $instance['linkedin_url'] ) ? false : $instance['linkedin_url'];
		$google_plus_url = empty( $instance['google_plus_url'] ) ? false : $instance['google_plus_url'];
		$instagram_url   = empty( $instance['instagram_url'] ) ? false : $instance['instagram_url'];
		$pinterest_url   = empty( $instance['pinterest_url'] ) ? false : $instance['pinterest_url'];
		$tumblr_url      = empty( $instance['tumblr_url'] ) ? false : $instance['tumblr_url'];
		$youtube_url     = empty( $instance['youtube_url'] ) ? false : $instance['youtube_url'];
		$rss_url         = empty( $instance['rss_url'] ) ? false : $instance['rss_url'];
		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . esc_html( $title ) . $after_title;
		}

		?>
		<?php if ( $logo ): ?>
			<div class="site-logo ">
				<?php if ( get_theme_mod( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'footer_logo', false ) === false ) : ?>
					<div class="header-logo "><img
							src="<?php echo( MP_ENTREPRENEUR_PLUGIN_PATH . 'images/footer_logo.png' ); ?>"
							alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
				<?php else: ?>
					<?php if ( get_theme_mod( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'footer_logo' ) ) : ?>
						<div class="header-logo "><img
								src="<?php echo esc_url( get_theme_mod( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'footer_logo' ) ); ?>"
								alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
					<?php endif; ?>
				<?php endif; ?>
				<div class="site-description">
					<h3 class="site-title <?php if ( ! get_bloginfo( 'description' ) ) : ?>empty-tagline<?php endif; ?>"><?php bloginfo( 'name' ); ?></h3>
					<?php if ( get_bloginfo( 'description' ) ) : ?>
						<p class="site-tagline"><?php bloginfo( 'description' ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="site-about"><?php echo wp_kses_data( $text ); ?></div>
		<div class="site-socials">
			<?php
			if ( ! empty( $facebook_url ) ):
				echo '<a href="' . $facebook_url . '" title="Facebook"><i class="fa fa-facebook"></i></a>';
			endif;
			?>
			<?php
			if ( ! empty( $twitter_url ) ):
				echo '<a href="' . $twitter_url . '" title="Twitter"><i class="fa fa-twitter"></i></a>';
			endif;
			?>
			<?php
			if ( ! empty( $linkedin_url ) ):
				echo '<a href="' . $linkedin_url . '" title="Linkedin"><i class="fa fa-linkedin"></i></a>';
			endif;
			?>
			<?php
			if ( ! empty( $google_plus_url ) ):
				echo '<a href="' . $google_plus_url . '" title="Google+"><i class="fa fa-google-plus"></i></a>';
			endif;
			?>
			<?php
			if ( ! empty( $instagram_url ) ):
				echo '<a href="' . $instagram_url . '" title="Instagram"><i class="fa fa-instagram"></i></a>';
			endif;
			?>
			<?php
			if ( ! empty( $pinterest_url ) ):
				echo '<a href="' . $pinterest_url . '" title="Pinterest"><i class="fa fa-pinterest"></i></a>';
			endif;
			?><?php
			if ( ! empty( $tumblr_url ) ):
				echo '<a href="' . $tumblr_url . '" title="Tumblr"><i class="fa fa-tumblr"></i></a>';
			endif;
			?><?php
			if ( ! empty( $youtube_url ) ):
				echo '<a href="' . $youtube_url . '" title="Youtube"><i class="fa fa-youtube"></i></a>';
			endif;
			?>
			<?php
			if ( ! empty( $rss_url ) ):
				echo '<a href="' . $rss_url . '" title="Rss"><i class="fa fa-rss"></i></a>';
			endif;
			?>
		</div>
		<?php
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['logo'] = isset( $new_instance['logo'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
		} // wp_filter_post_kses() expects slashed
		$instance['facebook_url']    = esc_url( $new_instance['facebook_url'] );
		$instance['twitter_url']     = esc_url( $new_instance['twitter_url'] );
		$instance['linkedin_url']    = esc_url( $new_instance['linkedin_url'] );
		$instance['google_plus_url'] = esc_url( $new_instance['google_plus_url'] );
		$instance['instagram_url']   = esc_url( $new_instance['instagram_url'] );
		$instance['pinterest_url']   = esc_url( $new_instance['pinterest_url'] );
		$instance['tumblr_url']      = esc_url( $new_instance['tumblr_url'] );
		$instance['youtube_url']     = esc_url( $new_instance['youtube_url'] );
		$instance['rss_url']         = esc_url( $new_instance['rss_url'] );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'           => '',
			'text'            => '',
			'facebook_url'    => '',
			'twitter_url'     => '',
			'linkedin_url'    => '',
			'google_plus_url' => '',
			'instagram_url'   => '',
			'pinterest_url'   => '',
			'tumblr_url'      => '',
			'youtube_url'     => '',
			'rss_url'         => ''
		) );
		$title    = strip_tags( $instance['title'] );
		$text     = esc_textarea( $instance['text'] );

		$facebook_url    = esc_url( $instance['facebook_url'] );
		$twitter_url     = esc_url( $instance['twitter_url'] );
		$linkedin_url    = esc_url( $instance['linkedin_url'] );
		$google_plus_url = esc_url( $instance['google_plus_url'] );
		$instagram_url   = esc_url( $instance['instagram_url'] );
		$pinterest_url   = esc_url( $instance['pinterest_url'] );
		$tumblr_url      = esc_url( $instance['tumblr_url'] );
		$youtube_url     = esc_url( $instance['youtube_url'] );
		$rss_url         = esc_url( $instance['rss_url'] );
		?>
		<p><label
				for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>"
		          name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id( 'logo' ); ?>"
		          name="<?php echo $this->get_field_name( 'logo' ); ?>"
		          type="checkbox" <?php isset( $instance['logo'] ) ? 'checked' : ''; ?> />&nbsp;<label
				for="<?php echo $this->get_field_id( 'logo' ); ?>"><?php _e( 'Show logo', 'mp-entrepreneur' ); ?></label>
		</p>
		<p><label
				for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook link:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" type="text"
			       value="<?php echo esc_attr( $facebook_url ); ?>"/></p>
		<p><label
				for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php _e( 'Twitter link:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" type="text"
			       value="<?php echo esc_attr( $twitter_url ); ?>"/></p>
		<p><label
				for="<?php echo $this->get_field_id( 'linkedin_url' ); ?>"><?php _e( 'Linkedin link:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'linkedin_url' ); ?>" type="text"
			       value="<?php echo esc_attr( $linkedin_url ); ?>"/></p>
		<p><label
				for="<?php echo $this->get_field_id( 'google_plus_url' ); ?>"><?php _e( 'Google+ link:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'google_plus_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'google_plus_url' ); ?>" type="text"
			       value="<?php echo esc_attr( $google_plus_url ); ?>"/></p>
		<p><label
				for="<?php echo $this->get_field_id( 'instagram_url' ); ?>"><?php _e( 'Instagram link:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'instagram_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'instagram_url' ); ?>" type="text"
			       value="<?php echo esc_attr( $instagram_url ); ?>"/></p>
		<p><label
				for="<?php echo $this->get_field_id( 'pinterest_url' ); ?>"><?php _e( 'Pinterest link:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'pinterest_url' ); ?>" type="text"
			       value="<?php echo esc_attr( $pinterest_url ); ?>"/></p>
		<p><label
				for="<?php echo $this->get_field_id( 'tumblr_url' ); ?>"><?php _e( 'Tumblr link:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tumblr_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'tumblr_url' ); ?>" type="text"
			       value="<?php echo esc_attr( $tumblr_url ); ?>"/></p>
		<p><label
				for="<?php echo $this->get_field_id( 'youtube_url' ); ?>"><?php _e( 'Youtube link:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtube_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'youtube_url' ); ?>" type="text"
			       value="<?php echo esc_attr( $youtube_url ); ?>"/></p>
		<p><label
				for="<?php echo $this->get_field_id( 'rss_url' ); ?>"><?php _e( 'Rss link:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'rss_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'rss_url' ); ?>" type="text"
			       value="<?php echo esc_attr( $rss_url ); ?>"/></p>
		<?php
	}

}

add_action( 'widgets_init', create_function( '', 'return register_widget( "MP_Entrepreneur_Plugin_Widget_About" );' ) );
