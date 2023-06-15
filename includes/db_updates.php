<?php
/**
 * Look for database updates, execute them and update db version option
 */

// Code
class Olis_Breadcrumbs_Updates {
  private $update_messages = array();
  public $errors;
  public $successes;

  public function __construct() {
    // Run updates after the plugin is loaded
    add_action('plugins_loaded', array($this, 'run_updates'));
  }

  public function run_updates() {
    $db_version = get_option('olis_breadcrumbs_db_version', 0);

    $this->errors = 0;
    $this->successes = 0;
    $this->warnings = 0;

    while ($this->has_update_method($db_version + 1)) {
      $update = $db_version + 1;
      $update_method = 'update_' . ($update);

      $result = call_user_func(array($this, $update_method));

      if ($result === true) {
        $db_version++;
        $this->successes++;
        update_option('olis_breadcrumbs_db_version', $update);
      } else {
        $this->errors++;
        // Update failed, exit the loop
        break;
      }
    }

    if (!empty($this->update_messages) || $this->errors > 0 || $this->successes > 0 ) {
      add_action('admin_notices', array($this, 'display_update_successes'));
    }
  }

  private function has_update_method($version) {
    $update_method = 'update_' . $version;
    return method_exists($this, $update_method);
  }

  public function display_update_successes() {
    $notice_class = $this->errors > 0 ? 'notice-error' : ( $this->warnings > 0 ? 'notice-warning' : 'notice-success' );
    $success_message = $this->successes > 0 ? sprintf(_n('%s succeeded', '%s succeeded', $this->successes, 'breadcrumbs-shortcode'), $this->successes) : '';
    $error_message = $this->errors > 0 ? ( empty($success_message) ? '' : ', ') . sprintf(_n('%s failed', '%s failed', $this->errors, 'breadcrumbs-shortcode'), $this->errors) : '';

    echo '<div class="notice ' . esc_attr($notice_class) . ' is-dismissible">';
    echo '<p>' . __("Oli's Breadcrumbs database updates: ", 'breadcrumbs-shortcode') . $success_message . $error_message . '</p>';

    foreach ($this->update_messages as $message) {
      echo '<p>' . esc_html($message) . '</p>';
    }

    echo '</div>';
  }

  private function update_1() {
    global $wpdb;
    $old_slug = 'et_pb_custom_breadcrumbs';
    $new_slug = 'et_pb_olis_breadcrumbs';

    // Update the post content and check if the query succeeded
    $content_query = $wpdb->query( $wpdb->prepare(
      "UPDATE $wpdb->posts SET post_content = REPLACE(post_content, %s, %s)",
      $old_slug,
      $new_slug
    ));
    if ($content_query === false) {
      // Display an error message but proceed as success
      $this->warnings++;
      $this->update_messages[] = __("Error while updating Oli's Breadcrumbs Divi module in posts content. Please review posts using this module.", 'breadcrumbs-shortcode');
    }

    // Update the post meta
    $meta_query = $wpdb->query( $wpdb->prepare(
      "UPDATE $wpdb->postmeta SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key = '_et_pb_use_builder'",
      $old_slug,
      $new_slug
    ));

    // Check if the second query succeeded
    if ($meta_query === false) {
      // Display an error message but proceed as success
      $this->warnings++;
      $this->update_messages[] = __("Error while updating Oli's Breadcrumbs Divi module meta. Please review posts using this module.", 'breadcrumbs-shortcode');
    } else {
      // Display a success message
      $this->update_messages[] = __( "Oli's Breadcrumbs Divi module updated successfully.", 'breadcrumbs-shortcode');
    }

    return true;
  }

}

$olis_breadcrumbs_updates = new Olis_Breadcrumbs_Updates();
