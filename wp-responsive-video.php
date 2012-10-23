<?php
/*
Plugin Name: WordPress Responsive Video oEmbed
Plugin URI: http://krtnb.ch
Description: WordPress Responsive Video is a pure CSS solution that makes oEmbeds responsive / fluid.
Version: 0.3
Author: Daan Kortenbach
License: GPLv2
*/

add_action( 'init', 'dmk_add_responsive_style' );
/**
 * Enqueues the stylesheet
 *
 * @return void
 */
function dmk_add_responsive_style() {
	wp_enqueue_style( 'wp-responsive-video', plugins_url( '/wp-responsive-video.css', __FILE__ ) );
}

add_filter( 'embed_oembed_html', 'dmk_add_responsive_video_container', 999, 3 );
/**
 * Calculates ratio and adds a container around oEmbedded video
 *
 * @param string  $html default oEmbed html
 * @return string       oEmbed html with a container
 */
function dmk_add_responsive_video_container( $html, $url, $attr ) {

	$extra_classes = '';

	// Get width
	preg_match( "/width=\"[0-9]*\"/", $html, $matches );
	$width = str_replace( 'width=', '', str_replace( '"', '', $matches[0] ) ) . '<br>';

	// Get height
	preg_match( "/height=\"[0-9]*\"/", $html, $matches );
	$height = str_replace( 'height=', '', str_replace( '"', '', $matches[0] ) ) . '<br>';

	// Remove width, height attributes & preleading space
	$html = preg_replace( "/ (width|height)=\"[0-9]*\"/", "", $html );

	// Set 16/9 format (HD) if ratio is higher then 1.5
	if ( $width / $height > 1.5 )
		$extra_classes .= ' hd';

	// Add class if Vimeo
	if ( strpos( $html, "http://player.vimeo.com" ) )
		$extra_classes .= ' vimeo';

	// Add class if Blip
	if ( strpos( $html, "http://blip.tv" ) )
		$extra_classes .= ' blip';

	// Add class if Flickr
	if ( strpos( $html, "http://www.flickr.com" ) )
		$extra_classes .= ' flickr';

	// Add class if img
	if ( strpos( $html, "<img" ) )
		$extra_classes .= ' img';

	// Return string
	return '<div class="responsive-video' . $extra_classes . '">' . $html . '</div>';
}
