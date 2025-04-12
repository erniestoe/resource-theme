<?php 
function getFile($path) {
	return dirname(__FILE__) . '/' . $path;
}

add_filter( 'show_admin_bar', '__return_false' ); // Remove admin bar for all users

function mytheme_enqueue_style() {
	wp_enqueue_style( 'mytheme-style', get_stylesheet_uri() ); 
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_style' );


function register_my_menu() {
	register_nav_menu( 'site-menu', __( 'Site menu' ));
}
add_action( 'init', 'register_my_menu' );