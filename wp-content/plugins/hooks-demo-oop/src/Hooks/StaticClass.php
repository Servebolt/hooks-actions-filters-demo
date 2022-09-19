<?php

namespace HooksDemo\Hooks;

/**
 * This class is a static class.  That means that it can be run without an instance.
 * This means it runs pretty much like a function, but is namespaced. 
 * 
 * Static methods and classes can be access at anytime from anywhere.
 */
class StaticClass {

    /**
     * This method is run to replicate what a __constructor would do. 
     * 
     * Its called init() which is short for initialzation.
     */
    public static function init() {
        /**
         * This action example uses the WordPress coding standard by using array() and not 
         * the short array syntax [].
         * 
         * The keyword __CLASS__ means, load it from this class that we are currently in.
         *
         * This action has a weight of 20, meaning it loads after everyhing with a weight
         * between 1 and 19
         * 
         * When the action happens it will run the login_script() method below.
         */ 
        add_action( 'login_enqueue_scripts', array( __CLASS__, 'login_scrips'), 20 );
        /**
         * This filter example uses short array syntax [], which is easier to read, but not
         * WordPress coding standard.
         * 
         * It has a weight of 99, meaning that is loads last, after all other things.
         * 
         * When the filter happens it will run the filter_title() method below.
         */
        add_filter( 'the_title', [ __CLASS__, 'filter_title'], 99 );
    }

    /**
     * This method is called from the action 'login_enqueue_scripts'
     * 
     * @return void
     */
    public static function login_scripts() {
        wp_enqueue_script( 'hooks-demo-oop-login', HOOKS_OOP_DEMO_URI . 'js/login.js' );
    }
    /**
     * This method is called from the filter 'the_title'
     * 
     * @var string $title
     * 
     * @return string
     */
    public static function filter_title( $title ) {
        // Only add this text if on the homepage or front page.
        if( is_home() || is_front_page() ) {
            // prepend this text to the titel.
            return "you need to read : " . $title;
        }
        return $title;
    }

}
