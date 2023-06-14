<?php
/**
 * Plugin Name:     Breadcrumbs Shortcode
 * Plugin URI:      https://magiiic.com
 * Description:     Register [breadcrumbs] shortcode for inclusion in posts or templates.
 * Author:          Magiiic
 * Author URI:      https://magiiic.com
 * Text Domain:     breadcrumbs-shortcode
 * Domain Path:     /languages
 * Version:         0.1
 *
 * @package         Breadcrumbs_Shortcode
 */

// Code starts here.
class Breadcrumbs {
	private $counter = 0;

	public function init() {
		( ! defined( 'BREADCRUMB_VERSION' ) ) && define( 'BREADCRUMB_VERSION', '0.1');
		add_shortcode( 'breadcrumbs', array( $this, 'breadcrumbs_shortcode' ) );
	}

	public function breadcrumbs_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'exclude-home'  => 'false',
				'exclude-title' => 'false',
				'separator'     => '/',
			),
			$atts
		);

		// Get the current post
		$post = get_post();

		// Check if the post exists
		if ( $post ) {
			$this->counter++;

			$breadcrumbs = '<ul class="breadcrumbs breadcrumbs-' . $this->counter . '" style="list-style: none; display: inline;">';

			// Add the home link
			if ( $atts['exclude-home'] !== 'true' ) {
				$breadcrumbs .= '<li class="breadcrumb-home" style="display: inline;"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home' ) . '</a></li>';
			}

			// Get the post categories
			$categories = get_the_category( $post->ID );

			$debug = [];
			// Add the post category links if available
			if ( $categories ) {
				foreach ( $categories as $category ) {
					$breadcrumbs_link  = get_category_link( $category->term_id );
					$breadcrumbs_title = $category->name;
					$debug[] = $category->name;

					$breadcrumbs_title = esc_html( $breadcrumbs_title );
					$li='<li class="breadcrumb-parent" style="display: inline;">';

					$breadcrumbs .= $li . get_category_parents( $category->term_id, true, '</li>' . $li ) . '</li>';
					$breadcrumbs = preg_replace(':<li[^>]*></li>:', '', $breadcrumbs);
				}
			}

			// Add the current post title if exclude-title is true
			if ( $atts['exclude-title'] !== 'true' ) {
				$breadcrumbs .= '<li class="breadcrumb-title" style="display: inline;">' . esc_html( get_the_title( $post ) ) . '</li>';
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
				esc_attr( $atts['separator'] ),
			);

			// Register and enqueue breadcrumbs-style stylesheet
			wp_register_style( 'breadcrumbs-style-' . $this->counter, false );
			wp_enqueue_style( 'breadcrumbs-style-' . $this->counter );

			wp_add_inline_style( 'breadcrumbs-style-' . $this->counter, $separator_css );

			return $breadcrumbs;
		}

		return ''; // If no post is found, return empty string
	}
}

$breadcrumbs = new Breadcrumbs();
add_action( 'init', array( $breadcrumbs, 'init' ) );


// /**
//  * Load the Breadcrumbs_Widget class
//  * @return void
//  */
// function load_breadcrumbs_widget() {
// 	require_once 'breadcrumbs-widget.php';
// }
// add_action( 'widgets_init', 'load_breadcrumbs_widget' );
//
// /**
//  * Register the Breadcrumbs Widget
//  * @return void
//  */
// function register_breadcrumbs_widget() {
// 	register_widget( 'Breadcrumbs_Widget' );
// }
// add_action( 'widgets_init', 'register_breadcrumbs_widget' );
//
// require __DIR__ . '/breadcrumbs-divi.php';
