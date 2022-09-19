<?php
/**
 * Plugin Name: Hooks Demo OOP
 * Plugin URI: https://servebolt.com
 * Description: Hooks, actions and filters demo
 * Version: 1.0.0
 * Author: Andrew Killen
 */

// if no WP, no joy
if(!defined('ABSPATH')){
    die('go away. I do not like you');
}

define('HOOKS_OOP_DEMO_URI', plugin_dir_url( __FILE__ ) );
define('HOOKS_OOP_DEMO_PATH', plugin_dir_path( __FILE__ ) );


/**
 * Autoloader for entire project. Sets up the namespace HooksDemo
 */
require dirname(__FILE__) . "/vendor/autoload.php";
// Create a new instance 
$instanceDemo = new HooksDemo\Hooks\InstanceClass();
// Load things statically. 
\HooksDemo\Hooks\StaticClass::init();
