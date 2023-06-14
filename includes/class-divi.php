<?php
/**
 * Divi theme classes
 *
 * @package         Breadcrumbs_Shortcode
 */

// Register the Divi module
function register_breadcrumbs_divi_module() {
	if ( class_exists( 'ET_Builder_Module' ) ) {
		class Breadcrumbs_Divi_Module extends ET_Builder_Module {
			public $slug = 'et_pb_custom_breadcrumbs';

			public function init() {
				$this->name                        = esc_html__( 'Breadcrumbs', 'et_builder' );
				$this->whitelisted_fields          = array(
					'exclude_home',
					'exclude_archives',
					'exclude_title',
					'separator',
				);
				$this->advanced_setting_title_text = esc_html__( 'New Breadcrumbs', 'et_builder' );
				$this->settings_text               = esc_html__( 'Breadcrumbs Settings', 'et_builder' );
				$this->main_css_element            = '%%order_class%%';
			}

			public function get_fields() {
				return array(
					'exclude_home'  => array(
						'label'           => esc_html__( 'Exclude Home', 'et_builder' ),
						'type'            => 'yes_no_button',
						'options'         => array(
							'on'  => esc_html__( 'Yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'option_category' => 'configuration',
						'description'     => esc_html__( 'Exclude the home link from the breadcrumbs.', 'et_builder' ),
						'default'         => 'off',
					),
					'exclude_archives'  => array(
						'label'           => esc_html__( 'Exclude archives', 'et_builder' ),
						'type'            => 'yes_no_button',
						'options'         => array(
							'on'  => esc_html__( 'Yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'option_category' => 'configuration',
						'description'     => esc_html__( 'Exclude the archives link from the breadcrumbs.', 'et_builder' ),
						'default'         => 'off',
					),
					'exclude_title' => array(
						'label'           => esc_html__( 'Exclude Title', 'et_builder' ),
						'type'            => 'yes_no_button',
						'options'         => array(
							'on'  => esc_html__( 'Yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'option_category' => 'configuration',
						'description'     => esc_html__( 'Exclude the post title from the breadcrumbs.', 'et_builder' ),
						'default'         => 'off',
					),
					'separator'     => array(
						'label'           => esc_html__( 'Separator', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'configuration',
						'description'     => esc_html__( 'Specify the separator character for the breadcrumbs.', 'et_builder' ),
						'default'         => '/',
					),
				);
			}

			public function shortcode_callback( $atts, $content = null, $function_name ) {
				$exclude_home  = $this->shortcode_atts['exclude_home'] === 'on';
				$exclude_archives  = $this->shortcode_atts['exclude_archives'] === 'on';
				$exclude_title = $this->shortcode_atts['exclude_title'] === 'on';
				$separator     = $this->shortcode_atts['separator'];

				// Process the [breadcrumbs] shortcode with the specified options
				$breadcrumbs = do_shortcode( '[breadcrumbs exclude-home="' . ( $exclude_home ? 'true' : 'false' ) . '" exclude-archives="' . ( $exclude_archives ? 'true' : 'false' ) . '" exclude-title="' . ( $exclude_title ? 'true' : 'false' ) . '" separator="' . esc_attr( $separator ) . '"]' );

				$output = sprintf(
		        '<div class="%1$s">%2$s</div>',
		        esc_attr( 'et_pb_module et_pb_breadcrumbs' ),
		        $breadcrumbs
		    );

				return $output;
			}
		}

		new Breadcrumbs_Divi_Module();
	}
}

// Integrate Breadcrumbs module with Divi Builder
add_action( 'et_builder_ready', 'register_breadcrumbs_divi_module' );
