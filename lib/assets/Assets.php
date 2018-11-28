<?php namespace Lean;

/**
 * Class for loading assets based on environment.
 *
 * Load development files on development env, and load minified
 * and/or concatenated files on production env.
 *
 * @since 1.1.0
 */
class Assets {
	const HOOK_PREFIX = 'lean_assets_';

	/**
	 * Which environment we are in. Defaults to development.
	 *
	 * @since 1.1.0
	 * @access private
	 * @var string $environment
	 */
	private $environment = 'development';
	/**
	 * Whether to load the comment-reply script or not.
	 *
	 * @since 1.1.0
	 * @access private
	 * @var bool $load_comments
	 */
	private $load_comments = false;
	/**
	 * The JS version number to append to script URLs.
	 *
	 * @since 1.1.0
	 * @access private
	 * @var bool $js_version
	 */
	private $js_version = false;
	/**
	 * The CSS version number to append to stylesheet URLs.
	 *
	 * @since 1.1.0
	 * @access private
	 * @var bool $css_version
	 */
	private $css_version = false;
	/**
	 * The jquery version number to append to stylesheet URLs.
	 *
	 * @since 1.1.0
	 * @access private
	 * @var bool $jquery_version
	 */
	private $jquery_version = false;
	/**
	 * Path to the css URL to load the assets.
	 *
	 * @since 2.0.0
	 * @access private
	 * @var string css_uri
	 */
	private $css_uri = '';
	/**
	 * Path to the js URL to load the assets.
	 *
	 * @since 2.0.0
	 * @access private
	 * @var string js_uri
	 */
	private $js_uri = '';
	/**
	 * Path to the jquery URL to load the assets.
	 *
	 * @since 2.0.0
	 * @access private
	 * @var string jquery_uri
	 */
	private $jquery_uri = '';
	/**
	 * Array of configuration options.
	 *
	 * @since 1.1.0
	 * @access private
	 * @var array $options
	 */
	private $options = [];

	/**
	 * PHP5 constructor.
	 *
	 * @since 1.1.0
	 *
	 * @param array $options {
	 *        Optional array of configuration options.
	 *
	 * @type string $environment Which environment we are in.
	 * @type bool|int $js_verion Version number to use for scripts.
	 * @type bool|int $css_version Version number to user for stylesheets.
	 * @type bool $load_comments Whether to load the comment-reply script.
	 * @type bool $remove_emoji Whether to remove emoji libraries.
	 * }
	 */
	public function __construct( $options = [] ) {
		$this->options = wp_parse_args($options, [
			'css_uri' => '',
			'js_uri' => '',
			'jquery_uri' => '',
			'automatic_suffix' => true,
		]);
		$this->css_uri = $this->options['css_uri'];
		$this->js_uri = $this->options['js_uri'];
		$this->jquery_uri = $this->options['jquery_uri'];

		$this->set_up_environment();
		$this->set_up_version_numbers();
	}

	/**
	 * Setup the environment based on options given.
	 *
	 * @since 1.1.0
	 * @access private
	 *
	 * @return void
	 */
	private function set_up_environment() {
		if ( $this->it_has( 'environment' ) ) {
			$this->environment = $this->options['environment'];
		} else {
			$this->environment = defined( 'WP_DEBUG' ) && WP_DEBUG
				? 'development'
				: 'production';
		}
	}

	/**
	 * Setup JS and CSS version numbers based on options given.
	 *
	 * @since 1.1.0
	 * @access private
	 *
	 * @return void
	 */
	private function set_up_version_numbers() {
		if ( $this->it_has( 'js_version' ) ) {
			$this->js_version = $this->options['js_version'];
		}
		if ( $this->it_has( 'css_version' ) ) {
			$this->css_version = $this->options['css_version'];
		}
		if ( $this->it_has( 'jquery_version' ) ) {
			$this->jquery_version = $this->options['jquery_version'];
		}
	}

	/**
	 * Check whether a given option exists in the options array.
	 *
	 * @since 1.1.0
	 * @access private
	 *
	 * @param string $option_name The name of the option to check for existence.
	 * @return bool Whether the given option key exists.
	 */
	private function it_has( $option_name ) {
		return array_key_exists( $option_name, $this->options ) && ! empty( $this->options[ $option_name ] );
	}

	/**
	 * Enqueues the theme assets.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	public function load() {
		$this->load_comments = $this->it_has( 'load_coments', $this->options )
			? $this->options['load_comments']
			: false;
		$this->enqueue_assets();
	}

	/**
	 * Returns the suffix production assets.
	 *
	 * @since 1.1.0
	 *
	 * @return string The suffix to use for production assets.
	 */
	public function get_assets_suffix() {
		$assets_suffix = '';
		if ( 'development' !== $this->environment && $this->options['automatic_suffix'] ) {
			$assets_suffix = '.min';
		}
		return $assets_suffix;
	}

	/**
	 * Enqueues JS and CSS assets based on options passed.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	public function setup_assets() {
		$suffix = $this->get_assets_suffix();

		if ( ! is_admin() ) {
			$this->update_jquery();
			$remove_emoji_exists = array_key_exists( 'remove_emoji', $this->options );
			if ( ! $remove_emoji_exists ||
				( $remove_emoji_exists && $this->options['remove_emoji'] )
			) {
				$this->remove_emoji();
			}
		}

		// Load the JS files.
		if ( apply_filters( self::HOOK_PREFIX . 'include_js', true ) ) {
			$handle = sprintf( '%s-%s', $this->environment, 'js' );
			wp_register_script( $handle, str_replace( '.js', $suffix, $this->js_uri ) . '.js', [], $this->js_version, true );
			$localize_script = apply_filters( self::HOOK_PREFIX . 'localize_script', 'lean_localize_js' );
			$localize_data = apply_filters( self::HOOK_PREFIX . 'localize_data', [] );
			wp_localize_script( $handle, $localize_script, $localize_data );
			wp_enqueue_script( $handle );
		}

		// Load the CSS files.
		if ( apply_filters( self::HOOK_PREFIX . 'include_css', true ) ) {
			wp_enqueue_style(
				sprintf( '%s-%s', $this->environment, 'style' ),
				str_replace( '.css', $suffix, $this->css_uri ) . '.css',
				array(),
				$this->css_version,
				'all'
			);
		}

		if ( $this->load_comments ) {
			$this->load_comments_assets();
		}
	}

	/**
	 * Enqueues theme-bundled jQuery instead of default one in WordPress.
	 *
	 * @since 1.1.0
	 * @access private
	 *
	 * @return void
	 */
	private function update_jquery() {
		wp_deregister_script( 'jquery' );

		if ( apply_filters( self::HOOK_PREFIX . 'include_jquery', false ) ) {
			wp_register_script(
			// Handle.
				'jquery',
				// Source path.
				$this->jquery_uri,
				// No dependencies.
				false,
				// Version number.
				$this->jquery_version,
				// Load in footer.
				false
			);

			wp_enqueue_script( 'jquery' );
		}
	}

	/**
	 * Remove emoji libries, it causes different issues in the console
	 * during the development phase.
	 *
	 * @since 1.1.0
	 * @access private
	 *
	 * @return void
	 */
	private function remove_emoji() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}

	/**
	 * Enqueues the theme comment-reply script.
	 *
	 * @since 1.1.0
	 * @access private
	 *
	 * @return void
	 */
	private function load_comments_assets() {
		$load_comments = is_singular() && comments_open() && get_option( 'thread_comments' );

		if ( $load_comments ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Bind the setup function to the wp_enqueue_scripts to load assets to the front end.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		add_action( 'wp_enqueue_scripts', array( $this, 'setup_assets' ) );
	}
}
