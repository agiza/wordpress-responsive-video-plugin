<?php
/*
Plugin Name: WordPress Responsive Video oEmbed
Plugin URI: http://krtnb.ch
Description: WordPress Responsive Video is a pure CSS solution that makes oEmbed YouTube and Vimeo responsive / fluid.
Version: 0.1
Author: Daan Kortenbach
License: GPLv2
*/

add_action( 'init', 'dmk_add_responsive_style' );
/**
 * Enqueues the stylesheet
 * @return void
 */
function dmk_add_responsive_style(){
	wp_enqueue_style( 'wp-responsive-video', plugins_url( '/wp-responsive-video.css', __FILE__ ) );
}

add_filter( 'embed_oembed_html', 'dmk_add_responsive_video_container' );
/**
 * Adds a container around oEmbedded YouTube or Vimeo
 * @param  string $html default oEmbed html
 * @return string       oEmbed html with a container
 */
function dmk_add_responsive_video_container( $html ) {
	if ( strpos( $html, "http://www.youtube.com" ) ) {
		return '<div class="responsive-video hd">' . $html . '</div>';
	}
	elseif ( strpos( $html, "http://player.vimeo.com" ) ) {
		return '<div class="responsive-video hd">' . $html . '</div>';
	}
}
