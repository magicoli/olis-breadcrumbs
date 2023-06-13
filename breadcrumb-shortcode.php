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
    private $counter = 0;

    public function init() {
        ( !defined('BREADCRUMB_VERSION' ) && define( 'BREADCRUMB_VERSION', '0.1' ) );
        add_shortcode('breadcrumb', array($this, 'breadcrumb_shortcode'));
    }

    public function breadcrumb_shortcode($atts) {
        $atts = shortcode_atts(array(
            'exclude-home' => 'false',
            'exclude-title' => 'false',
            'separator' => '/',
        ), $atts);

        // Get the current post
        $post = get_post();

        // Check if the post exists
        if ($post) {
          $this->counter++;

            $breadcrumbs = '<ul class="breadcrumbs breadcrumbs-' . $this->counter . '" style="list-style: none; display: inline;">';

            // Add the home link
            if ($atts['exclude-home'] !== 'true') {
              $breadcrumbs .= '<li class="breadcrumb-home" style="display: inline;"><a href="' . esc_url(home_url('/')) . '">' . esc_html__( 'Home' ) . '</a></li>';
            }

            // Get the post categories
            $categories = get_the_category($post->ID);

            // Add the post category links if available
            if ($categories) {
                foreach ($categories as $category) {
                    $breadcrumb_link = get_category_link($category->term_id);
                    $breadcrumb_title = $category->name;

                    // Check if the category has parent categories
                    if ($category->parent) {
                        $breadcrumb_title = get_category_parents($category->term_id, true, '</li><li>', false) . $breadcrumb_title;
                    }

                    $breadcrumbs .= '<li class="breadcrumb-parent" style="display: inline;"><a href="' . esc_url($breadcrumb_link) . '">' . esc_html($breadcrumb_title) . '</a></li>';
                }
            }

            // Add the current post title if exclude-title is true
            if ($atts['exclude-title'] !== 'true') {
                $breadcrumbs .= '<li class="breadcrumb-title" style="display: inline;">' . esc_html(get_the_title($post)) . '</li>';
            }

            $breadcrumbs .= '</ul>';

            // Generate dynamic CSS for separator
            $separator_css = sprintf(
              '
              #left-area ul.breadcrumbs-%1$s,
              .entry-content ul.breadcrumbs-%1$s,
              .et-l--body ul.breadcrumbs-%1$s,
              .et-l--footer ul.breadcrumbs-%1$s,
              .et-l--header ul.breadcrumbs-%1$s {
                padding-left: 0;
                padding-right: 0;
              }
              .breadcrumbs-%1$s li:not(:first-child):before {
                content: "%2$s";
                margin: 0 5px;
              }',
              $this->counter,
              esc_attr($atts['separator']),
            );

            // Register and enqueue breadcrumb-style stylesheet
            wp_register_style('breadcrumb-style-' . $this->counter, false);
            wp_enqueue_style('breadcrumb-style-' . $this->counter);

            wp_add_inline_style('breadcrumb-style-' . $this->counter, $separator_css);

            return $breadcrumbs;
        }

        return ''; // If no post is found, return empty string
    }
}

$breadcrumb = new Breadcrumb();
add_action('init', array($breadcrumb, 'init'));

include( __DIR__ . '/breadcrumb-divi.php' );
