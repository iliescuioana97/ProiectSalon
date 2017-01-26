<?php

class MP_Entrepreneur_Woocommerce {

    public function __construct() {
        /*
         * woocommerce breadcrumbs
         */
        add_filter('woocommerce_breadcrumb_defaults', array($this, 'woocommerce_breadcrumbs'));
        /*
         *  Remove the product rating display on product loops
         */
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

        /*
         *  Remove them all in one line
         */
        add_filter('woocommerce_enqueue_styles', '__return_false');
        add_action('woocommerce_after_main_content', array($this, 'woocommerce_after_main_content'), 10);
        /*
         * add the action
         */
        add_action('woocommerce_before_main_content', array($this, 'woocommerce_before_main_content'), 10, 2);

        add_action('woocommerce_archive_description', array($this, 'woocommerce_archive_description'), 10, 2);

        add_action('woocommerce_before_single_product', array($this, 'woocommerce_before_single_product'), 10, 2);

        add_action('woocommerce_sidebar', array($this, 'woocommerce_sidebar'), 10, 2);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
    }

    function woocommerce_breadcrumbs() {
        return array(
            'delimiter' => ' <span class="sep"><i class="fa fa-angle-right"></i></span> ',
            'wrap_before' => '<div class="breadcrumb breadcrumbs sp-breadcrumbs " itemprop="breadcrumb"><div class="breadcrumb-trail">',
            'wrap_after' => '</div></div>',
            'before' => '',
            'after' => '',
            'home' => _x('Home', 'breadcrumb',  'entrepreneur' ),
        );
    }

    /*
     *  define the woocommerce_before_main_content callback
     */

    function woocommerce_before_main_content() {
        echo '<div class="container main-container">';
    }

    /*
     *  define the woocommerce_archive_description callback
     */

    function woocommerce_archive_description() {
        echo '<div class="row clearfix"><div class=" col-xs-12 col-sm-8 col-md-8 col-lg-8">';
    }

    /*
     *  define the woocommerce_archive_description callback
     */

    function woocommerce_before_single_product() {
        echo '<div class="row clearfix"><div class=" col-xs-12 col-sm-8 col-md-8 col-lg-8">';
    }

    /*
     *  define the woocommerce_archive_description callback
     */

    function woocommerce_sidebar() {
        echo '</div><!--col-xs-12 col-sm-4 col-md-4 col-lg-4--> '
        . '</div>'
        . '</div>';
    }

    function woocommerce_after_main_content() {
        echo '</div><!--col-xs-12 col-sm-8 col-md-8 col-lg-8--> '
        . '<div class=" col-xs-12 col-sm-4 col-md-4 col-lg-3 col-lg-offset-1">';
    }

}

new MP_Entrepreneur_Woocommerce();


