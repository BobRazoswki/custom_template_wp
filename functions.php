<?php

// Add menu to WP Dashboard
add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page(){
	add_menu_page( 'Coding Days', 'Coding Days', 'manage_options', 'custompage', 'my_custom_menu_page', "dashicons-heart", 3 );
}

// HomeMade Custom Post
function my_custom_menu_page(){
  if (isset($_POST['logo_url'])) {
        update_option('logo_url', $_POST['logo_url']);
        $logo_url = $_POST['logo_url'];
    }
    $logo_url = get_option('logo_url', 'logo_url');

  if (isset($_POST['logo_url_store'])) {
        update_option('logo_url_store', $_POST['logo_url_store']);
        $logo_url_store = $_POST['logo_url_store'];
    }
  $logo_url_store = get_option('logo_url_store', 'logo_url_store');
	include 'page-templates/customizer/admin.php';
}

// Custom Sidebar
function register_my_widget_theme()  {
	// Sidebar pour les pages
	register_sidebar(array(
		'id' => 'page-sidebar', // identifiant
		'name' => 'Sidebar Page', // Nom a afficher dans le tableau de bord
		'description' => 'Sidebar pour mes pages.', // description facultatif
		'before_widget' => '<li id="%1$s" class="widget %2$s large--12 medium--4 small--6 extrasmall--12">', // class attribuer pour le contenu (css)
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">', // class attribuer  pour le titre (css)
		'after_title' => '</h2>',
	));
}
add_action( 'widgets_init', 'register_my_widget_theme' );

// Image à la une
add_theme_support( 'post-thumbnails' );

// Link et Script du Head
function wpc_styles() {
	wp_register_script( 'js', get_template_directory_uri().'/build/assets/js/main.min.js' );
	wp_register_style( 'css', get_template_directory_uri().'/build/assets/css/main.min.css' );
	wp_enqueue_script( 'js' );
	wp_enqueue_style( 'css' );
}
add_action('wp_enqueue_scripts', 'wpc_styles');
add_action('wp_enqueue_style', 'wpc_styles');

// Style de l'admin
function load_custom_wp_admin_style() {
    wp_register_style( 'adminCss', get_template_directory_uri().'/build/assets/css/admin.css' );
    wp_register_script( 'adminJs', get_template_directory_uri().'/build/assets/js/admin.js' );
    wp_enqueue_style( 'adminCss' );
    wp_enqueue_script( 'adminJs' );
}

add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
add_action('wp_head', 'wpc_styles');
add_action('wp_head', 'wpc_styles');

/** Customization SweetBid **/
function wpc_dashboard_widget_function() {
	echo
	"<ul>
		<li>Une cr&eacute;ation <a href='http://sweetbid.fr'>SweetBid</a></li>
	</ul>";
}
function wpc_add_dashboard_widgets() {
	wp_add_dashboard_widget('wp_dashboard_widget', 'Informations techniques', 'wpc_dashboard_widget_function');
}
add_action('wp_dashboard_setup', 'wpc_add_dashboard_widgets' );
function remove_footer_admin () {
	echo 'Fait avec &#9829; par des Geeks :D';
}
add_filter('admin_footer_text', 'remove_footer_admin');


?>
