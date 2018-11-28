<?php
/**
 * Class Taxonomies_Functions_Test
 *
 * @package Lean_WP_Helper_Functions
 */

/**
 * Posts functions test cases.
 */
class Taxonomies_Functions_Test extends WP_UnitTestCase {

	const TAXONOMY = 'taxonomy';

	private $post_id = 0;

	private $term_ids = [];

	public function setUp() {
		parent::setUp();

		// Creates a custom taxonomy
		register_taxonomy( self::TAXONOMY, 'post' );

		// Creates 4 terms from the custom taxonomy
		$this->term_ids = $this->factory->term->create_many( 4, [
			'taxonomy' => self::TAXONOMY,
		]);

		$this->post_id = $this->factory->post->create();

		// Sets terms to post
		wp_set_post_terms( $this->post_id, $this->term_ids, self::TAXONOMY );
	}

	/**
	 * Testing that it returns the first term's name.
	 */
	public function test_get_post_term_name() {
		$resulting_term_name = lean_get_post_term_name( $this->post_id, self::TAXONOMY );
		$expected_term = get_term( $this->term_ids[0] );
		$expected_term_name = $expected_term->name;
		$this->assertEquals( $expected_term_name, $resulting_term_name );
	}

	/**
	 * Testing that it returns a post related to a term.
	 */
	public function test_get_post_by_term() {
		$resulting_post = lean_get_post_by_term( $this->term_ids[0], self::TAXONOMY );
		$resulting_post_id = $resulting_post->ID;
		$expected_post_id = $this->post_id;
		$this->assertEquals( $resulting_post_id, $expected_post_id );
	}
}
