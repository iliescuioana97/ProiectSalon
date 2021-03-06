<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Entrepreneur
 * @since Entrepreneur 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<?php $mp_entrepreneur_class_body = array( 'entrepreneur' ); ?>
<body <?php body_class( $mp_entrepreneur_class_body ); ?> >
<div class="wrapper">
	<?php if ( get_page_template_slug() != 'template-landing-page.php' || is_search() ) : ?>
		<header id="header" class="main-header">
			<div class="site-header"
			     data-sticky-menu="<?php if ( get_theme_mod( mp_entrepreneur_get_prefix() . 'show_sticky_menu', false ) === true ) : ?>on<?php else: if ( get_theme_mod( mp_entrepreneur_get_prefix() . 'show_sticky_menu', false ) === 1 ): ?>on<?php
			     else: echo 'off';
			     endif;
			     endif;
			     ?>">
				<div class="container">
					<div class="site-logo">
						<?php if ( get_theme_mod( mp_entrepreneur_get_prefix() . 'logo' ) != "" || get_bloginfo( 'description' ) || get_bloginfo( 'name', 'display' ) != "" ) : ?>
							<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"
							   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<?php 
								if ( get_theme_mod( mp_entrepreneur_get_prefix() . 'logo', false ) === false ) : ?>
									<div class="header-logo "><img
											src="<?php echo( get_template_directory_uri() . '/images/headers/logo.png' ); ?>"
											alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
								<?php else:  ?>
									<?php if ( get_theme_mod( mp_entrepreneur_get_prefix() . 'logo' ) ) : ?>
										<div class="header-logo "><img
												src="<?php echo esc_url( get_theme_mod( mp_entrepreneur_get_prefix() . 'logo' ) ); ?>"
												alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
										</div>
									<?php endif; ?>
								<?php 
								endif;  ?>
								<div class="site-description">
									<h1 class="site-title <?php if ( ! get_bloginfo( 'description' ) ) : ?>empty-tagline<?php endif; ?>"><?php bloginfo( 'name' ); ?></h1>
									<?php if ( get_bloginfo( 'description' ) ) : ?>
										<p class="site-tagline"><?php bloginfo( 'description' ); ?></p>
									<?php endif; ?>
								</div>
							</a>
						<?php endif ?>
					</div>
					<div id="navbar" class="navbar">
						<div class="mobile-menu"><i class="fa fa-align-justify"></i></div>
						<nav id="site-navigation" class="main-navigation">
							<?php
							$mp_entrepreneur_defaults = array(
								'theme_location' => 'primary',
								'menu_class'     => 'sf-menu ',
								'menu_id'        => 'main-menu',
								'fallback_cb'    => 'mp_entrepreneur_page_menu'
							);
							wp_nav_menu( $mp_entrepreneur_defaults );
							?>
						</nav>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</header>
	<?php endif; ?>
	<div id="main" class="site-main">
