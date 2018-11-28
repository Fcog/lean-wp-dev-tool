<?php
/**
 * The purpose of the ACF helper functions is to provide with the validations so the projects code is cleaner.
 * They check if the field value exists and returns a proper data type if not.
 *
 * @package acf
 */

/**
 * Get the source path of an image in 1x and 2x versions from an ACF field.
 *
 * @param string       $field_name the ACF field that returns an image ID (an attachment ID).
 * @param int | string $reference the post ID or 'options'.
 * @param string       $image_size The 1x image size to be loaded.
 * @param string       $retina_image_size The 2x image size to be loaded.
 * @return array Returns 2 array elements, the first one containing the 1x image url and the 2nd
 * containing the retina image url.
 */
function lean_acf_retina_image( string $field_name, $reference, string $image_size = 'full', string $retina_image_size = 'full' ) {
	$field_value = get_field( $field_name, $reference );
	$image_id = $field_value ? $field_value : 0;
	return lean_get_retina_image( $image_id, $image_size, $retina_image_size );
}

/**
 * Get the source path of an image in 1x version from an ACF field.
 *
 * @param string       $field_name the ACF field that returns an image ID (an attachment ID).
 * @param int | string $reference the post ID or 'options'.
 * @param string       $image_size The 1x image size to be loaded.
 * @return string the image or empty string if no image of the given size is found.
 */
function lean_acf_image( string $field_name, $reference, string $image_size = 'full' ) {
	$field_value = get_field( $field_name, $reference );
	$image_id = $field_value ? $field_value : 0;
	return lean_get_image( $image_id, $image_size );
}

/**
 * Get the text from an ACF field.
 *
 * @param string       $field_name the ACF field.
 * @param int | string $reference the post ID or 'options'.
 * @return string the field text.
 */
function lean_acf_text( string $field_name, $reference ) {
	$field_value = get_field( $field_name, $reference );
	return $field_value ? $field_value : '';
}

/**
 * Get an array from an ACF field.
 *
 * @param string       $field_name the ACF field.
 * @param int | string $reference the post ID or 'options'.
 * @return array the field value as an array.
 */
function lean_acf_array( string $field_name, $reference ) {
	$field_value = get_field( $field_name, $reference );
	return $field_value ? $field_value : [];
}

/**
 * Get the link from an ACF field. Always returns an array of 3 elements with keys: title, url and target.
 *
 * @param string       $field_name the ACF field.
 * @param int | string $reference the post ID or 'options'.
 * @return array the link values or empty string values.
 */
function lean_acf_link( string $field_name, $reference ) {
	$field_value = get_field( $field_name, $reference );
	$field_value = $field_value ? $field_value : [];

	$field_value = wp_parse_args( $field_value, [
		'title' => '',
		'url' => '',
		'target' => '',
	]);

	return $field_value;
}

/**
 * Get's a user meta data.
 *
 * @param string $field_name the ACF field.
 * @param int    $user_id the user ID.
 * @return string the meta value or empty.
 */
function lean_acf_userdata( string $field_name, int $user_id ) {
	$user_key = '_user' . $user_id;
	$field_value = get_field( $field_name, $user_key );
	return $field_value ? $field_value : '';
}
