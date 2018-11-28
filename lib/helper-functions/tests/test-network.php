<?php
/**
 * Class Network_Functions_Test
 *
 * @package Lean_WP_Helper_Functions
 */

/**
 * Network functions test cases.
 */
class Network_Functions_Test extends WP_UnitTestCase {

	/**
	 * Testing that it is returning the $_SERVER['REMOTE_ADDR'] value.
	 */
	public function test_get_user_ip() {
		$user_ip = '192.168.0.11';
		$_SERVER['REMOTE_ADDR'] = $user_ip;
		$expected_ip = $user_ip;
		$resulting_ip = lean_get_user_ip();
		$this->assertEquals( $expected_ip, $resulting_ip );
	}
}
