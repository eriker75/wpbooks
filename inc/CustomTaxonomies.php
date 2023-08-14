<?php

namespace Inc;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class CustomTaxonomies {

    private static $instance;

    private $custom_taxonomies;

    private $text_domain;
    
    private function __construct($text_domain) {
        $this->text_domain = $text_domain;
    }

    /**
     * Get the single instance of this class.
     *
     * @return CustomTaxonomies The single instance of this class.
     */
    public static function get_instance($text_domain) {
        if (self::$instance === null) {
            self::$instance = new self($text_domain);
        }

        return self::$instance;
    }

    /**
	 * Generates labels for creating taxonomies.
	 * @param  string $singular  The singular name of the taxonomy.
	 * @param  string $plural    The plural name of the taxonomy.
	 * @param  array  $overrides Any labels that you wish to override.
	 * @return array             Key-Value array of taxonomy labels.\
	 */
	public function init_taxonomy( $singular, $plural, $overrides = array() ) {
		return shortcode_atts( array(
			'name'                       => _x( $plural, 'Taxonomy General Name', $this->text_domain ),
			'singular_name'              => _x( $singular, 'Taxonomy Singular Name', $this->text_domain ),
			'menu_name'                  => __( $plural, $this->text_domain ),
			'all_items'                  => __( 'All '. $plural, $this->text_domain ),
			'parent_item'                => __( 'Parent ' . $singular, $this->text_domain ),
			'parent_item_colon'          => __( 'Parent ' . $singular . ':', $this->text_domain ),
			'new_item_name'              => __( 'New ' . $singular . ' Name', $this->text_domain ),
			'add_new_item'               => __( 'Add New ' . $singular, $this->text_domain ),
			'edit_item'                  => __( 'Edit ' . $singular, $this->text_domain ),
			'update_item'                => __( 'Update ' . $singular, $this->text_domain ),
			'view_item'                  => __( 'View ' . $singular, $this->text_domain ),
			'separate_items_with_commas' => __( 'Separate ' . $plural . ' with commas', $this->text_domain ),
			'add_or_remove_items'        => __( 'Add or remove ' . $plural, $this->text_domain ),
			'choose_from_most_used'      => __( 'Choose from the most used', $this->text_domain ),
			'popular_items'              => __( 'Popular ' . $plural, $this->text_domain ),
			'search_items'               => __( 'Search ' . $plural, $this->text_domain ),
			'not_found'                  => __( 'Not Found', $this->text_domain ),
			'no_terms'                   => __( 'No ' . $plural, $this->text_domain ),
			'items_list'                 => __( $plural . ' list', $this->text_domain ),
			'items_list_navigation'      => __( $plural . ' list navigation', $this->text_domain ),
		), $overrides );
	}

    public function add_taxonomy(
        string $name,
        string $slug,
        string $singular,
        string $plural,
        bool $hierarchical = true,
        array $post_types = array(),
        string $description = '',
        bool $show_in_rest = true,
        bool $with_front = true, 
    ) {
        $this->custom_taxonomies[$name] = array(
			'post_types' => $post_types,
			'args'       => array(
				'labels'       => $this->init_taxonomy( __( $singular, $this->text_domain ), __( $plural, $this->text_domain ) ),
				'description'  => __( $description, $this->text_domain ),
				'show_in_rest' => $show_in_rest,
				'rewrite'      => array(
					'slug' => $slug,
                    'hierarchical' => true,
                    'with_front' => $with_front
				),
				'hierarchical' => true
			)
		);
    }

    /**
    * Registers all the custom taxonomies for the theme.
    * @return null
    */
	public function register_taxonomies() {
		foreach( $this->custom_taxonomies as $taxonomy_key => $taxonomy_data ) {
			register_taxonomy( $taxonomy_key, $taxonomy_data['post_types'], $taxonomy_data['args'] );
		}
	}
}