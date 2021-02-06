<?php
/*
Plugin Name: JBuilder
Plugin URI: 
Description: Customise WordPress with powerful.
Version: 2.0
Author: Jonathan Christoper (JC)
Author URI: 
Copyright: Jonathan Christoper (JC)
Text Domain: jbuilder
Domain Path: /lang
*/
add_filter( 'show_admin_bar', '__return_false' );
add_action( 'init', 'jAdmin' );
add_action( 'login_footer', 'jAdmin' );
add_action( 'init', 'jPostPage' );
add_action( 'init', 'jMenus' );
add_action( 'init', 'jRemoveJquery'); 



require_once( plugin_dir_path( __FILE__ ) . 'modules/addon.php');
require_once( plugin_dir_path( __FILE__ ) . 'modules/agent.php');
require_once( plugin_dir_path( __FILE__ ) . 'customization.php');