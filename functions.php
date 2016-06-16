<?php
// Custom Menu Walker
class Custom_Menu extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth ) {
	    // depth dependent classes
	    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
	    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
	    $classes = array( 'menu__sub' );
	    $class_names = implode( ' ', $classes );

	    // build html
	    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
    {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
	function start_el( &$output, $item, $depth, $args ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // depth dependent classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $isCurrent = ( in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-parent', $classes ) || in_array( 'current_page_ancestor', $classes ) );

        $depth_classes = array(
            ( $depth == 0 ? 'menu__item' : 'menu__sub__item' ),
            ( $args->has_children ? 'menu__item--parent' : '' ),
        );

        if ( $isCurrent ) $depth_classes[] = $depth == 0 ? 'menu__item--current' : 'menu__sub__item--current';

        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // passed classes
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // build html
        $output .= $indent . '<li class="' . $depth_class_names . '">';

        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="link ' . ( $depth > 0 ? 'menu__sub__link' : 'menu__link' ) . ($item->classes[0] === 'icon' ? ' ' . $item->classes[0] . ' ' . $item->classes[1] : '') . ($item->classes[0] === 'logo' ? ' ' . $item->classes[0] : '') . '"';
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    function end_el(&$output, $item, $depth=0, $args=array()) {
        $output .= "</a></li>\n";
    }
}

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

// Link et Script du Head
function wpc_styles() {
	// PROD
	// wp_register_script( 'js', get_template_directory_uri().'/build/assets/js/main.min.js' );
	// wp_register_style( 'css', get_template_directory_uri().'/build/assets/css/main.min.css' );
	// LOCAL
	wp_register_script( 'js', get_template_directory_uri().'/assets/js/main.js' );
	wp_register_style( 'css', get_template_directory_uri().'/assets/css/style.css' );

	// wp_register_script( 'jquery', get_template_directory_uri().'/build/assets/lib/jquery/jquery.min.js' );
	// wp_enqueue_script( 'jquery' );

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
add_action( 'admin_enqueue_scripts', 'meta_box_scripts' );

function meta_box_scripts() {

    global $post;

    wp_enqueue_media( array(
        'post' => $post->ID,
    ) );

}

function wpdocs_theme_add_editor_styles() {
  add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );

// Body Class
function add_slug_body_class( $classes ) {
	global $post;

	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
		return $classes;
}

add_filter( 'body_class', 'add_slug_body_class' );

// Content Width
if ( ! isset( $content_width ) ) $content_width = 900;

// Image à la une, etc
function custom_theme_setup() {
	add_theme_support( 'post-thumbnails');
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( "title-tag" );
  add_theme_support( "custom-header");
  add_theme_support( "custom-background");
}

add_action( 'after_setup_theme', 'custom_theme_setup' );

// Customization SweetBid
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

// WP Alchemy
// Metaboxes
include_once WP_CONTENT_DIR . '/wpalchemy/MetaBox.php';
include_once WP_CONTENT_DIR . '/wpalchemy/MediaAccess.php';
include_once 'metaboxes/setup.php';
include_once 'metaboxes/full-spec.php';

$wpalchemy_media_access = new WPAlchemy_MediaAccess();

?>
