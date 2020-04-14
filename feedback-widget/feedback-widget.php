<?php
/**
 * @package Feedback Widget
 */
/*
Plugin Name: Feedback Widget
Plugin URI: 
Description: A plugin that will provide you feedback widget.
Version: 1.0
Author: joshNull
Author URI: 
License: GPLv2 or later
Text Domain: 
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define('FBW_PLUGIN_DIR', plugin_dir_path( __FILE__ ));

require_once(FBW_PLUGIN_DIR . 'class-feedback-widget.php');
require_once(FBW_PLUGIN_DIR . 'class-feedback-widget-model.php');
require_once(FBW_PLUGIN_DIR . 'class-feedback-widget-admin.php');

register_activation_hook( __FILE__, array('Feedback_Widget_Model', 'create_feedback_table'));
register_deactivation_hook( __FILE__, array('Feedback_Widget_Model', 'drop_feedback_table'));

$model = new Feedback_Widget_Model;

// Admin Page
add_action('admin_menu', function() use ($model) {
	$admin = new Feedback_Widget_Admin($model);
	$admin->init();
});

// APIs
add_action('rest_api_init', function () use ($model) {
	require_once(FBW_PLUGIN_DIR . 'class-feedback-widget-route.php');

	$routes = new Feedback_Widget_Route($model);
	$routes->register_routes();
});


// Actual Widget
add_action('widgets_init', array('Feedback_Widget', 'init'));


