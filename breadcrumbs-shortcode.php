<?php
/**
 * Plugin Name:     Breadcrumbs Shortcode
 * Plugin URI:      https://magiiic.com
 * Description:     Register [breadcrumbs] shortcode for inclusion in posts or templates.
 * Author:          Magiiic
 * Author URI:      https://magiiic.com
 * Text Domain:     breadcrumbs-shortcode
 * Domain Path:     /languages
 * Version:         0.1.2
 *
 * @package         Breadcrumbs_Shortcode
 */

// Code starts here.
( ! defined( 'BREADCRUMB_VERSION' ) ) && define( 'BREADCRUMB_VERSION', '0.1.2');

require_once __DIR__ . '/includes/class-shortcode.php';

// /**
// * Load the Breadcrumbs_Widget class
// * @return void
// */
// function load_breadcrumbs_widget() {
// }
// add_action( 'widgets_init', 'load_breadcrumbs_widget' );
//
// /**
// * Register the Breadcrumbs Widget
// * @return void
// */
// function register_breadcrumbs_widget() {
// register_widget( 'Breadcrumbs_Widget' );
// }
// add_action( 'widgets_init', 'register_breadcrumbs_widget' );
//
// require __DIR__ . '/includes/class-divi.php';
