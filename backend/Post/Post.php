<?php namespace LeanNs\Modules\Posts;

/**
 * Post Model.
 */
class Post {
	const TYPE = 'post';

	/**
	 * The post title.
	 *
	 * @var string the post title.
	 */
	public $title;

	/**
	 * The post content.
	 *
	 * @var string the post content.
	 */
	public $content;

	/**
	 * The post excerpt.
	 *
	 * @var string the post excerpt.
	 */
	public $excerpt;

	/**
	 * The post featured image id.
	 *
	 * @var string the post image id.
	 */
	public $image_id;

	/**
	 * The post author display.
	 *
	 * @var string the post author name.
	 */
	public $author;

	/**
	 * The post author image gravatar URL.
	 *
	 * @var string the post author image URL.
	 */
	public $author_image;

	/**
	 * The post published date.
	 *
	 * @var string the post published date.
	 */
	public $date;

	/**
	 * The post permalink.
	 *
	 * @var string the post permalink.
	 */
	public $permalink;

	/**
	 * Function called automatically and works as the entry point of the class.
	 */
	public static function init() {
	}

	/**
	 * Post constructor.
	 *
	 * @param int $post_id The Post Id.
	 */
	public function __construct( $post_id ) {
		$this->id              = $post_id;
		$this->title           = get_the_title( $post_id );
		$this->content         = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
		$this->excerpt         = get_post_field( 'the_excerpt', $post_id );
		$this->image_id        = get_post_thumbnail_id( $post_id );
		$this->author_image    = get_avatar_url( get_post_field( 'post_author', $post_id ) );
		$this->author          = get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) );
		$this->date            = get_the_date( '', $post_id );
		$this->permalink       = get_the_permalink( $post_id );
	}

	/**
	 * Converts an object to an associative array.
	 *
	 * @return array
	 */
	public function to_array() {
		return call_user_func( 'get_object_vars', $this );
	}

	/**
	 * Makes a query in Attorney and Persons CPTs.
	 *
	 * @param array $args The query args.
	 *
	 * @return \WP_Query The query.
	 */
	public static function query( $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'fields'                 => 'ids',
				'posts_per_page'         => 100,
				'post_type'              => self::TYPE,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			]
		);

		$query = new \WP_Query( $args );

		return $query;
	}

	/**
	 * Get all posts data.
	 *
	 * @param array $args The query args.
	 *
	 * @return array The posts data.
	 */
	public static function get_all( $args = [] ) {
		$query = self::query( $args );

		$data = [];

		foreach ( $query->posts as $post_id ) {
			$data[] = new Press( $post_id );
		}

		return [
			'data'          => $data,
			'max_num_pages' => $query->max_num_pages,
		];
	}

	/**
	 * Get all posts data formatted for the Cards modu,e.
	 *
	 * @param array $args The query args.
	 *
	 * @return array The posts data.
	 */
	public static function get_all_formatted( $args = [] ) {
		$query = self::query( $args );

		$data = [];

		foreach ( $query->posts as $post_id ) {
			$post   = new self( $post_id );
			$data[] = array_merge(
				$post->to_array(),
				[
					'author'   => 'By ' . $post->author,
					'image_id' => $post->image_id,
					'button'   => [
						'title' => 'Read Article',
						'url'   => $post->permalink,
					],
				]
			);
		}

		return [
			'data'          => $data,
			'max_num_pages' => $query->max_num_pages,
		];
	}
}
