<?php
/**
 * Class Images_Functions_Test
 *
 * @package Lean_WP_Helper_Functions
 */

/**
 * Images functions test cases.
 */
class Images_Functions_Test extends WP_UnitTestCase {

	private $attachment_id = 0;

	public function setUp() {
		parent::setUp();
		$this->attachment_id = $this->factory->attachment->create_upload_object( DIR_TESTDATA . '/images/test-image.png', 0 );
	}

	/**
	 * Testing that when giving an image id it returns its src path.
	 */
	public function test_get_image() {
		$resulting_image_src = lean_get_image( $this->attachment_id );
		$this->assertContains( 'http://example.org/wp-content/', $resulting_image_src );
		$this->assertContains( '.png', $resulting_image_src );
	}
}
