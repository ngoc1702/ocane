<?php
/**
 * Custom hooks and functions.
 *
 * @category CAIA
 * @package  Functions
 * @author   HoangLT
 */

// Block edit theme and plugin in daskboard.
define('DISALLOW_FILE_EDIT',true);

// Tắt tự động cập nhật
// Init theme
require_once( TEMPLATEPATH . '/lib/init.php' );
require( CHILD_DIR . '/lib/init.php' );

/** Load custom functions */
if ( file_exists( CAIA_CUSTOM_DIR . '/functions.php' ) ){
	require( CAIA_CUSTOM_DIR . '/functions.php' );
}

// Đặt mặc định đường dẫn tĩnh
add_action( 'init', 'default_permalinks' );
function default_permalinks(){
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure( '/%postname%.html' );
}

// Thêm thẻ meta responsive
add_action('wp_head','caia_add_meta_responsive');
function caia_add_meta_responsive(){
	echo "<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' />";
	// echo '<meta name="viewport" content="width=device-width, initial-scale=1.0>';
}
