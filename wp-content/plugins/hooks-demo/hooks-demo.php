<?php
/**
 * Plugin Name: Hooks Demo
 * Plugin URI: https://servebolt.com
 * Description: Hooks, actions and filters demo
 * Version: 1.0.0
 * Author: Andrew Killen
 */

// if no WP, no joy
if(!defined('ABSPATH')){
    die('go away. I do not like you');
}

define('HOOKS_DEMO_URI', plugin_dir_url( __FILE__ ) );
define('HOOKS_DEMO_PATH', plugin_dir_path( __FILE__ ) );

/**
 * In the child theme there is a custom filter called 'homepage_posttypes', 
 * it is being hooked into here in this plugin
 * 
 * becuase no weight is set it defaults to 10
 * 
 * 
 */
add_filter( 'homepage_posttypes', 'add_postypes_to_homepage_for_display' );

/**
 * This function is called from the add_filter('homepage_posttypes').
 * 
 * Because the filter has no weight set it will default to 10
 * 
 * This filter will add "page" and "knowledge_base" to the postypes array.
 * 
 * @var array $posttypes
 * 
 * @return array
 */
function add_postypes_to_homepage_for_display( $posttypes ) {
    $posttypes [] = 'page';
    $posttypes [] = 'knowledge_base';
    return $posttypes;
}


/**
 * Anonymous functions can also be used with actions or 
 * filters.
 * 
 * In this filter, it removes the post type of 'shops' from the post types
 * list for the home page.
 * 
 * This will mean that when pre_get_posts looks for posts to show, it will not
 * include the 'shops' post type
 * 
 * It is also run with a weight of 20, so will run after the above filter/function.
 * 
 * @var array $posttypes
 * 
 * @return array
 */
add_filter( 'homepage_posttypes', function ( $posttypes ) {
    unset ( $posttypes['shops'] );
    return $posttypes;
}, 20 );



/**
 * This filter on "the_title", which is the text for the title of every post, will
 * run last after everthing else that has been applied to it, 
 * due to the weight of 99.
 * 
 * Because the number 2 was used, 2 separate arguments will be passed to the function. 
 * 
 * In this case that would be the title text, and the id of the object (comment, menu, post) that
 * the title comes from.
 */
add_filter( 'the_title', 'adapt_title_content', 99, 2);

/**
 * This function will take the title and prepend (add a suffix) the words
 * "breaking news : " to every title that matches the wanted post type or ID.
 * 
 * The id could be that of the comment, menu item or post. 
 * @var string $title
 * @var int $id
 * 
 * @return string;
 */
function adapt_title_content( $title, $id ) {
    // If is single (a post) OR the post_id equals 208
    if( is_single() || $id == 208 ) {
        return "breaking news : " . $title;
    }
    return $title;
}


add_action( 'wp_enqueue_scripts', 'add_scripts_to_page', 99 );

function add_scripts_to_page( ) {
    // load for any page that is for a post, attachment, page or custom post type.
    if( is_singular() ) {
        wp_enqueue_script('hook-demo-single-script', HOOKS_DEMO_URI ."js/single.js");
    } else if ( is_archive() ) {
        // only load this on pages that are archive pages (taxonomies)
        wp_enqueue_script('hook-demo-archive-script', HOOKS_DEMO_URI ."js/archive.js");
    }
}

add_action( 'wp_enqueue_scripts', 'add_style_to_page', 20 );

function add_style_to_page( ) {
    // only add this if showing the home page or front page
    if ( is_home() || is_front_page() ) {
        wp_enqueue_style('hook-demo-home-style', HOOKS_DEMO_URI ."css/home.css");
    }
}
