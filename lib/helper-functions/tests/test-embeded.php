<?php
/**
 * Class Embeded_Functions_Test
 *
 * @package Lean_WP_Helper_Functions
 */

/**
 * Embeded functions test cases.
 */
class Embeded_Functions_Test extends WP_UnitTestCase {

	/**
	 * Testing convertion of a Youtube URL to the embeded code with no additional iframe params.
	 */
	public function test_convert_youtube_url_to_embeded() {
		$youtube_url = 'https://www.youtube.com/watch?v=KbIRXKP6GfY';
		$expected_embeded_code = '<iframe src="//www.youtube.com/embed/KbIRXKP6GfY"  allowfullscreen></iframe>';
		$resulting_embeded_code = lean_convert_youtube_url_to_embeded( $youtube_url );
		$this->assertEquals( $expected_embeded_code, $resulting_embeded_code );
	}

	/**
	 * Testing convertion of a Youtube URL to the embeded code with additional iframe params.
	 */
	public function test_convert_youtube_url_to_embeded_with_params() {
		$youtube_url = 'https://www.youtube.com/watch?v=KbIRXKP6GfY';
		$params = 'frameborder="0" allow="autoplay; encrypted-media"';
		$expected_embeded_code = '<iframe src="//www.youtube.com/embed/KbIRXKP6GfY" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
		$resulting_embeded_code = lean_convert_youtube_url_to_embeded( $youtube_url, $params );
		$this->assertEquals( $expected_embeded_code, $resulting_embeded_code );
	}
}
