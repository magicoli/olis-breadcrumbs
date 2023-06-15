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
		add_action( 'plugins_loaded', array( $this, 'run_updates' ) );
	}

	public function run_updates() {
		$db_version = get_option( 'olis_breadcrumbs_db_version', 0 );

		$this->errors    = 0;
		$this->successes = 0;
		$this->warnings  = 0;

		while ( $this->has_update_method( $db_version + 1 ) ) {
			$update        = $db_version + 1;
			$update_method = 'update_' . ( $update );

			$result = call_user_func( array( $this, $update_method ) );

			if ( $result === true ) {
				$db_version++;
				$this->successes++;
				update_option( 'olis_breadcrumbs_db_version', $update );
			} else {
				$this->errors++;
				// Update failed, exit the loop
				break;
			}
		}

		if ( ! empty( $this->update_messages ) || $this->errors > 0 || $this->successes > 0 ) {
			add_action( 'admin_notices', array( $this, 'display_update_successes' ) );
		}
	}

	private function has_update_method( $version ) {
		$update_method = 'update_' . $version;
		return method_exists( $this, $update_method );
	}

	public function display_update_successes() {
		$notice_class    = $this->errors > 0 ? 'notice-error' : ( $this->warnings > 0 ? 'notice-warning' : 'notice-success' );
		$success_message = $this->successes > 0 ? sprintf( _n( '%s succeeded', '%s succeeded', $this->successes, 'breadcrumbs-shortcode' ), $this->successes ) : '';
		$error_message   = $this->errors > 0 ? ( empty( $success_message ) ? '' : ', ' ) . sprintf( _n( '%s failed', '%s failed', $this->errors, 'breadcrumbs-shortcode' ), $this->errors ) : '';

		echo '<div class="notice ' . esc_attr( $notice_class ) . ' is-dismissible">';
		echo '<p>' . __( "Oli's Breadcrumbs database updates: ", 'breadcrumbs-shortcode' ) . $success_message . $error_message . '</p>';

		foreach ( $this->update_messages as $message ) {
			echo '<p>' . esc_html( $message ) . '</p>';
		}

		echo '</div>';
	}

	/**
	 * Add as many update_n() methods as needed.
	 *
	 *    - n must be integer and incremnetal, starting at 1.
	 *    - there must be no gap.
	 *    - once update_x has been published, the method can't be removed nor be
	 *      replaced with another update process. But if needed it can be left
	 *      empty and return a boolean true.
	 *
	 * Each method will be executed only once, and the last successful update will
	 * be stored as db version. At the next check, the update class will start
	 * checking at db version + 1.
	 *
	 * The update method must return true or false.
	 *
	 * @return boolean      Update result:
	 *                      - true saves the update number and process remaning
	 *                        updates.
	 *                      - false stops the update process. The failed
	 *                        update will be tried again at next check.
	 */
	// private function update_1() {
	//
	// * Update code */
	//
	// * Report and return success or failure */
	// if ( $error ) {
	// * Display an error notice and return false, */
	// * This will break the update process, this update will be tried again next time. */
	// $this->update_messages[] = __( "There was an error ___ during the update of ____, upcoming no other updates will be processed until this is fixed.", 'breadcrumbs-shortcode' );
	// return false;
	// } else if ( $warning ) {
	// * Display a warning notice, but keep processing updates. */
	// $this->warnings++;
	// $this->update_messages[] = __( "Warning. This happened and won't block other update but you should have a look and check.", 'breadcrumbs-shortcode' );
	// } else {
	// * Display success notice and keep processing. */
	// $this->update_messages[] = __( "The ___ and ____ were updated successfully.", 'breadcrumbs-shortcode' );
	// }
	//
	// return true;
	// }
	//
	// private function update_2() {
	//
	// Update code
	//
	// return $result;
	// }

}

$olis_breadcrumbs_updates = new Olis_Breadcrumbs_Updates();
