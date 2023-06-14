<?php
/**
 * Breadcrumbs WPBakery Shortcode class
 *
 * @package Breadcrumbs_Shortcode
 */

class Breadcrumbs_WPBakery {
 	public function init() {
 		add_action( 'plugins_loaded', array( $this, 'load_after_plugins' ) );
 	}

 	public function load_after_plugins() {
 		// Check if WPBakery Page Builder is installed and activated
 		if ( defined( 'WPB_VC_VERSION' ) ) {
 			// Hook into the WPBakery init action
 			add_action( 'vc_before_init', array( $this, 'register_breadcrumbs_shortcode' ) );
			add_shortcode( 'olis_breadcrumbs_wpb', array( $this, 'olis_breadcrumbs_wpb_shortcode' ) );
 		}
 	}

	public function register_breadcrumbs_shortcode() {
		vc_map( array(
			'name'        => __( "Oli's Breadcrumbs", 'breadcrumbs-shortcode' ),
			'base'        => 'olis_breadcrumbs_wpb', // The shortcode your component will map to
			'category'    => __( 'Content', 'breadcrumbs-shortcode' ),
			'description' => __( 'Add breadcrumbs to your page', 'breadcrumbs-shortcode' ),
			'icon'        => 'dt_vc_ico_breadcrumbs', // Icon class for your component
			'params'      => array(
				array(
					'type'        => 'checkbox',
					'heading'     => __( 'Exclude Home', 'breadcrumbs-shortcode' ),
					'param_name'  => 'exclude-home',
					'value'       => array( __( 'Yes', 'breadcrumbs-shortcode' ) => 'true' ),
					'description' => __( 'Do not start the breadcrumbs with home page', 'breadcrumbs-shortcode' ),
				),
				array(
					'type'        => 'checkbox',
					'heading'     => __( 'Exclude Archives', 'breadcrumbs-shortcode' ),
					'param_name'  => 'exclude-archives',
					'value'       => array( __( 'Yes', 'breadcrumbs-shortcode' ) => 'true' ),
					'description' => __( 'Do not include main articles archive link', 'breadcrumbs-shortcode' ),
				),
				array(
					'type'        => 'checkbox',
					'heading'     => __( 'Exclude Title', 'breadcrumbs-shortcode' ),
					'param_name'  => 'exclude-title',
					'value'       => array( __( 'Yes', 'breadcrumbs-shortcode' ) => 'true' ),
					'description' => __( 'Do not end the breadcrumbs with the post title', 'breadcrumbs-shortcode' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Separator', 'breadcrumbs-shortcode' ),
					'param_name'  => 'separator',
					'value'       => '/',
					'description' => __( 'Specify the separator character for the breadcrumbs', 'breadcrumbs-shortcode' ),
				),
			),
		) );
	}

	public function olis_breadcrumbs_wpb_shortcode( $atts ) {
	    // Create breadcrumbs using the Breadcrumbs class via a shortcode
	    $breadcrumbs = do_shortcode( '[breadcrumbs ' . Breadcrumbs::shortcode_atts_to_string($atts) . ']' );

	    // Wrap the breadcrumbs with the div
	    $output = '<div class="vc_column-inner ' . esc_attr( apply_filters( 'vc_shortcodes_css_class', 'wpb_wrapper', 'olis_breadcrumbs_wpb' ) ) . '">';
	    $output .= $breadcrumbs;
	    $output .= '</div>';

	    return $output;
	}

}

$breadcrumbs_wpbakery = new Breadcrumbs_WPBakery();
$breadcrumbs_wpbakery->init();
