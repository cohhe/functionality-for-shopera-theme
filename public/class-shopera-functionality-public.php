<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    shopera_func
 * @subpackage shopera_func/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    shopera_func
 * @subpackage shopera_func/public
 * @author     Your Name <email@example.com>
 */
class shopera_func_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $shopera_func    The ID of this plugin.
	 */
	private $shopera_func;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $shopera_func       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $shopera_func, $version ) {

		$this->shopera_func = $shopera_func;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in shopera_func_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The shopera_func_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->shopera_func, plugin_dir_url( __FILE__ ) . 'css/shopera-functionality-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in shopera_func_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The shopera_func_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->shopera_func, plugin_dir_url( __FILE__ ) . 'js/shopera-functionality-public.js', array( 'jquery' ), $this->version, false );

	}

}
