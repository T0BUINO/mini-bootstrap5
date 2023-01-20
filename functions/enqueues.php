<?php
/*
 * Enqueues
 */

if ( ! function_exists('b5st_enqueues') ) {
	function b5st_enqueues() {

		// Styles

		wp_register_style('bootstrap5', get_template_directory_uri() . '/theme/css/bootstrap.min.css', false, '5.2.1', null);
		wp_enqueue_style('bootstrap5');

		wp_register_style('bootstrapIcons', get_template_directory_uri() . '/theme/css/bootstrap-icons.css', false, '1.9.1', null);
		wp_enqueue_style('bootstrapIcons');

		wp_enqueue_style( 'gutenberg-blocks', get_template_directory_uri() . '/theme/css/blocks.css' );

		wp_register_style('theme', get_template_directory_uri() . '/theme/css/mb5.css', false, null);
		wp_enqueue_style('theme');

		// Scripts

		wp_register_script('bootstrap5', get_template_directory_uri() . '/theme/js/bootstrap.bundle.min.js', false, '5.2.1', true);
		wp_enqueue_script('bootstrap5');

		wp_register_script('theme', get_template_directory_uri() . '/theme/js/mb5.js', false, null, true);
		wp_enqueue_script('theme');

		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
add_action('wp_enqueue_scripts', 'b5st_enqueues', 100);
