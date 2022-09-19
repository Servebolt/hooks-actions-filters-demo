<?php

namespace HooksDemo\Hooks;

class InstanceClass {

    public function __construct() {

        /**
         * This filter example uses the short array syntax [], this is not WordPress
         * coding standards.
         * 
         * The keyword $this means, load it from this class instance. This action has a 
         * weight of 99, meaning it runs last after all other filters.
         * 
         * When the filter happens it will run the content() method below.
         */
        add_filter('the_content', [$this, 'content_filter'], 99 );
        /**
         * This action example uses the short array syntax [].
         * 
         * The keyword $this means, load it from this class instance. This action has a 
         * weight of 10 as it is not detailed
         * 
         * When the action happens it will run the admin_script() method below.
         */
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts'] );
        /**
         * This action example uses the WordPress coding standard by using array() and not 
         * the short array syntax [].
         * 
         * The keyword $this means, load it from this class instance. This action has a 
         * weight of 10 as it is not details
         * 
         * When the action happens it will run the frontend_script() method below.
         */
        add_action('wp_enqueue_scripts', array( $this, 'frontend_scripts') );

    }

    /**
     * Enqueue the front end scripts wanted. They are being loaded with a weight of 10
     */
    public function frontend_scripts() {
        wp_enqueue_script( 'hooks-demo-oop-frontend', HOOKS_OOP_DEMO_URI . 'js/frontemd.js' );
    }

    /**
     * Enqueue the admin scripts wanted. They are being loaded with a weight of 10
     */
    public function admin_scripts( $hook ) {
        wp_enqueue_script( 'hooks-demo-oop-admin', HOOKS_OOP_DEMO_URI . 'js/admin.js' );
    }

    /**
     * Filter the content to append a message at the end, this is being loaded with a 
     * weight of 99, thus will be the last thing added
     */
    public function content_filter( $content ) {
        // Only adapts on Singular pages (posts, pages, custom post type )
        if( is_singular() ) {
            // Append after all other content. Could have been more simply
            // written as $content .= "<p>Don't forget to share this with others</p>";
            $content = $content . "<p>Don't forget to share this with others</p>";
        }

        return $content;
    }

}
