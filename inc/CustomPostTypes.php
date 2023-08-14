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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class CustomPostTypes {

	private static $instance;

	private $text_domain;

	private $custom_post_types;

	private function __construct($text_domain) {
		$this->text_domain = $text_domain;
	}

	/**
     * Get the single instance of this class.
     *
     * @return CustomPostTypes The single instance of this class.
     */
    public static function get_instance($text_domain) {
        if (self::$instance === null) {
            self::$instance = new self($text_domain);
        }

        return self::$instance;
    }

	/**
	 * Helper function to initialize a general model for a custom post type.
	 * @param  string $key      The post type key.
	 * @param  string $singular Singular name of the post type.
	 * @param  string $plural   Plural name of the post type.
	 * @param  array  $args     Post type args. See register_post_type() (or function body) for valid options.
	 * @param  array  $labels   Custom labels for new post type.
	 * @return null
	 */
	private function init_post_type($key, $singular, $plural, $args, $labels) {
		$uppercase_singular = ucfirst( $singular );
		$uppercase_plural = ucfirst( $plural );
		$lowercase_singular = strtolower( $singular );
		$lowercase_plural = strtolower( $plural );
		$labels = shortcode_atts( array(
				'name'                  => _x( $uppercase_plural, 'Post Type General Name', $this->text_domain ),
				'singular_name'         => _x( $uppercase_singular, 'Post Type Singular Name', $this->text_domain ),
				'menu_name'             => __( $uppercase_plural, $this->text_domain ),
				'name_admin_bar'        => __( $uppercase_singular, $this->text_domain ),
				'archives'              => __( $uppercase_singular . ' Archives', $this->text_domain ),
				'attributes'            => __( $uppercase_singular . ' Attributes', $this->text_domain ),
				'parent_item_colon'     => __( 'Parent ' . $uppercase_singular . ':', $this->text_domain ),
				'all_items'             => __( 'All ' . $uppercase_plural, $this->text_domain ),
				'add_new_item'          => __( 'Add New ' . $uppercase_singular, $this->text_domain ),
				'add_new'               => __( 'Add New', 'coneg' ),
				'new_item'              => __( 'New ' . $uppercase_singular, $this->text_domain ),
				'edit_item'             => __( 'Edit ' . $uppercase_singular, $this->text_domain ),
				'update_item'           => __( 'Update ' . $uppercase_singular, $this->text_domain ),
				'view_item'             => __( 'View ' . $uppercase_singular, $this->text_domain ),
				'view_items'            => __( 'View ' . $uppercase_plural, $this->text_domain ),
				'search_items'          => __( 'Search ' . $uppercase_singular, $this->text_domain ),
				'not_found'             => __( 'Not found', $this->text_domain ),
				'not_found_in_trash'    => __( 'Not found in Trash', $this->text_domain ),
				'featured_image'        => __( 'Featured Image', $this->text_domain ),
				'set_featured_image'    => __( 'Set featured image', $this->text_domain ),
				'remove_featured_image' => __( 'Remove featured image', $this->text_domain ),
				'use_featured_image'    => __( 'Use as featured image', $this->text_domain ),
				'insert_into_item'      => __( 'Insert into governor', $this->text_domain ),
				'uploaded_to_this_item' => __( 'Uploaded to this ' . $lowercase_singular, $this->text_domain ),
				'items_list'            => __( $uppercase_plural . ' list', $this->text_domain ),
				'items_list_navigation' => __( $uppercase_plural . ' list navigation', $this->text_domain ),
				'filter_items_list'     => __( 'Filter ' . $lowercase_plural . ' list', $this->text_domain )
		), $labels );
		$args = shortcode_atts( array(
				'label'               => __( $uppercase_singular, $this->text_domain ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-admin-pos',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => sanitize_title( $lowercase_plural ),
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
				'map_meta_cap'        => null,
				'show_in_rest'        => true,
				'rewrite'             => true
		), $args );
		register_post_type( $key, $args );
	}

	/**
	 * Helper function to create a custom post type.
	 * @param  string $key      The post type key.
	 * @param  string $singular Singular name of the post type.
	 * @param  string $plural   Plural name of the post type.
	 * @param  array  $args     Post type args. See register_post_type() (or function body) for valid options.
	 * @param  array  $labels   Custom labels for new post type.
	 * @return null
	 */
	public function add_post_type($key, $singular, $plural, $args) {
		/** 
		 * *Custom Post Type for Partners
		*/
		$this->custom_post_types[] = array(
			'key'      => $key,
			'singular' => $singular,
			'plural'   => $plural,
			'args'     => $args
		);
	}

	public function register_post_types() {
		foreach( $this->custom_post_types as $custom_post_type ) {
			$args = shortcode_atts( array(
				'key'      => 'custom_post_type',
				'singular' => __( 'Custom Post Type', 'wpbooks' ),
				'plural'   => __( 'Custom Post Types', 'wpbooks' ),
				'args'     => null,
				'labels'   => null,
			), $custom_post_type );
			$this->init_post_type( $args['key'], $args['singular'], $args['plural'], $args['args'], $args['labels'] );
		}
	}
}
