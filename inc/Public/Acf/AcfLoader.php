<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that inc attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://wpbooks.com
 * @since      1.0.0
 *
 * @package    WpBooks
 * @subpackage Acf/inc
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
 * @subpackage WpBooks/inc/acf
 * @author     Eribert Marquez <eriker1997@gmail.com>
 * 
 */

namespace Inc\Public\Acf;

class AcfLoader {

    public function __construct() {
    }

    private function register_block($name, $title, $description, $icon, $template, $styles, $script) {
        
        if(!function_exists('acf_register_block_type')) return;

        acf_register_block_type(array(
            'name'              => __($name, WPBOOKS_TEXT_DOMAIN),
            'title'             => __($title, WPBOOKS_TEXT_DOMAIN),
            'icon'              => $icon,
            'category'          => 'layout',
            'description'       => __($description, WPBOOKS_TEXT_DOMAIN),
            'mode' => 'preview',
            'supports'          => array(
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ),
            'render_template'   => WPBOOKS_DIR_PATH . "inc/Public/Acf/Blocks/$template.php",
            'enqueue_style'     => WPBOOKS_DIR_URI . "inc/Public/Acf/Blocks/$styles.css",
            'enqueue_script'    => WPBOOKS_DIR_URI . "inc/Public/Acf/Blocks/$script.js"
        ));
    }

    public function register_all_blocks() {
        $this->register_block(
            'book-card',
            'Book Card',
            'A simple block card',
            'book-alt',
            'BookCard/BookCard',
            'BookCard/book-card',
            'BookCard/book-card'
        );

        $this->register_block(
            'book-grid',
            'Book Grid',
            'A simple container for multiple Books',
            'book-alt',
            'BookGrid/BookGrid',
            'BookGrid/book-grid',
            'BookGrid/book-grid',
        );
    }
}