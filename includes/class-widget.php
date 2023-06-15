<?php
/**
 * Oli's Breadcrumbs Widget
 *
 * Register a widget to display Oli's Breadcrumbs with the same parameters as the shortcode.
 *
 * @package         Olis_Breadcrumbs_Shortcode
 */

// Codde begin
class Olis_Breadcrumbs_Widget extends WP_Widget {
	// Constructor
	public function __construct() {
		parent::__construct(
			'breadcrumbs_widget',
			esc_html__( "Oli's Breadcrumbs", 'breadcrumbs-shortcode' ),
			array(
				'description' => esc_html__( 'Display breadcrumbs using shortcode.', 'breadcrumbs-shortcode' ),
			)
		);
	}

	// Widget frontend display
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		$instance = array_merge(
			array(
				'exclude_home'     => 'false',
				'exclude_archives' => 'false',
				'exclude_title'    => 'false',
				'separator'        => '/',
			),
			$instance
		);
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo do_shortcode( '[olis_breadcrumbs exclude-archives="' . esc_attr( $instance['exclude_archives'] ) . '" exclude-title="' . esc_attr( $instance['exclude_title'] ) . '" separator="' . esc_attr( $instance['separator'] ) . '"]' );
		echo $args['after_widget'];
	}

	// Widget backend settings form
	public function form( $instance ) {
		$title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$exclude_home  = isset( $instance['exclude_home'] ) ? $instance['exclude_home'] : 'false';
		$exclude_archives  = isset( $instance['exclude_archives'] ) ? $instance['exclude_archives'] : 'false';
		$exclude_title = isset( $instance['exclude_title'] ) ? $instance['exclude_title'] : 'false';
		$separator     = ! empty( $instance['separator'] ) ? $instance['separator'] : '/';

		?>
	<p>
	  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'breadcrumbs-shortcode' ); ?></label>
	  <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
	</p>
	<p>
	  <label for="<?php echo esc_attr( $this->get_field_id( 'exclude_home' ) ); ?>">
		<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'exclude_home' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_home' ) ); ?>" value="true" <?php checked( $exclude_home, 'true' ); ?>>
		<?php esc_html_e( 'Exclude Home', 'breadcrumbs-shortcode' ); ?>
	  </label>
	</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_archives' ) ); ?>">
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'exclude_archives' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_archives' ) ); ?>" value="true" <?php checked( $exclude_archives, 'true' ); ?>>
			<?php esc_html_e( 'Exclude Archives', 'breadcrumbs-shortcode' ); ?>
		</label>
	</p>
	<p>
	  <label for="<?php echo esc_attr( $this->get_field_id( 'exclude_title' ) ); ?>">
		<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'exclude_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_title' ) ); ?>" value="true" <?php checked( $exclude_title, 'true' ); ?>>
		<?php esc_html_e( 'Exclude Title', 'breadcrumbs-shortcode' ); ?>
	  </label>
	</p>
	<p>
	  <label for="<?php echo esc_attr( $this->get_field_id( 'separator' ) ); ?>"><?php esc_html_e( 'Separator:', 'breadcrumbs-shortcode' ); ?></label>
	  <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'separator' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'separator' ) ); ?>" value="<?php echo esc_attr( $separator ); ?>">
	</p>
		<?php
	}

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance                  = array();
		$instance['title']         = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['exclude_home']  = isset( $new_instance['exclude_home'] ) ? $new_instance['exclude_home'] : 'false';
		$instance['exclude_archives']  = isset( $new_instance['exclude_archives'] ) ? $new_instance['exclude_archives'] : 'false';
		$instance['exclude_title'] = isset( $new_instance['exclude_title'] ) ? $new_instance['exclude_title'] : 'false';
		$instance['separator']     = ! empty( $new_instance['separator'] ) ? sanitize_text_field( $new_instance['separator'] ) : '/';
		return $instance;
	}

}

function olis_breadcrumbs_load_widget() {
	register_widget( 'Olis_Breadcrumbs_Widget' );
}
add_action( 'widgets_init', 'olis_breadcrumbs_load_widget' );
