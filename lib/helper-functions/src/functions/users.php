<?php
/**
 * Function helpers for using with users and roles.
 *
 * @package    Helper Functions
 * @subpackage Users Roles
 * @author     Francisco Giraldo <fgiraldo@wearenolte.com.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wearenolte.com
 * @since      1.0.0
 */

/**
 * Checks if the current logged in user has certain role
 *
 * @param string $role The role name.
 * @return boolean
 */
function lean_current_user_has_role( string $role ) {
	$current_user = wp_get_current_user();

	return ( 0 !== $current_user->ID && in_array( $role, (array) $current_user->roles, true ) );
}
