<?php
/**
 * Class Requests_Functions_Test
 *
 * @package Lean_WP_Helper_Functions
 */

/**
 * Requests functions test cases.
 */
class Requests_Functions_Test extends WP_UnitTestCase {

	private $key = '';

	public function setUp() {
		parent::setUp();
		$this->key = 'query_var';
	}

	public function tearDown() {
	    unset( $_REQUEST[ $this->key ] );
	}

	/**
	 * Testing that it is getting a sanitized text value from a request with a maliciuos value.
	 */
	public function test_get_text_request() {
		$_REQUEST[ $this->key ] = '<script>alert(\'hola\')</script>chao';
		$expected_value = 'chao';
		$resulting_value = lean_request_text( $this->key );
		$this->assertEquals( $expected_value, $resulting_value );
	}

	/**
	 * Testing that it is getting a sanitized int value from a request with a maliciuos value.
	 */
	public function test_maliciuous_int_request() {
		$_REQUEST[ $this->key ] = '<script>alert(\'hola\')</script>';
		$expected_value = '0';
		$resulting_value = lean_request_int( $this->key );
		$this->assertEquals( $expected_value, $resulting_value );
	}

	/**
	 * Testing that it is getting a sanitized int value from a request with a negative value.
	 */
	public function test_1_get_int_request() {
		$_REQUEST[ $this->key ] = '-1';
		$expected_value = '-1';
		$resulting_value = lean_request_int( $this->key );
		$this->assertEquals( $expected_value, $resulting_value );
	}

	/**
	 * Testing that it is getting a sanitized int value from a request with a positive value.
	 */
	public function test_2_get_int_request() {
		$_REQUEST[ $this->key ] = '344';
		$expected_value = '344';
		$resulting_value = lean_request_int( $this->key );
		$this->assertEquals( $expected_value, $resulting_value );
	}

	/**
	 * Testing that it is getting a sanitized email value from a request with a bad value.
	 */
	public function test_malicious_email_request() {
		$_REQUEST[ $this->key ] = '<script>alert(\'hola\')</script>fcog@hotmail.com';
		$expected_value = 'scriptalert\'hola\'/scriptfcog@hotmail.com';
		$resulting_value = lean_request_email( $this->key );
		$this->assertEquals( $expected_value, $resulting_value );
	}

	/**
	 * Testing that it is getting a sanitized email value from a request with a good value.
	 */
	public function test_get_email_request() {
		$_REQUEST[ $this->key ] = 'fcog@hotmail.com';
		$expected_value = 'fcog@hotmail.com';
		$resulting_value = lean_request_email( $this->key );
		$this->assertEquals( $expected_value, $resulting_value );
	}
}
