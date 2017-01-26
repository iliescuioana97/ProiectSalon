<?php

/*
 * Class MP_Entrepreneur_Plugin_Services
 * 
 * add services section
 */

class MP_Entrepreneur_Plugin_Services_Front {

	public function __construct() {
		add_action( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'section_services', array( $this, 'get_html' ) );
	}

	/*
	 * Get default sidebar
	 */

	public function get_default_content() {
		$args = array(
			'before_name'   => '',
			'after_name'    => '',
			'before_widget' => '<div  class="widget mp_entrepreneur_widget_services">',
			'after_widget'  => '</div>',
		);
		wp_cache_delete( 'widget_text', 'widget' );
		$instance = array(
			'title'     => __( 'Hair Styling', 'mp-entrepreneur' ),
			'image_uri' => MP_ENTREPRENEUR_PLUGIN_PATH . 'images/services1.png',
			'text'      => '<table>
<thead><tr>
<th></th><th>' . __( 'Women', 'mp-entrepreneur' ) . '</th><th>' . __( 'Men', 'mp-entrepreneur' ) . '</th>
</tr></thead>
<tbody>
<tr><td>' . __( 'Stylist', 'mp-entrepreneur' ) . '</td><td>$80 </td><td>$70 </td></tr>
<tr><td>' . __( 'Senior Stylist', 'mp-entrepreneur' ) . '</td><td>$90 </td><td>$80 </td></tr>
<tr><td>' . __( 'Master Stylist', 'mp-entrepreneur' ) . '</td><td>$110</td><td>$100</td></tr>
<tr><td>' . __( 'Celebrity Stylist', 'mp-entrepreneur' ) . '</td><td>$130</td><td>$80</td></tr>
<tr><td>' . __( 'Wedding stylist', 'mp-entrepreneur' ) . '</td><td>$180</td><td>-</td></tr>
</tbody>
</table>'
		);

		wp_cache_delete( 'mp_entrepreneur_widget_services', 'widget' );
		the_widget( 'MP_Entrepreneur_Plugin_Widget_Services', $instance, $args );
		$instance = array(
			'title'     => __( 'Makeup', 'mp-entrepreneur' ),
			'text'      => __( '<table>
<thead><tr>
<th></th><th>' . __( 'Jnr', 'mp-entrepreneur' ) . '</th><th>' . __( 'Snr', 'mp-entrepreneur' ) . '</th>
</tr></thead>
<tbody>
<tr><td>' . __( 'False Lash Application', 'mp-entrepreneur' ) . '</td><td>$90 </td><td>$110 </td></tr>
<tr><td>' . __( 'Airbrush Makeup', 'mp-entrepreneur' ) . ' </td><td>$120 </td><td>$140 </td></tr>
<tr><td>' . __( 'Traditional Makeup', 'mp-entrepreneur' ) . '</td><td>$100</td><td>$120</td></tr>
<tr><td>' . __( 'Evening Makeup', 'mp-entrepreneur' ) . '</td><td>$180 </td><td>$200 </td></tr>
<tr><td>' . __( 'Bridal Makeup', 'mp-entrepreneur' ) . '</td><td>$200</td><td>$200</td></tr>
</tbody>
</table>', 'mp_entrepreneur' ),
			'image_uri' => MP_ENTREPRENEUR_PLUGIN_PATH . 'images/services2.png'
		);

		wp_cache_delete( 'mp_entrepreneur_widget_services', 'widget' );
		the_widget( 'MP_Entrepreneur_Plugin_Widget_Services', $instance, $args );
		$instance = array(
			'title'     => __( 'Colouring', 'mp-entrepreneur' ),
			'text'      => __( '<table>
<thead><tr>
<th></th><th>' . __( 'Women', 'mp-entrepreneur' ) . '</th><th>' . __( 'Men', 'mp-entrepreneur' ) . '</th>
</tr></thead>
<tbody>
<tr><td>' . __( 'Permanent, Demi Gloss', 'mp-entrepreneur' ) . '</td><td>from $80 </td><td>from $70 </td></tr>
<tr><td>' . __( 'Colour Correction', 'mp-entrepreneur' ) . '</td><td>from $90 </td><td>from $80  </td></tr>
<tr><td>' . __( 'Fashion Foiling', 'mp-entrepreneur' ) . '</td><td>from $70</td><td>from $60</td></tr>
<tr><td>' . __( 'Tint roots', 'mp-entrepreneur' ) . '</td><td>$70 </td><td>$60 </td></tr>
<tr><td>' . __( 'Tint and foils', 'mp-entrepreneur' ) . '</td><td>$100</td><td>$90</td></tr>
</tbody>
</table>', 'mp_entrepreneur' ),
			'image_uri' => MP_ENTREPRENEUR_PLUGIN_PATH . 'images/services3.png'
		);

		wp_cache_delete( 'mp_entrepreneur_widget_services', 'widget' );
		the_widget( 'MP_Entrepreneur_Plugin_Widget_Services', $instance, $args );
	}

	/*
	 * Get sidebar
	 */

	public function get_content() {
		/*
		* mp_entrepreneur_before_sidebar_services hook
		*
		* @hooked mp_entrepreneur_before_sidebar_services - 10
		*/
		do_action( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'before_sidebar_services' );
		?>
		<?php
		if ( is_active_sidebar( 'sidebar-services' ) ) :
			dynamic_sidebar( 'sidebar-services' );
		else:
			$this->get_default_content();
		endif;
		?>
		<div class="clearfix"></div>
		<?php
		/*
		 * mp_entrepreneur_after_sidebar_services hook
		 *
		 * @hooked mp_entrepreneur_after_sidebar_services - 10
		 */
		do_action( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'after_sidebar_services' );
	}

	/*
	* Get title
	*/

	public function get_title() { ?>
		<div class="section-header">
			<?php
			$mp_entrepreneur_services_title = esc_html( get_theme_mod( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'services_title' ) );
			if ( get_theme_mod( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'services_title', false ) === false ) :
				?>
				<h2 class="section-title"><?php _e( 'Services & Prices', 'mp-entrepreneur' ); ?></h2>
				<?php
			else:
				if ( ! empty( $mp_entrepreneur_services_title ) ):
					?>
					<h2 class="section-title"><?php echo $mp_entrepreneur_services_title; ?></h2>
					<?php
				endif;
			endif;
			?>
		</div>
		<?php
	}

	public function get_buttons() {
		$mp_entrepreneur_services_button_url   = esc_url( get_theme_mod( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'services_button_url', '#services' ) );
		$mp_entrepreneur_services_button_label = esc_html( get_theme_mod( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'services_button_label', __( 'book now', 'mp-entrepreneur' ) ) );
		?>
		<div class="section-buttons">
			<?php
			if ( ! empty( $mp_entrepreneur_services_button_label ) && ! empty( $mp_entrepreneur_services_button_url ) ):
				?>
				<a href="<?php echo $mp_entrepreneur_services_button_url; ?>"
				   title="<?php echo $mp_entrepreneur_services_button_label; ?>"
				   class="button button-size-large"><?php echo $mp_entrepreneur_services_button_label; ?></a>
				<?php
			endif;
			?>
		</div>
		<?php
	}

	public function get_html() {

		$services_bg = '';
		if ( get_theme_mod( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'services_section_bg', false ) === false ) :
			$services_bg = 'style="background-image:url(' . MP_ENTREPRENEUR_PLUGIN_PATH . 'images/bg_services.jpg)"';
		endif;
		?>
		<section id="services"
		         class="services-section default-section section-bg-wrapper" <?php echo $services_bg; ?> >
			<div class="section-bg">
				<div class="container">
					<div class="section-content">
						<?php
						$this->get_title();
						$this->get_content();
						$this->get_buttons();
						?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}

}

new MP_Entrepreneur_Plugin_Services_Front();