<?php

/*
 * Class MP_Entrepreneur_Plugin_Customizer
 *
 * add actions for default widgets if footer
 */

class MP_Entrepreneur_Plugin_Customizer {

	private $prefix;

	public function __construct() {
		$this->prefix = 'mp_entrepreneur';
		//Handles the theme's theme customizer functionality.
		add_action( 'customize_register', array( $this, 'customize_register' ) );
	}

	/**
	 * Get prefix.
	 *
	 * @access public
	 * @return sting
	 */
	private function get_prefix() {
		return $this->prefix . '_';
	}

	/**
	 * Sets up the theme customizer sections, controls, and settings.
	 *
	 * @access public
	 *
	 * @param  object $wp_customize
	 *
	 * @return void
	 */
	public function customize_register( $wp_customize ) {
		include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . '/customiser/customise-classes.php';
		include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . '/customiser/webfonts.php';
		$list_fonts            = mp_entrepreneur_plugin_get_fonts();
		$list_all_font_weights = $this->get_list_all_font_weights();
		$list_all_font_size    = $this->get_list_all_font_size();

		$wp_customize->add_setting(
			$this->get_prefix() . 'footer_logo', array(
				'default'           => MP_ENTREPRENEUR_PLUGIN_PATH . 'images/footer_logo.png',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize, $this->get_prefix() . 'footer_logo', array(
					'label'    => esc_html__( 'Footer Logo', 'mp-entrepreneur' ),
					'section'  => $this->get_prefix() . 'logo_section',
					'settings' => $this->get_prefix() . 'footer_logo',
					'priority' => 11,
				)
			)
		);
		$wp_customize->add_section(
			$this->get_prefix() . 'font_section', array(
				'title'      => esc_html__( 'Fonts', 'mp-entrepreneur' ),
				'priority'   => 40,
				'capability' => 'edit_theme_options'
			)
		);
		$wp_customize->add_setting( $this->get_prefix() . 'title_font_family', array(
			'default'           => 'Ubuntu',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_control( $this->get_prefix() . 'title_font_family', array(
			'type'     => 'select',
			'label'    => __( 'Site Title Font Family', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'font_section',
			'priority' => 11,
			'choices'  => $list_fonts
		) );
		$wp_customize->add_setting( $this->get_prefix() . 'title_font_weight', array(
			'default'           => '700',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control( $this->get_prefix() . 'title_font_weight', array(
			'type'     => 'select',
			'label'    => __( 'Site Title Font Weight', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'font_section',
			'priority' => 12,
			'choices'  => $list_all_font_weights
		) );
		$wp_customize->add_setting( $this->get_prefix() . 'title_font_size', array(
			'default'           => '2.000em',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control( $this->get_prefix() . 'title_font_size', array(
			'type'     => 'select',
			'label'    => __( 'Site Title Font Size', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'font_section',
			'priority' => 13,
			'choices'  => $list_all_font_size
		) );
		$wp_customize->add_setting( $this->get_prefix() . 'tagline_font', array(
			'default'           => 0,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize, $this->get_prefix() . 'tagline_font', array(
				'label'    => esc_html__( 'Make Tagline font family same as Title', 'mp-entrepreneur' ),
				'section'  => $this->get_prefix() . 'font_section',
				'settings' => $this->get_prefix() . 'tagline_font',
				'type'     => 'checkbox',
				'priority' => 14,
			) )
		);
		/*
		 *
		 */
		$wp_customize->add_setting( $this->get_prefix() . 'text_font_family', array(
			'default'           => 'Ubuntu',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control( $this->get_prefix() . 'text_font_family', array(
			'type'     => 'select',
			'label'    => __( 'Site Font Family', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'font_section',
			'priority' => 14,
			'choices'  => $list_fonts
		) );
		$wp_customize->add_setting( $this->get_prefix() . 'text_font_weight', array(
			'default'           => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control( $this->get_prefix() . 'text_font_weight', array(
			'type'     => 'select',
			'label'    => __( 'Site Font Weight', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'font_section',
			'priority' => 15,
			'choices'  => $list_all_font_weights
		) );
		$wp_customize->add_setting( $this->get_prefix() . 'text_font_size', array(
			'default'           => '1em',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control( $this->get_prefix() . 'text_font_size', array(
			'type'     => 'select',
			'label'    => __( 'Site Font Size', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'font_section',
			'priority' => 16,
			'choices'  => $list_all_font_size
		) );
		/*
		* Add the 'services section'.
		*/
		$wp_customize->add_section(
			$this->get_prefix() . 'services_section', array(
				'title'       => __( 'Services Section', 'mp-entrepreneur' ),
				'priority'    => 85,
				'capability'  => 'edit_theme_options',
				'description' => __( '<i>Fill in this section by adding "Entrepreneur - Services & Prices" widgets to "Customize > Widgets > Services & Prices section"</i><hr/', 'mp-entrepreneur' )
			)
		);
		/*
		 * Add the 'Hide services section?' setting.
		 */
		$wp_customize->add_setting( $this->get_prefix() . 'services_show', array(
			'default'           => 0,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );
		/*
		 *  Add the upload control for the 'services section' setting.
		 */
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize, $this->get_prefix() . 'services_show', array(
				'label'    => esc_html__( 'Hide this section', 'mp-entrepreneur' ),
				'section'  => $this->get_prefix() . 'services_section',
				'settings' => $this->get_prefix() . 'services_show',
				'type'     => 'checkbox',
				'priority' => 1,
			) )
		);
		/*
				 * Add the 'services' setting.
				 */
		$wp_customize->add_setting( $this->get_prefix() . 'services_title', array(
			'sanitize_callback' => array( $this, 'sanitize_text' ),
			'default'           => __( 'Services & Prices', 'mp-entrepreneur' ),
			'capability'        => 'edit_theme_options',
			'transport'         => 'postMessage'
		) );
		/*
		 * Add the upload control for the 'services' setting.
		 */
		$wp_customize->add_control( $this->get_prefix() . 'services_title', array(
			'label'    => __( 'Title', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'services_section',
			'settings' => $this->get_prefix() . 'services_title',
			'priority' => 2
		) );
		/*
		 * Add the 'services brand button label' setting.
		 */
		$wp_customize->add_setting( $this->get_prefix() . 'services_button_label', array(
			'sanitize_callback' => array( $this, 'sanitize_text' ),
			'default'           => __( 'book now', 'mp-entrepreneur' ),
			'capability'        => 'edit_theme_options',
			'transport'         => 'postMessage'
		) );
		/*
		 * Add the upload control for the ' services button label' setting.
		 */
		$wp_customize->add_control( $this->get_prefix() . 'services_button_label', array(
			'label'    => __( 'Button label', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'services_section',
			'settings' => $this->get_prefix() . 'services_button_label',
			'priority' => 4
		) );
		/*
		 * Add the ' services button url' setting.
		 */
		$wp_customize->add_setting( $this->get_prefix() . 'services_button_url', array(
			'sanitize_callback' => array( $this, 'sanitize_text' ),
			'default'           => '#',
			'capability'        => 'edit_theme_options',
			'transport'         => 'postMessage'
		) );
		/*
		 * Add the upload control for the ' services button url' setting.
		 */
		$wp_customize->add_control( $this->get_prefix() . 'services_button_url', array(
			'label'    => __( 'Button url', 'mp_entrepreneur' ),
			'section'  => $this->get_prefix() . 'services_section',
			'settings' => $this->get_prefix() . 'services_button_url',
			'priority' => 5
		) );
		/*
				 * Add the 'services section bg' upload setting.
				 */
		$wp_customize->add_setting(
			$this->get_prefix() . 'services_section_bg', array(
				'default'           => MP_ENTREPRENEUR_PLUGIN_PATH . 'images/bg_services.jpg',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		/*
		 * Add the upload control for the 'services section bg' setting.
		 */
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize, $this->get_prefix() . 'services_section_bg', array(
					'label'    => esc_html__( 'Background image', 'mp-entrepreneur' ),
					'section'  => $this->get_prefix() . 'services_section',
					'settings' => $this->get_prefix() . 'services_section_bg',
					'priority' => 7
				)
			)
		);
		/*
		* Add the 'services section position' setting.
		*/
		$wp_customize->add_setting( $this->get_prefix() . 'services_position', array(
			'default'           => 20,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'sanitize_position' )
		) );
		/*
		 * Add the upload control for the  'services section position' setting.
		 */
		$wp_customize->add_control( $this->get_prefix() . 'services_position', array(
			'label'    => __( 'Section position', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'services_section',
			'settings' => $this->get_prefix() . 'services_position',
			'priority' => 30
		) );
		/*
			 * Add the 'portfolio section'.
			 */
		$wp_customize->add_section(
			$this->get_prefix() . 'portfolio_section', array(
				'title'       => __( 'Gallery Section', 'mp-entrepreneur' ),
				'priority'    => 86,
				'capability'  => 'edit_theme_options',
				'description' => __( '<i>Go to "Dashboard > Gallery" and add posts to fill this section</i><hr/', 'mp-entrepreneur' )
			)
		);
		/*
		 * Add the 'Hide portfolio section?' setting.
		 */
		$wp_customize->add_setting( $this->get_prefix() . 'portfolio_show', array(
			'default'           => 0,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );
		/*
		 *  Add the upload control for the 'portfolio section' setting.
		 */
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize, $this->get_prefix() . 'portfolio_show', array(
				'label'    => esc_html__( 'Hide this section', 'mp-entrepreneur' ),
				'section'  => $this->get_prefix() . 'portfolio_section',
				'settings' => $this->get_prefix() . 'portfolio_show',
				'type'     => 'checkbox',
				'priority' => 1,
			) )
		);
		/*
				 * Add the 'portfolio' setting.
				 */
		$wp_customize->add_setting( $this->get_prefix() . 'portfolio_title', array(
			'sanitize_callback' => array( $this, 'sanitize_text' ),
			'default'           => __( 'Gallery', 'mp-entrepreneur' ),
			'capability'        => 'edit_theme_options',
			'transport'         => 'postMessage'
		) );
		/*
		 * Add the upload control for the 'portfolio' setting.
		 */
		$wp_customize->add_control( $this->get_prefix() . 'portfolio_title', array(
			'label'    => __( 'Title', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'portfolio_section',
			'settings' => $this->get_prefix() . 'portfolio_title',
			'priority' => 2
		) );

		/*
		* Add the 'portfolio section position' setting.
		*/
		$wp_customize->add_setting( $this->get_prefix() . 'portfolio_position', array(
			'default'           => 30,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'sanitize_position' )
		) );
		/*
		 * Add the upload control for the  'portfolio section position' setting.
		 */
		$wp_customize->add_control( $this->get_prefix() . 'portfolio_position', array(
			'label'    => __( 'Section position', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'portfolio_section',
			'settings' => $this->get_prefix() . 'portfolio_position',
			'priority' => 30
		) );
		/*
					 * Add the 'testimonials section'.
					 */
		$wp_customize->add_section(
			$this->get_prefix() . 'testimonials_section', array(
				'title'       => __( 'Testimonials Section', 'mp-entrepreneur' ),
				'priority'    => 88,
				'capability'  => 'edit_theme_options',
				'description' => __( '<i>Go to "Dashboard > Testimonials" and add posts to fill this section</i><hr/', 'mp-entrepreneur' )
			)
		);
		/*
		 * Add the 'Hide testimonials section?' setting.
		 */
		$wp_customize->add_setting( $this->get_prefix() . 'testimonials_show', array(
			'default'           => 0,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );
		/*
		 *  Add the upload control for the 'testimonials section' setting.
		 */
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize, $this->get_prefix() . 'testimonials_show', array(
				'label'    => esc_html__( 'Hide this section', 'mp-entrepreneur' ),
				'section'  => $this->get_prefix() . 'testimonials_section',
				'settings' => $this->get_prefix() . 'testimonials_show',
				'type'     => 'checkbox',
				'priority' => 1,
			) )
		);
		/*
	     * Add the 'testimonials section bg' upload setting.
	     */
		$wp_customize->add_setting(
			$this->get_prefix() . 'testimonials_section_bg', array(
				'default'           => MP_ENTREPRENEUR_PLUGIN_PATH . 'images/bg_testimonials.jpg',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		/*
		 * Add the upload control for the 'testimonials section bg' setting.
		 */
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize, $this->get_prefix() . 'testimonials_section_bg', array(
					'label'    => esc_html__( 'Background image', 'mp-entrepreneur' ),
					'section'  => $this->get_prefix() . 'testimonials_section',
					'settings' => $this->get_prefix() . 'testimonials_section_bg',
					'priority' => 7
				)
			)
		);
		/*
		* Add the 'testimonials section position' setting.
		*/
		$wp_customize->add_setting( $this->get_prefix() . 'testimonials_position', array(
			'default'           => 40,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'sanitize_position' )
		) );
		/*
		 * Add the upload control for the  'testimonials section position' setting.
		 */
		$wp_customize->add_control( $this->get_prefix() . 'testimonials_position', array(
			'label'    => __( 'Section position', 'mp-entrepreneur' ),
			'section'  => $this->get_prefix() . 'testimonials_section',
			'settings' => $this->get_prefix() . 'testimonials_position',
			'priority' => 30
		) );
	}

	/**
	 * Sanitize text
	 *
	 * @access public
	 * @return sanitized output
	 */
	function sanitize_text( $txt ) {
		return wp_kses_post( force_balance_tags( $txt ) );
	}

	/*
	* Sanitize function for select
	*/

	function sanitize_select( $input, $setting ) {
		global $wp_customize;

		$control = $wp_customize->get_control( $setting->id );

		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}

	/*
	 * Sanitize function for all content
	 */

	function sanitize_text_all( $txt ) {
		return force_balance_tags( $txt );
	}

	/*
	 * Get array of all font weights
	 */

	function get_list_all_font_weights() {
		return array(
			'100'       => __( 'Ultra Light', 'mp-entrepreneur' ),
			'100italic' => __( 'Ultra Light Italic', 'mp-entrepreneur' ),
			'200'       => __( 'Light', 'mp-entrepreneur' ),
			'200italic' => __( 'Light Italic', 'mp-entrepreneur' ),
			'300'       => __( 'Book', 'mp-entrepreneur' ),
			'300italic' => __( 'Book Italic', 'mp-entrepreneur' ),
			'400'       => __( 'Regular', 'mp-entrepreneur' ),
			'400italic' => __( 'Regular Italic', 'mp-entrepreneur' ),
			'500'       => __( 'Medium', 'mp-entrepreneur' ),
			'500italic' => __( 'Medium Italic', 'mp-entrepreneur' ),
			'600'       => __( 'Semi-Bold', 'mp-entrepreneur' ),
			'600italic' => __( 'Semi-Bold Italic', 'mp-entrepreneur' ),
			'700'       => __( 'Bold', 'mp-entrepreneur' ),
			'700italic' => __( 'Bold Italic', 'mp-entrepreneur' ),
			'800'       => __( 'Extra Bold', 'mp-entrepreneur' ),
			'800italic' => __( 'Extra Bold Italic', 'mp-entrepreneur' ),
			'900'       => __( 'Ultra Bold', 'mp-entrepreneur' ),
			'900italic' => __( 'Ultra Bold Italic', 'mp-entrepreneur' )
		);
	}

	/*
	 * Get array of all font size
	 */

	function get_list_all_font_size() {
		return array(
			'0.875em' => '14px',
			'0.938em' => '15px',
			'1em'     => '16px',
			'1.125em' => '18px',
			'1.250em' => '20px',
			'1.375em' => '22px',
			'1.500em' => '24px',
			'1.625em' => '26px',
			'1.750em' => '28px',
			'1.875em' => '30px',
			'2.000em' => '32px',
			'2.125em' => '34px',
			'2.250em' => '36px',
			'2.375em' => '38px',
			'2.500em' => '40px',
			'2.625em' => '42px',
			'2.750em' => '44px',
			'3.000em' => '48px',
			'3.125em' => '50px',
			'3.250em' => '52px',
			'3.375em' => '54px',
			'3.500em' => '56px',
			'3.625em' => '58px',
			'3.750em' => '60px',
			'3.875em' => '62px',
			'4.000em' => '64px',
			'4.125em' => '66px',
			'4.250em' => '68px',
			'4.375em' => '70px',
			'4.500em' => '72px',
			'4.625em' => '74px',
			'4.750em' => '76px',
			'4.875em' => '78px',
			'5.000em' => '80px',
			'5.125em' => '82px',
			'5.250em' => '84px',
			'5.375em' => '86px',
			'5.500em' => '88px',
			'5.625em' => '90px',
			'5.750em' => '92px',
			'5.875em' => '94px',
			'6.000em' => '96px',
			'6.125em' => '98px'
		);
	}

	/**
	 * Sanitize checkbox
	 *
	 * @access public
	 * @return sanitized output
	 */
	function sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * Sanitize position
	 *
	 * @access public
	 * @return sanitized output
	 */
	function sanitize_position( $str ) {
		if ( $this->is_positive_integer( $str ) ) {
			return intval( $str );
		}
	}

	/**
	 * Sanitize is positive integer
	 *
	 * @access public
	 * @return sanitized output
	 */
	function is_positive_integer( $str ) {
		return ( is_numeric( $str ) && $str > 0 && $str == round( $str ) );
	}
}

new MP_Entrepreneur_Plugin_Customizer();

