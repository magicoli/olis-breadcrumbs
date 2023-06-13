<?php
/**
 * Divi theme classes
 *
 * @package         Breadcrumb_Shortcode
 */

// Register the Divi module
function register_breadcrumb_divi_module() {
  if (class_exists('ET_Builder_Module')) {
    class Breadcrumb_Divi_Module extends ET_Builder_Module {
      public $slug = 'et_pb_custom_breadcrumb';

      public function init() {
        $this->name = esc_html__('Breadcrumb', 'et_builder');
        $this->whitelisted_fields = array(
          'exclude_home',
          'exclude_title',
          'separator',
        );
        $this->advanced_setting_title_text = esc_html__('New Breadcrumb', 'et_builder');
        $this->settings_text = esc_html__('Breadcrumb Settings', 'et_builder');
        $this->main_css_element = '%%order_class%%';
      }

      public function get_fields() {
        return array(
          'exclude_home' => array(
            'label' => esc_html__('Exclude Home', 'et_builder'),
            'type' => 'yes_no_button',
            'options' => array(
              'on' => esc_html__('Yes', 'et_builder'),
              'off' => esc_html__('No', 'et_builder'),
            ),
            'option_category' => 'configuration',
            'description' => esc_html__('Exclude the home link from the breadcrumb.', 'et_builder'),
            'default' => 'off',
          ),
          'exclude_title' => array(
            'label' => esc_html__('Exclude Title', 'et_builder'),
            'type' => 'yes_no_button',
            'options' => array(
              'on' => esc_html__('Yes', 'et_builder'),
              'off' => esc_html__('No', 'et_builder'),
            ),
            'option_category' => 'configuration',
            'description' => esc_html__('Exclude the post title from the breadcrumb.', 'et_builder'),
            'default' => 'off',
          ),
          'separator' => array(
            'label' => esc_html__('Separator', 'et_builder'),
            'type' => 'text',
            'option_category' => 'configuration',
            'description' => esc_html__('Specify the separator character for the breadcrumb.', 'et_builder'),
            'default' => '/',
          ),
        );
      }

      public function shortcode_callback($atts, $content = null, $function_name) {
        $exclude_home = $this->shortcode_atts['exclude_home'] === 'on';
        $exclude_title = $this->shortcode_atts['exclude_title'] === 'on';
        $separator = $this->shortcode_atts['separator'];

        // Process the [breadcrumb] shortcode with the specified options
        $breadcrumb = do_shortcode("[breadcrumb exclude-home=\"" . ($exclude_home ? 'true' : 'false') . "\" exclude-title=\"" . ($exclude_title ? 'true' : 'false') . "\" separator=\"" . esc_attr($separator) . "\"]");
        return $breadcrumb;
      }
    }

    new Breadcrumb_Divi_Module();
  }
}

// Integrate Breadcrumb module with Divi Builder
function integrate_breadcrumb_divi_module() {
  if (class_exists('ET_Builder_Module')) {
    global $pagenow;
    if ($pagenow === 'post.php' || $pagenow === 'post-new.php') {
      $breadcrumb_divi_module = new Breadcrumb_Divi_Module();
      add_action('admin_enqueue_scripts', array($breadcrumb_divi_module, 'enqueue_scripts'));
    }
  }
}
add_action('et_builder_ready', 'register_breadcrumb_divi_module');
add_action('admin_init', 'integrate_breadcrumb_divi_module');

// Manually add the Breadcrumb module to Divi Builder
function add_breadcrumb_divi_module($modules) {
  $modules['et_pb_custom_breadcrumb'] = array(
    'name' => 'Breadcrumb',
    'slug' => 'et_pb_custom_breadcrumb',
    'type' => 'shortcode',
    'child_title_var' => 'title',
    'child_title_fallback_var' => 'title',
    'child_title_value' => esc_html__('Breadcrumb', 'et_builder'),
    'advanced_setting_title_text' => esc_html__('New Breadcrumb', 'et_builder'),
    'settings_text' => esc_html__('Breadcrumb Settings', 'et_builder'),
    'settings_text' => esc_html__('Breadcrumb Settings', 'et_builder'),
    'render_callback' => 'et_pb_render_breadcrumb_divi_module',
  );

  return $modules;
}
add_filter('et_builder_modules', 'add_breadcrumb_divi_module');

// Render callback for the Breadcrumb module
function et_pb_render_breadcrumb_divi_module($attrs, $content = null, $render_slug) {
  $module = new Breadcrumb_Divi_Module();

  // Generate a preview of the module output
  $preview = $module->shortcode_callback($attrs, $content, $render_slug);

  // Return the module preview
  return et_core_esc_previously($preview);
}
