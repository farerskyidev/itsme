<?php
/**
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 *
 */  

add_action( 'wp_enqueue_scripts', 'twenty_twenty_three_child_style' );
function twenty_twenty_three_child_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
}

function create_art_cpt() {
    $labels = array(
        'name' => _x('Art', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('Art', 'Post Type Singular Name', 'textdomain'),
    );
    $args = array(
        'label' => __('Art', 'textdomain'),
        'description' => __('Art custom post type', 'textdomain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields'),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
    );
    register_post_type('art', $args);
}

add_action('init', 'create_art_cpt', 0);

function create_art_taxonomies() {
    $labels_music = array(
        'name' => _x('Music', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Music', 'taxonomy singular name', 'textdomain'),
    );

    $args_music = array(
        'hierarchical' => true,
        'labels' => $labels_music,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'music'),
        'show_in_rest' => true,
    );

    register_taxonomy('music', array('art'), $args_music);

    $labels_photography = array(
        'name' => _x('Photography', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Photography', 'taxonomy singular name', 'textdomain'),
    );

    $args_photography = array(
        'hierarchical' => true,
        'labels' => $labels_photography,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'photography'),
        'show_in_rest' => true,
    );

    register_taxonomy('photography', array('art'), $args_photography);
}

add_action('init', 'create_art_taxonomies', 0);

function art_list_shortcode($atts) {

    $atts = shortcode_atts(
        array(
            'items' => 10,
            'music' => '',
            'photography' => '',
            'author' => '',
        ),
        $atts,
        'art_list'
    );

    ob_start();
    include get_stylesheet_directory() . '/shortcode-template.php';
    return ob_get_clean();
}
add_shortcode('art_list', 'art_list_shortcode');
