<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

global $wpdb;

$wpbooks_dir_path = ( substr( get_template_directory(),     -1 ) === '/' ) ? get_template_directory()     : get_template_directory()     . '/';
$wpbooks_dir_uri  = ( substr( get_template_directory_uri(), -1 ) === '/' ) ? get_template_directory_uri() : get_template_directory_uri() . '/';

define( 'WPBOOKS_DIR_PATH', $wpbooks_dir_path );
define( 'WPBOOKS_DIR_URI',  $wpbooks_dir_uri  );

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

function run_wpbooks_master() {
    $wpbook_master = new Inc\WpBooksMaster();
    $wpbook_master->run();
}

run_wpbooks_master();