<?php namespace LeanNs\Modules\Api;

use \AbstractEndpoint;
use LeanNs\Modules\Post\Post;

/**
 * Class used to generate an endpoint for working with Posts.
 */
class PostEndpoint extends AbstractEndpoint {
	/**
	 * The variable used to identify the path of the endpooint.
	 *
	 * @var String
	 */
	protected $endpoint = '/post';

	/**
	 * Function called by the endpoint.
	 *
	 * @param \WP_REST_Request $request Contains data from the request.
	 */
	public function endpoint_callback( \WP_REST_Request $request ) {
		$post_id = $request->get_param( 'post_id' );
		$post = new Post($post_id);
		return $post;
	}

	/**
	 * Arguments that the endpoint can recieve, it accepts two params:
	 *
	 * - page: The number of page to request in the transactions
	 * - format: HTML if not specified it will return the collection of IDs.
	 *
	 * @return array
	 */
	public function endpoint_args() {
		return [
			'post_id' => [
				'required' => true,
				'validate_callback' => function( $param ) {
					return is_numeric( $param );
				},
				'sanitize_callback' => 'absint',
				'default' => 0,
			],
			'title'    => [
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'media',
			],
		];
	}
}
