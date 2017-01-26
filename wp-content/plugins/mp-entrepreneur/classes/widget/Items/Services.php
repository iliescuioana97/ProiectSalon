<?php
/**
 * Services  widget class
 *
 */
require_once 'Default.php';

class MP_Entrepreneur_Plugin_Widget_Services extends MP_Entrepreneur_Plugin_Widget_Default {

	public function __construct() {
		$this->setClassName( MP_Entrepreneur_Plugin_Instance()->get_prefix() . 'widget_services' );
		$this->setName( __( 'Services & Prices ', 'mp-entrepreneur' ) );
		$this->setDescription( __( 'Services & Prices', 'mp-entrepreneur' ) );
		$this->setIdSuffix( 'services' );
		parent::__construct();
	}

	public function img_url( $instance ) {
		global $wpdb;
		$image_src = ( ! empty( $instance['image_uri'] ) ) ? esc_attr( $instance['image_uri'] ) : '';
		if ( ! empty( $image_src ) ):
			$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
			$id    = $wpdb->get_var( $query );
			if ( is_null( $id ) ):
				return $image_src;
			endif;
			$image_uri = wp_get_attachment_image_src( $id, array( 770, 396 ) );

			return $image_uri[0];
		endif;

		return '';
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$image_uri = $this->img_url( $instance );
		$title     = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$text      = ( ! empty( $instance['text'] ) ) ? $instance['text'] : '<table>
<thead><tr>
<th></th><th>' . __( 'Womens', 'mp-entrepreneur' ) . '</th><th>' . __( 'Mens', 'mp-entrepreneur' ) . '</th>
</tr></thead>
<tbody>
<tr><td>' . __( 'Stylist', 'mp-entrepreneur' ) . '</td><td>$80 </td><td>$70 </td></tr>
<tr><td>' . __( 'Senior Stylist', 'mp-entrepreneur' ) . '</td><td>$90 </td><td>$80 </td></tr>
<tr><td>' . __( 'Master Stylist', 'mp-entrepreneur' ) . '</td><td>$110</td><td>$100</td></tr>
<tr><td>' . __( 'Celebrity Stylist', 'mp-entrepreneur' ) . '</td><td>$POA </td><td>$POA </td></tr>
<tr><td>' . __( 'Bride', 'mp-entrepreneur' ) . '</td><td>$180</td><td></td></tr>
</tbody>
</table>';

		echo $before_widget;
		?>
		<div class="services-box">
			<div class="services-wrapper">
				<div class="services-header">
					<?php if ( ! empty( $title ) ): ?>
						<h4 class="services-title">
							<?php if ( ! empty( $title ) ): ?>
								<?php echo esc_html( $title ); ?>
							<?php endif; ?>
						</h4>
					<?php endif; ?>
					<?php if ( ! empty( $image_uri ) ):
						?>
						<div class="services-image">

							<img src="<?php echo esc_url( $image_uri ); ?>" alt="<?php echo $title; ?>">
						</div>
					<?php endif; ?>
				</div>
				<?php
				if ( ! empty( $text ) ):
					echo '<div class="services-content">';
					echo htmlspecialchars_decode( $text );
					echo '</div>';
				endif;
				?>
				<div class="clearfix"></div>
			</div>
		</div>
		<?php
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['text']      = stripslashes( wp_filter_post_kses( $new_instance['text'] ) );
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['image_uri'] = strip_tags( $new_instance['image_uri'] );

		return $instance;
	}

	public function get_upload_image( $instance ) {
		echo '<img class="custom_media_image" src="';
		if ( ! empty( $instance['image_uri'] ) ) :
			echo $instance['image_uri'];
		endif;
		echo '" style="margin:0;padding:0;max-width:100%;';
		if ( ! empty( $instance['image_uri'] ) ) :
			echo 'display:block;';
		else:
			echo 'display:none;';
		endif;
		echo '" />';
	}

	public function form( $instance ) {
		?>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'mp-entrepreneur' ); ?></label><br/>
			<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>"
			       id="<?php echo $this->get_field_id( 'title' ); ?>" value="<?php
			if ( ! empty( $instance['title'] ) ): echo $instance['title'];
			endif;
			?>" class="widefat"/>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'image_uri' ); ?>"><?php _e( 'Image', 'mp-entrepreneur' ); ?></label><br/>
			<?php $this->get_upload_image( $instance ); ?>
			<input type="text" class="widefat custom_media_url"
			       name="<?php echo $this->get_field_name( 'image_uri' ); ?>"
			       id="<?php echo $this->get_field_id( 'image_uri' ); ?>" value="<?php
			if ( ! empty( $instance['image_uri'] ) ): echo $instance['image_uri'];
			endif;
			?>"
			       style="margin-top:5px;">
			<input type="button" class="button button-primary mp_entrepreneur_media_button" id="custom_media_button"
			       name="<?php echo $this->get_field_name( 'image_uri' ); ?>"
			       value="<?php _e( 'Upload Image', 'mp-entrepreneur' ); ?>"
			       style="margin-top:5px;"/>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text', 'mp-entrepreneur' ); ?></label><br/>
            <textarea class="widefat" rows="8" cols="20" name="<?php echo $this->get_field_name( 'text' ); ?>"
                      id="<?php echo $this->get_field_id( 'text' ); ?>"><?php
	            if ( ! empty( $instance['text'] ) ): echo htmlspecialchars_decode( $instance['text'] );
	            else:
		            echo '<table>
<thead><tr>
<th></th><th>'.__( 'Women', 'mp-entrepreneur' ).'</th><th>'.__( 'Men', 'mp-entrepreneur' ).'</th>
</tr></thead>
<tbody>
<tr><td>'.__( 'Stylist', 'mp-entrepreneur' ).'</td><td>$80 </td><td>$70 </td></tr>
<tr><td>'.__( 'Senior Stylist', 'mp-entrepreneur' ).'</td><td>$90 </td><td>$80 </td></tr>
<tr><td>'.__( 'Master Stylist', 'mp-entrepreneur' ).'</td><td>$110</td><td>$100</td></tr>
<tr><td>'.__( 'Celebrity Stylist', 'mp-entrepreneur' ).'</td><td>$130</td><td>$80</td></tr>
<tr><td>'.__( 'Wedding stylist','mp-entrepreneur' ).'</td><td>$180</td><td>-</td></tr>
</tbody>
</table>';
	            endif;
	            ?></textarea>
		</p>
		<p>
			<i>
				<?php _e( 'Use tag &#8249;table&#8250;&#8249;/table&#8250; inside text', 'mp-entrepreneur' ) ?>
			</i>

		</p>

		<?php
	}

}

add_action( 'widgets_init', create_function( '', 'return register_widget( "MP_Entrepreneur_Plugin_Widget_Services" );' ) );
