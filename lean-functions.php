<?php use LeanNs\ThemeSetup;
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */

// Constants.
define( 'LEANP_THEME_NAME', 'LeanName' );
define( 'LEANP_THEME_VERSION', '0.1.0' );
define( 'LEANP_MINIMUM_WP_VERSION', '4.3.1' );

// Composer autoload.
require_once get_template_directory() . '/vendor/autoload.php';
// Load Lean Setup
require_once get_template_directory() . '/lib/Setup.php';
ThemeSetup::init();

// Run the theme setup.
add_filter( 'loader_directories', function( $directories ) {
	$directories[] = get_template_directory() . '/frontend/atomic-elements';
	return $directories;
});

add_filter('loader_alias', function( $alias ) {
	$alias['atom'] = 'atoms';
	$alias['molecule'] = 'molecules';
	$alias['organism'] = 'organisms';
	return $alias;
});

/**
 * Function used to render custom tags from the admin into the site just after
 * the <body> tag.
 */
add_action( 'wp_head', function() {
	if ( function_exists( 'the_field' ) ) {
		the_field( 'general_options_google_tag_manager', 'option' );
	}
});

add_action( 'wp_footer', function() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5' );
});

/**
 * ACF json files folder path setting.
 */
add_filter('acf/settings/save_json', function my_acf_json_save_point( $path ) {
    return get_stylesheet_directory() . '/backend/acf';
});

/**
 * Namespace used for the localize object.
 */
add_filter(
	'lean_assets_localize_script',
	function() {
		return 'lean';
	}
);

/**
 * Localize the dynamic data that is going to be available for the Front End or
 * via the browser.
 */
add_filter(
	'lean_assets_localize_data',
	function() {
		return [
			'api_url' => '/wp-json/lean/v1/',
		];
	}
);

/*
 * Needed for loading the Google Maps in the ACF field in the dashboard.
 */
add_filter(
	'acf/settings/google_api_key',
	function() {
		return lean_acf_string( 'google_maps_key', 'options' );
	}
);

/*
* Enable <br> breaks in all esc_html().
* Useful when the editor wants to breal lines in a single text or text area field.
*/
add_filter(
	'esc_html',
	function( $safe_text ) {
		if ( ! is_admin() ) {
			$safe_text = str_replace( '&lt;br&gt;', '<br>', $safe_text );
			$safe_text = str_replace( '&lt;br /&gt;', '<br>', $safe_text );
		}
		return $safe_text;
	}
);