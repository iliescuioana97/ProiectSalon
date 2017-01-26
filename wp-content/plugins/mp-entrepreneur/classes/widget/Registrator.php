<?php

class MP_Entrepreneur_Plugin_Widget_Registrator {

	protected $widgets = array(
		'/widget/Items/About.php',
		'/widget/Items/Services.php',
		'/widget/Items/RecentPosts.php',
		'/widget/Items/Location.php'
	);

	public function __construct() {

		// Allow child themes/plugins to add widgets to be loaded.
		$widgets = apply_filters( 'sp_widgets', $this->widgets );
		foreach ( $widgets as $w ) {
			include_once MP_ENTREPRENEUR_PLUGIN_CLASS_PATH . $w;
		}
	}

}

new MP_Entrepreneur_Plugin_Widget_Registrator();