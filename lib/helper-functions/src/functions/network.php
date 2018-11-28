<?php
/**
 * Function helpers for network.
 *
 * @package    Helper Functions
 * @subpackage Network
 * @author     Francisco Giraldo <fgiraldo@wearenolte.com.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wearenolte.com
 * @since      1.0.0
 */

/**
 * Retreives the user IP address, false if it could not be retreived.
 *
 * @return string the IP Address.
 */
function lean_get_user_ip() {
	return isset( $_SERVER['REMOTE_ADDR'] ) ?
		sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) :
		false;
}
