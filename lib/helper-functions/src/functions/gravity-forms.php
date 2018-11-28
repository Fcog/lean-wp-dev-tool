<?php
/**
 * Function helpers for using with the Gravity Forms plugin.
 *
 * @package    Helper Functions
 * @subpackage Gravity Forms
 * @author     Francisco Giraldo <fgiraldo@wearenolte.com.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wearenolte.com
 * @since      1.0.0
 */

/**
 * Returns the Gravity Form field object given a class name
 *
 * @param int    $form_id The form id.
 * @param string $class The class name.
 * @return object the field object.
 */
function lean_get_gformfield_by_class( int $form_id, string $class ) {
	if ( class_exists( 'RGFormsModel' ) ) {
		$form = RGFormsModel::get_form_meta( $form_id );

		foreach ( $form['fields'] as $field ) {
			$classes = explode( ' ', $field['cssClass'] );
			if ( in_array( $class, $classes ) ) {
				return $field;
			}
		}
	}

	return null;
}

/**
 * Returns the Gravity Form field object given a field label
 *
 * @param int    $form_id The form id.
 * @param string $label The field Label.
 * @return object the field object.
 */
function lean_get_gformfield_by_label( int $form_id, string $label ) {
	if ( class_exists( 'RGFormsModel' ) ) {
		$form = RGFormsModel::get_form_meta( $form_id );

		foreach ( $form['fields'] as $field ) {
			if ( $field['label'] === $label ) {
				return $field;
			}
		}
	}

	return null;
}
