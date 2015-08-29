<?php
add_theme_support( 'post-thumbnails' );

function wpc_styles() {

	//Themes files
	wp_register_script( 'js', get_template_directory_uri().'/build/assets/js/main.min.js' );
	wp_register_style( 'css', get_template_directory_uri().'/build/assets/css/main.min.css' );

	//Requires
	wp_enqueue_script( 'js' );
	wp_enqueue_style( 'css' );
}

add_action('wp_enqueue_scripts', 'wpc_styles');
add_action('wp_enqueue_style', 'wpc_styles');


?>
