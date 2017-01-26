<?php
/**
 * The sidebar containing the footer widget area
 *
 * If no active widgets in this sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage entrepreneur
 * @since entrepreneur 1.0
 */
?>
<div class="footer-sidebar">
	<div class="container">
		<div class="row">
			<?php
			$mp_entrepreneur_args     = array(
				'before_title' => '<h4 class="widget-title">',
				'after_title'  => '</h4>'
			);
			$mp_entrepreneur_instance = array();
			?>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-2' ); ?>
				<?php else:
					if ( has_action( 'mp_entrepreneur_footer_default_widget_about' ) ) {
						do_action( 'mp_entrepreneur_footer_default_widget_about' );
					} else {
						wp_cache_delete( 'widget_recent_entries', 'widget' );
						$mp_entrepreneur_instance = array(
							'number'    => 3,
							'show_date' => true
						);
						the_widget( 'WP_Widget_Recent_Posts', $mp_entrepreneur_instance, $mp_entrepreneur_args );
					}
				endif; ?>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
				<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-3' ); ?>
				<?php else:
					wp_cache_delete( 'widget_text', 'widget' );
					$mp_entrepreneur_instance = array(
						'text'  => __( '<table><tbody>
<tr><td>Monday:</td><td>09:00 &ndash; 20:00</td></tr>
<tr><td>Tuesday: </td><td> 09:00 &ndash; 20:00</td></tr>
<tr><td>Wednesday: </td><td>09:00 &ndash; 20:00</td></tr>
<tr><td>Thursday: </td><td>09:00 &ndash; 20:00</td></tr>
<tr><td>Friday: </td><td>09:00 &ndash; 20:00</td></tr>
<tr><td>Saturday:</td><td>09:00 &ndash; 17:00</td></tr>
<tr><td>Sunday:</td><td>Closed</td></tr>
</tbody></table>',
							'entrepreneur'  ),
						'title' => __( 'Opening hours',
							'entrepreneur'  )
					);
					the_widget( 'WP_Widget_Text', $mp_entrepreneur_instance, $mp_entrepreneur_args );
				endif; ?>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-5">
				<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-4' ); ?>
				<?php else:
					wp_cache_delete( 'widget_text', 'widget' );
					$mp_entrepreneur_instance = array(
						'text'  => __( '<table><tbody>
<tr><td><i class="fa fa-home"></i> <span class="block">1254/21 West-Holland Street </br>
Manchester, United Kingdom</span></td>
<td><i class="fa fa-phone"></i> <a  class="block" href="tel:345677554">345-677-554</a></td></tr>
</tbody></table>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2511.115555002783!2d-2.126668974322286!3d53.45680676551681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487bb420f4cbad5b%3A0xc0b7da79e33c534b!2zTWFuY2hlc3RlciBSZCBOLCBEZW50b24sIE1hbmNoZXN0ZXIgTTM0IDNQWiwg0JLQtdC70LjQutC-0LHRgNC40YLQsNC90LjRjw!5e0!3m2!1sru!2sua!4v1459765392471" width="470" height="184" frameborder="0" style="border:0" allowfullscreen></iframe>',
							'entrepreneur'  ),
						'title' => __( 'Location',
							'entrepreneur'  )
					);
					the_widget( 'WP_Widget_Text', $mp_entrepreneur_instance, $mp_entrepreneur_args );
				endif; ?>
			</div>
		</div><!-- .widget-area -->
	</div>
</div>
