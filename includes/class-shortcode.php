<?php
/**
 * Plugin Name:     Breadcrumbs Shortcode
 * Plugin URI:      https://magiiic.com
 * Description:     Register [breadcrumbs] shortcode for inclusion in posts or templates.
 * Author:          Magiiic
 * Author URI:      https://magiiic.com
 * Text Domain:     breadcrumbs-shortcode
 * Domain Path:     /languages
 * Version:         0.1.1
 *
 * @package         Breadcrumbs_Shortcode
 */

// Code starts here.
class Breadcrumbs {
	private $counter = 0;

	public function init() {
		add_shortcode( 'breadcrumbs', array( $this, 'breadcrumbs_shortcode' ) );
	}

	public function breadcrumbs_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'exclude-home'     => 'false',
				'exclude-archives' => 'false',
				'exclude-title'    => 'false',
				'separator'        => '/',
			),
			$atts
		);

		$separator   = ' ' . $atts['separator'] . ' ';
		$breadcrumbs = '';

		if ( $atts['exclude-home'] !== 'true' ) {
			$breadcrumbs .= '<a href="' . home_url() . '">' . esc_html__( 'Home' ) . '</a>' . $separator;
		}

		if ( $atts['exclude-archives'] !== 'true' ) {
			$breadcrumbs .= '<a href="' . get_post_type_archive_link( 'post' ) . '">' . __( 'Articles' ) . '</a>' . $separator;
		}

		if ( is_single() ) {
			$category     = get_the_category();
			$category_id  = $category[0]->cat_ID;
			$breadcrumbs .= get_category_parents( $category_id, true, $separator );
		}

		if ( $atts['exclude-title'] !== 'true' ) {
			if ( is_single() ) {
				$breadcrumbs .= get_the_title();
			} elseif ( is_page() ) {
				$breadcrumbs .= get_the_title();
			} elseif ( is_category() ) {
				$breadcrumbs .= single_cat_title( '', false );
			} elseif ( is_tag() ) {
				$breadcrumbs .= single_tag_title( '', false );
			} elseif ( is_author() ) {
				$breadcrumbs .= get_the_author();
			} elseif ( is_date() ) {
				$breadcrumbs .= get_the_date();
			} elseif ( is_archive() ) {
				$breadcrumbs .= __( 'Archives' );
			}
		}

		return $breadcrumbs;
	}
}

$breadcrumbs = new Breadcrumbs();
add_action( 'init', array( $breadcrumbs, 'init' ) );
