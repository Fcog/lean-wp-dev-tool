<?php
/**
 * Class Posts_Functions_Test
 *
 * @package Lean_WP_Helper_Functions
 */

/**
 * Posts functions test cases.
 */
class Posts_Functions_Test extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		$this->factory->post->create( [ 'post_date' => '2010-02-23 18:57:33' ] );
		$this->factory->post->create( [ 'post_date' => '2012-02-23 18:57:33' ] );
		$this->factory->post->create( [ 'post_date' => '2013-02-23 18:57:33' ] );
		$this->factory->post->create( [ 'post_date' => '2015-02-23 18:57:33' ] );
		$this->factory->post->create( [ 'post_date' => '2017-02-23 18:57:33' ] );
		$this->factory->post->create( [ 'post_date' => '2018-02-23 18:57:33' ] );
	}

	/**
	 * Testing that it is returning all the posts years in descending order.
	 */
	public function test_get_posts_years_descending() {
		$expected_years = [
			'2018',
			'2017',
			'2015',
			'2013',
			'2012',
			'2010',
		];

		$resulting_years = lean_get_posts_years();

		$this->assertEquals( $expected_years, $resulting_years );
	}

	/**
	 * Testing that it is returning all the posts years in ascending order.
	 */
	public function test_get_posts_years_ascending() {
		$expected_years = [
			'2010',
			'2012',
			'2013',
			'2015',
			'2017',
			'2018',
		];

		$resulting_years = lean_get_posts_years( 'post', 'asc' );

		$this->assertEquals( $expected_years, $resulting_years );
	}
}
