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

/**
 * Load the Breadcrumbs_Widget class
 * @return void
 */
require_once __DIR__ . '/includes/class-widget.php';

//
// require __DIR__ . '/includes/class-divi.php';
