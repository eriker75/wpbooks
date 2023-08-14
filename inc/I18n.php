<?php

/**
 * Define la funcionalidad de internacionalización
 *
 * Carga y define los archivos de internacionalización de este plugin para que esté listo para su traducción.
 *
 * @link       https://eribertmarquez.com
 * @since      1.0.0
 *
 * @package    WpBooks
 * @subpackage WpBooks/includes
 */

/**
 * Ésta clase define todo lo necesario durante la activación del plugin
 *
 * @since      1.0.0
 * @package    WpBooks
 * @subpackage WpBooks/includes
 * @author     Eribert Marquez <eriker1997@gmail.com>
 */

namespace Inc;

class I18n {
    
    /**
	 * Carga el dominio de texto (textdomain) del plugin para la traducción.
	 *
     * @since    1.0.0
     * @access public static
	 */    
    public function load_theme_textdomain() {
        
        $textdomain = "wpbooks";
        
        load_theme_textdomain(
            $textdomain,
            false,
            WPBOOKS_DIR_PATH . 'lang'
        );
        
        $locale = apply_filters( 'theme_locale', is_admin() ? get_user_locale() : get_locale(), $textdomain );
        
        load_textdomain( $textdomain, get_theme_file_path( "lang/$textdomain-$locale.mo" ) );
        
    }
}