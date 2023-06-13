<?php
/**
 * Plugin Name:     Breadcrumb Shortcode
 * Plugin URI:      https://magiiic.com
 * Description:     Register [breadcrumb] shortcode for inclusion in posts or templates.
 * Author:          Magiiic
 * Author URI:      https://magiiic.com
 * Text Domain:     breadcrumb-shortcode
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Breadcrumb_Shortcode
 */

// Code starts here.
class Breadcrumb {
    public function init() {
        add_shortcode('breadcrumb', array($this, 'breadcrumb_shortcode'));
    }

    public function breadcrumb_shortcode($atts) {
        // Get the current post
        $post = get_post();

        // Check if the post exists
        if ($post) {
            $breadcrumbs = '<ul class="breadcrumb">';

            // Add the home link
            $breadcrumbs .= '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'text-domain') . '</a></li>';

            // Get the post type
            $post_type = get_post_type($post);

            // Add the post type archive link if it's available
            if (get_post_type_archive_link($post_type)) {
                $breadcrumbs .= '<li><a href="' . esc_url(get_post_type_archive_link($post_type)) . '">' . esc_html__(ucfirst($post_type), 'text-domain') . '</a></li>';
            }

            // Add the current post title
            $breadcrumbs .= '<li>' . esc_html(get_the_title($post)) . '</li>';

            $breadcrumbs .= '</ul>';

            return $breadcrumbs;
        }

        return ''; // If no post is found, return empty string
    }
}

$breadcrumb = new Breadcrumb();
add_action('init', array($breadcrumb, 'init'));
