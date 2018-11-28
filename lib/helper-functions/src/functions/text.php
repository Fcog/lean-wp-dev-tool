<?php
/**
 * Function helpers for using with text.
 *
 * @package    Helper Functions
 * @subpackage Text
 * @author     Francisco Giraldo <fgiraldo@wearenolte.com.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wearenolte.com
 * @since      1.0.0
 */

/**
 * Trim excerpt if available by the given number of words, if no excerpt then trim the content.
 *
 * @param int    $post_id The post id.
 * @param int    $num_words Excerpt length in words, defaults to 20 words.
 * @param string $more What to append if the text needs to be trimmed.
 * @return string modified excerpt/content.
 */
function lean_custom_excerpt( int $post_id, int $num_words = 20, string $more = '' ) {
	$text = get_post_field( 'post_excerpt', $post_id );
	if ( empty( $text ) ) {
		$text = get_post_field( 'post_content', $post_id );
	}
	return wp_trim_words( $text, $num_words, $more );
}

/**
 * Inserts a text between two parts of a bigger text using two reg expressions to find the 2 elements between.
 *
 * @param string $new_text html to add.
 * @param string $text_container original html.
 * @param string $before regular expression to detect the first element.
 * @param string $after regular expression to detect the second element.
 * @return string the modified html.
 */
function lean_insert_text_between( string $new_text, string $text_container, string $before, string $after ) {
	return preg_replace(
		'/(' . $before . ')(.*?)(' . $after . ')/s',
		'${1}' . $new_text . '${3}',
		$text_container
	);
}

/**
 * Function to create a value that can be used as an ID HTML attribute also
 * it uses the current post / page ID in order to prevent collisions.
 *
 * @param string $title The title or string to be converted to ID.
 * @return string
 */
function lean_create_id_from( string $title ) {
	$id = get_the_ID();
	$title = strtolower( trim( $title ) );
	return sanitize_title( $title . '-' . $id );
}
