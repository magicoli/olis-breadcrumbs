<?php
/**
 * Plugin Name:     Breadcrumbs Shortcode
 * Plugin URI:      https://magiiic.com
 * Description:     Register [breadcrumbs] shortcode for inclusion in posts or templates.
 * Author:          Magiiic
 * Author URI:      https://magiiic.com
 * Text Domain:     breadcrumbs-shortcode
 * Domain Path:     /languages
 * Version:         0.1.3
 *
 * @package         Breadcrumbs_Shortcode
 */

// Code starts here.
( ! defined( 'BREADCRUMB_VERSION' ) ) && define( 'BREADCRUMB_VERSION', '0.1.3');

// Load Breadcrumbs class
require_once __DIR__ . '/includes/class-shortcode.php';

// Load Breadcrumbs_Widget class
require_once __DIR__ . '/includes/class-widget.php';

// Load Breadcrumbs_Divi class
require_once __DIR__ . '/includes/class-divi.php';
