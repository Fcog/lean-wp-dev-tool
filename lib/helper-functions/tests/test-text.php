<?php
/**
 * Class Text_Functions_Test
 *
 * @package Lean_WP_Helper_Functions
 */

/**
 * Text functions test cases.
 */
class Text_Functions_Test extends WP_UnitTestCase {

	/**
	 * Testing the fetch of the excerpt field value.
	 */
	public function test_get_custom_excerpt() {
		$post_id = $this->factory->post->create([
			'post_content' => 'This is the content. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
			'post_excerpt' => 'This is the excerpt',
		]);

		$expected_excerpt = 'This is the excerpt';
		$resulting_excerpt = lean_custom_excerpt( $post_id );
		$this->assertEquals( $expected_excerpt, $resulting_excerpt );
	}

	/**
	 * Testing the fetch of the content field trimmed value.
	 */
	public function test_get_trimmed_content() {
		$post_id = $this->factory->post->create([
			'post_content' => 'This is the content. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'post_excerpt' => '',
		]);

		$expected_excerpt = 'This is the content. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been';
		$resulting_excerpt = lean_custom_excerpt( $post_id );
		$this->assertEquals( $expected_excerpt, $resulting_excerpt );
	}

	/**
	 * Testing the fetch of the content field trimmed value with appended 3 dots.
	 */
	public function test_get_trimmed_content_with_dots() {
		$post_id = $this->factory->post->create([
			'post_content' => 'This is the content. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'post_excerpt' => '',
		]);

		$expected_excerpt = 'This is the content. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been...';
		$resulting_excerpt = lean_custom_excerpt( $post_id, 20, '...' );
		$this->assertEquals( $expected_excerpt, $resulting_excerpt );
	}
}
