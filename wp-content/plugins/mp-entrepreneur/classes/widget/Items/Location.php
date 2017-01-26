<?php
/**
 * Contact  widget class
 *
 */
require_once 'Default.php';

class MP_Entrepreneur_Plugin_Widget_Location extends MP_Entrepreneur_Plugin_Widget_Default {

	public function __construct() {
		$this->setClassName( 'mp_entrepreneur_widget_contact' );
		$this->setName( __( 'Location', 'mp-entrepreneur' ) );
		$this->setDescription( __( 'Location', 'mp-entrepreneur' ) );
		parent::__construct();
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title   = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$address = apply_filters( 'widget_texts', empty( $instance['address'] ) ? '' : $instance['address'], $instance );
		$phone   = apply_filters( 'widget_text', empty( $instance['phone'] ) ? '' : $instance['phone'], $instance );
		$embed   = empty( $instance['embed'] ) ? '' : $instance['embed'];
		/**
		 * Filter the content of the Text widget.
		 */
		$text = apply_filters( 'widget_text', $embed, $instance, $this );

		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . esc_html( $title ) . $after_title;
		}
		?>
		<table>
			<tbody>
			<tr>
				<?php if ( !empty($address) ) : ?>
				<td><i class="fa fa-home"></i> <span
						class="block"><?php echo wp_kses( $address, array( 'br' => array() ) ); ?></span></td>
				<?php
					endif;
					if ( !empty($phone) ) : ?>
				<td><i class="fa fa-phone"></i>
					<a class="block" href="tel:<?php echo esc_html( $phone ); ?>"><?php echo esc_html( $phone ); ?></a>
				</td>
				<?php endif; ?>
			</tr>
			</tbody>
		</table>
		<?php echo ! empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
		<?php
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance            = $old_instance;
		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['address'] = $new_instance['address'];
		$instance['phone']   = strip_tags( $new_instance['phone'] );
		$instance['embed']   = $new_instance['embed'];

		return $instance;
	}

	public function form( $instance ) {
		$title    = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'location', 'mp-entrepreneur' );
		$address  = isset( $instance['address'] ) ? esc_attr( $instance['address'] ) : __( '1254/21 West-Holland Street <br/> Manchester United Kingdom', 'mp-entrepreneur' );
		$phone    = isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : __( '345-677-554', 'mp-entrepreneur' );
		$embed    = isset( $instance['embed'] ) ? $instance['embed'] : '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2511.115555002783!2d-2.126668974322286!3d53.45680676551681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487bb420f4cbad5b%3A0xc0b7da79e33c534b!2zTWFuY2hlc3RlciBSZCBOLCBEZW50b24sIE1hbmNoZXN0ZXIgTTM0IDNQWiwg0JLQtdC70LjQutC-0LHRgNC40YLQsNC90LjRjw!5e0!3m2!1sru!2sua!4v1459765392471" width="470" height="184" frameborder="0" style="border:0" allowfullscreen></iframe>';
		?>
		<p><label
				for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>"/>
		</p>

		<p><label
				for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:', 'mp-entrepreneur' ); ?></label>
			<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id( 'address' ); ?>"
			          name="<?php echo $this->get_field_name( 'address' ); ?>"><?php echo $address; ?></textarea></p>

		<p><label
				for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone:', 'mp-entrepreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>"
			       name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo $phone; ?>"/>
		</p>

		<p><label
				for="<?php echo $this->get_field_id( 'embed' ); ?>"><?php _e( 'Google map iframe:', 'mp-entrepreneur' ); ?></label>
			<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id( 'embed' ); ?>"
			          name="<?php echo $this->get_field_name( 'embed' ); ?>"><?php echo $embed; ?></textarea>
		</p>

		<?php
	}

}

add_action( 'widgets_init', create_function( '', 'return register_widget( "MP_Entrepreneur_Plugin_Widget_Location" );' ) );
