<?php
/**
 * Add an action to load the child theme style
 * 
 * Note that is does not matter what comes first, the add_action
 * of the function that it runs.
 * 
 * Different coders have different preferences, go with what works in your
 * team.
 */
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );
// Function to enqueue the style.
function child_theme_enqueue_styles() {
    wp_enqueue_style( 'twentytwentytwo-child-style', get_stylesheet_uri(),
        array( 'twentytwentytwo-style' ), 
        wp_get_theme()->get('Version')
    );
}

/**
 * Pre get posts uses the $query object. 
 * 
 * It is given as a reference. The actual object instance is shared and adapted.
 * This means that it does not need to be returned, the changes are made directly into the instance object. 
 */
function modify_main_query( $query ) {
    if ( ( $query->is_home() || is_front_page() ) && $query->is_main_query() ) {
        // The apply filters is for the custom hook 'homepage_postypes'
        $query->set('post_type', apply_filters('homepage_postypes', ['post']) );    
    }
}
/**
 * Add the action for "pre_get_posts", and will call the function 'modify_main_query'
 * 
 * Because there are no additional arguements it will use a weighting of 10
 * And will only send the first possible variable. In the case $query
 */
add_action( 'pre_get_posts', 'modify_main_query');

/**
 * 
 */
add_action('tagemanager_iframe', 'add_google_tagmanager_iframe');

function add_google_tagmanager_iframe () {
    $code = get_option('google_gtm_code');  ?>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $code ?>"'	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php
}
