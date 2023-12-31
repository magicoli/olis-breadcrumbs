<?php
/**
 * Oli's Breadcrumbs Shortcode
 *
 * @package         Olis_Breadcrumbs_Shortcode
 */

// Code starts here.
class Olis_Breadcrumbs {
	private $counter = 0;

	public function init() {
		add_shortcode( 'breadcrumbs', array( $this, 'breadcrumbs_shortcode' ) );
		add_shortcode( 'olis_breadcrumbs', array( $this, 'breadcrumbs_shortcode' ) ); // make sure there is a unique shortcode
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

	/**
	 * Converts shortcode attributes array to a string.
	 *
	 * @param mixed $atts Array of attributes or empty.
	 * @return string Attributes in string format.
	 */
	static function shortcode_atts_to_string( $atts ) {
		$atts        = ( empty( $atts ) ) ? array() : $atts;
		$atts_string = '';
		foreach ( $atts as $key => $value ) {
			$atts_string .= ' ' . $key . '="' . $value . '"';
		}
		return $atts_string;
	}

}

$Olis_Breadcrumbs = new Olis_Breadcrumbs();
add_action( 'init', array( $Olis_Breadcrumbs, 'init' ) );
