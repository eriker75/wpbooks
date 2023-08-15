<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that inc attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://eribertmarquez.com
 * @since      1.0.0
 *
 * @package    WpBooks
 * @subpackage WpBooks/inc
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WpBooks
 * @subpackage WpBooks/inc
 * @author     Eribert Marquez <eriker1997@gmail.com>
 */
namespace Inc;

/**
 * The class responsible for defining internationalization functionality
 * of the plugin.
 */
use Inc\I18n;
/**
 * The class responsible for orchestrating the actions and filters of the
 * core plugin.
 */
use Inc\Loader;
/**
 * The class responsible for initialize neccessary wordpress theme supports
 */
use Inc\ThemeSupports;
/**
 * Add Theme custom post types
 */
use Inc\CustomPostTypes;
/**
 * Add Theme custom taxonomies
 */
use Inc\CustomTaxonomies;
/**
 * The responsible to manage admin wordpress logic
 */
use Inc\Admin\WpBooksAdmin;
/**
 * The responsible tomanage public wordpress logic
 */
use Inc\Public\WpBooksPublic;

class WpBooksMaster {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $theme_name    The string used to uniquely identify this plugin.
	 */
	protected $theme_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $text_domain;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		// Initialize global constants
		$this->version = defined('WP_BOOKS_VERSION') ? WP_BOOKS_VERSION : '1.0.0';
		$this->theme_name = defined('WP_BOOKS_THEME_NAME') ? WP_BOOKS_THEME_NAME : 'wpbooks';
		$this->text_domain = defined('WP_BOOKS_TEXT_DOMAIN') ? WP_BOOKS_TEXT_DOMAIN : 'wpbooks';

		// Initialize dependencies
		$this->load_dependencies();
		$this->add_theme_supports();
		$this->add_custom_cpts();
		$this->add_taxonomies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WpBooksLoader. Orchestrates the hooks of the plugin.
	 * - WpBooksi18n. Defines internationalization functionality.
	 * - WpBooksAdmin. Defines all hooks for the admin area.
	 * - WpBooksPublic. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		$this->loader = new Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WpBooks_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new I18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all theme supports related with the theme
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function add_theme_supports() {
		$supports = [
			'align-wide' => array(),
			'automatic-feed-links' => array(),
			'core-block-patterns' => array(),
			'custom-background' => array(),
			'custom-header' => array(),
			'custom-line-height' => array(),
			'custom-logo' => array(),
			'customize-selective-refresh-widgets' => array(),
			'custom-spacing' => array(),
			'custom-units' => array(),
			'editor-font-sizes' => array(),
			'editor-styles' => array(),
			'featured-content' => array(),
			'menus' => array(),
			'post-formats' => array(),
			'post-thumbnails' => array( 
									'post',
									'page',
									'review',
									//'author'// Instead of feature image we're gonna use a acf field 
									//'book', // Instead of feature image we're gonna use a acf field
								),
			'responsive-embeds' => array(),
			'title-tag' => array(),
			'wp-block-styles' => array(),
			'widgets' => array(),
			'widgets-block-editor' => array(),
		];
		$theme_supports = ThemeSupports::get_instance($supports);

		// Adding hooks to administration side of wordpress
		$this->loader->add_action( 'after_setup_theme', $theme_supports, 'add_supports' );
	}

	/**
	 * Register all custom post types related with the theme
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function add_custom_cpts() {
		// Custom post types instance generator
		$custom_post_types = CustomPostTypes::get_instance();
		// Adding hooks to administration side of wordpress
		$this->loader->add_action( 'init', $custom_post_types, 'register_all_post_types' , 10);
	}

	/**
	 * Register all custom taxonomies related with the theme
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function add_taxonomies() {
		// Custom taxonomy instance generator
		$custom_taxonomies = CustomTaxonomies::get_instance($this->get_text_domain());

		// Adding hooks to administration side of wordpress
		$this->loader->add_action( 'init', $custom_taxonomies, 'register_all_taxonomies' , 10);
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$theme_admin = new WpBooksAdmin( 
			$this->get_theme_name(), 
			$this->get_version(),
			$this->get_text_domain() 
		);
		// Adding hooks to administration side of wordpress
		$this->loader->add_action( 'admin_enqueue_scripts', $theme_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $theme_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new WpBooksPublic( 
			$this->get_theme_name(), 
			$this->get_version(),
			$this->get_text_domain(),
			$this->loader
		);
		// Adding hooks to public side of wordpress
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	
		$plugin_public->many_to_many_acf_relations();
		$plugin_public->register_acf_blocks();
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_theme_name() {
		return $this->theme_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WpBooks_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the text domain of theme.
	 *
	 * @since     1.0.0
	 * @return    string    The text domain verion.
	 */
	public function get_text_domain() {
		return $this->text_domain;
	}

}