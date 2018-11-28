<?php namespace LeanNs\Modules\Api;

/**
 * Function that is used to register the new endpoints used for the site.
 */
class Api {
	/**
	 * This class uses the autolad wich calls the init static method once the page is ready.
	 */
	public static function init() {
		self::add_filters();
		PostEndpoint::init();
	}

	/**
	 * Filters used to overwrite the default configuration of the endpoints.
	 */
	public static function add_filters() {
		add_filter(
			'ln_endpoints_api_namespace',
			function() {
				return 'lean';
			}
		);

		add_filter(
			'ln_endpoints_api_version',
			function() {
				return 'v1';
			}
		);
	}
}
