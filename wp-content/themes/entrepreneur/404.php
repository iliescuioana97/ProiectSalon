<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Entrepreneur
 * @since Entrepreneur 1.0.0
 */
get_header();
?>
<div class="container main-container">
    <article id="page-404" <?php post_class('post-entry'); ?>>
        <div class="entry-content">
            <h1 class="page-title"><?php _e('404',  'entrepreneur' ); ?></h1>
            <h2><?php _e("Oops! That page can&#39;t be found.",  'entrepreneur' ); ?></h2>
            <p><?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?',  'entrepreneur' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </article>
    
</div>
<?php get_footer(); ?>
