<?php
/*
 * Plugin Name: Entrepreneur Theme Engine
 * Description: Adds Gallery and Testimonials post types, theme wizard and page templates to Entrepreneur theme.
 * Version: 1.0.3
 * Author: MotoPress
 * Author URI: http://www.getmotopress.com/
 * License: GPLv2 or later
 * Text Domain: mp-entrepreneur
 * Domain Path: /languages
 */


if ( ! class_exists( 'MP_Entrepreneur_Plugin' ) ) :

	final class MP_Entrepreneur_Plugin {

		/**
		 * The single instance of the class.
		 */
		protected static $_instance = null;
		private $prefix;
		public $galleryPost;

		/**
		 * Main MP_Entrepreneur_Plugin Instance.
		 *
		 * Ensures only one instance of WooCommerce is loaded or can be loaded.
		 *
		 * @see MP_Entrepreneur_Plugin_Instance()
		 * @return MP_Entrepreneur_Plugin - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			$this->prefix = 'mp_entrepreneur';
			/*
			 *  Path to classes folder in Plugin
			 */
			defined( 'MP_ENTREPRENEUR_PLUGIN_CLASS_PATH' ) || define( 'MP_ENTREPRENEUR_PLUGIN_CLASS_PATH', plugin_dir_path( __FILE__ ) . 'classes/' );
			defined( 'MP_ENTREPRENEUR_PLUGIN_PATH' ) || define( 'MP_ENTREPRENEUR_PLUGIN_PATH', plugin_dir_url( __FILE__ ) );
			defined( 'MP_ENTREPRENEUR_PLUGIN_DIR_PATH' ) || define( 'MP_ENTREPRENEUR_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
			$this->admin_init();
			$this->include_files();
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		}

		/*
		 * Register  scripts
		 */

		public function register_scripts() {
			if ( is_page_template( 'template-front-page.php' ) ) {

				wp_enqueue_style( $this->get_prefix() . 'flexslider', MP_ENTREPRENEUR_PLUGIN_PATH . 'css/flexslider.min.css', array(), '2.5.0', 'all' );

				if ( wp_register_script( $this->get_prefix() . 'jquery.flexslider', MP_ENTREPRENEUR_PLUGIN_PATH . 'js/jquery.flexslider.min.js', array( 'jquery' ), '2.5.0', true ) ) {
					wp_enqueue_script( $this->get_prefix() . 'jquery.flexslider' );
				}
				if ( wp_register_script( $this->get_prefix() . 'front', MP_ENTREPRENEUR_PLUGIN_PATH . 'js/mp_entrepreneur_front.min.js', array(
					'jquery',
					$this->get_prefix() . 'jquery.flexslider'
				), '1.0.1', true ) ) {
					wp_enqueue_script( $this->get_prefix() . 'front' );
				}
			}
		}

		/**
		 * Load plugin textdomain.
		 *
		 * @access public
		 * @return void
		 */
		function load_plugin_textdomain() {
			load_plugin_textdomain( 'mp-entrepreneur', false, basename( dirname( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Get prefix.
		 *
		 * @access public
		 * @return sting
		 */
		public function get_prefix() {
			return $this->prefix . '_';
		}

		public function include_files() {
			/*include_files
             * Include testimonials
             */
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . 'posttype/testimonials.php';
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . 'metabox/testimonials.php';
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . 'sections/testimonials.php';
			/*
             * Include portfolio
             */
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . 'posttype/portfolio.php';
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . 'metabox/portfolio.php';
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . 'sections/portfolio.php';
			/*
			 * Include services
			 */
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . 'sections/services.php';
			/*
			 * Inclide customizer for sections
             */
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . 'customiser/customiser.php';
			new MP_Entrepreneur_Plugin_Customizer( $this->prefix );
			/*
			 * Inclide widgets registrator
             */
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . 'widget/Registrator.php';
			/*
			 * Inclide footer actions
             */
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . 'footer/footer.php';

		}

		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/*
			 * Admin init
			 */

		public function admin_init() {
			add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
		}

		/*
		 * Register admin scripts
		 */

		public function register_admin_scripts() {
			wp_enqueue_media();
			$dependency = array(
				'jquery'
			);
			if ( wp_register_script( $this->get_prefix() . 'plugin_widget', MP_ENTREPRENEUR_PLUGIN_PATH . 'js/widget.min.js', $dependency, '1.0', true ) ) {
				wp_enqueue_script( $this->get_prefix() . 'plugin_widget' );
			}
		}
	}

	/**
	 * Main instance of MP_Entrepreneur_Plugin_Instance.
	 *
	 * Returns the main instance of WC to prevent the need to use globals.
	 *
	 */
	function MP_Entrepreneur_Plugin_Instance() {
		return MP_Entrepreneur_Plugin::instance();
	}

// Global for backwards compatibility.
	$GLOBALS['MP_Entrepreneur_Plugin_Instance'] = MP_Entrepreneur_Plugin_Instance();
endif;

function meks_disable_srcset( $sources ) {
	return false;
}

add_filter( 'wp_calculate_image_srcset', 'meks_disable_srcset' );