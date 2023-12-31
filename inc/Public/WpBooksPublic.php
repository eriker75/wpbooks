<?php

/**
 * La funcionalidad específica de administración del plugin.
 *
 * @link       https://eribertmarquez.com
 * @since      1.0.0
 *
 * @package    theme_name
 * @subpackage theme_name/admin
 */

/**
 * Define el nombre del plugin, la versión y dos métodos para
 * Encolar la hoja de estilos específica de administración y JavaScript.
 * 
 * @since      1.0.0
 * @package    BC THEME
 * @subpackage BC THEME/admin
 * @author     Gilbert Rodríguez <email@example.com>
 * 
 * @property string $theme_name
 * @property string $version
 */

namespace Inc\Public;

use Inc\Normalize;

use Inc\Public\AuthorBookRelation;
use Inc\Loader;
use Inc\Public\Acf\AcfLoader;

class WpBooksPublic {

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
	 * The unique identifier of this theme
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $theme_name  The name or unique identifier of this theme
	 */
    private $theme_name;

    /**
	 * The text domain of this theme
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $theme_name  The name text domain of this theme
	 */
    private $text_domain;
    
    /**
	 * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version  La versión actual del plugin
	 */
    private $version;
    
    /**
	 * Objeto WPBOOKS_Normalize
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $normalize Instancia del objeto WPBOOKS_Normalize
	 */
    private $normalize;
    
    /**
	 * Objeto WPBOOKS_Helpers
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $helpers Inc\Helper\Help object instance
	 */
    private $helpers;
    
    /**
     * @param string $theme_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct( $theme_name, $version, $text_domain, $loader ) {
        $this->theme_name = $theme_name;
        $this->version = $version;
        $this->text_domain = $text_domain;
        $this->loader = $loader;
        $this->normalize = new Normalize();
    }
    
    /**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_styles() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en WPBOOKS_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El WPBOOKS_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */
        
		wp_enqueue_style( $this->theme_name . '-main-styles', WPBOOKS_DIR_URI . 'inc/assets/public/css/wpbooks-public.css', array(), $this->version, 'all' );
        

        // Vendor styles
        wp_enqueue_style( $this->theme_name . '-normalize', WPBOOKS_DIR_URI . 'inc/assets/public/vendor/normalize.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->theme_name . '-bootstrap', WPBOOKS_DIR_URI . 'inc/assets/public/vendor/bootstrap/css/bootstrap.min.css', array(), $this->version, 'all' );
    }
    
    /**
	 * Registra los archivos Javascript del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_scripts() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en WPBOOKS_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El WPBOOKS_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */        
        
        wp_enqueue_script( $this->theme_name . '-main-script', WPBOOKS_DIR_URI . 'inc/assets/public/js/wpbooks-public.js', array( 'jquery' ), $this->version, true );



        wp_enqueue_script( $this->theme_name . '-bootstrap-script', WPBOOKS_DIR_URI . 'inc/assets/public/vendor/bootstrap/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
    }

    /**
	 * Registra los archivos Javascript del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function many_to_many_acf_relations() {
        $author_relation = new AuthorBookRelation();
        $this->loader->add_filter('acf/update_value/name=book_authors', $author_relation, 'update_book_authors' , 10, 2 );
        $this->loader->add_filter('acf/update_value/name=author_books', $author_relation, 'update_author_books' , 10, 2 );        
    }

    public function register_acf_blocks(){
        $acf_loader = new AcfLoader();
        $this->loader->add_action('acf/init', $acf_loader, 'register_all_blocks');
    }
}