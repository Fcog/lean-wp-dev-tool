<?php namespace LeanNs\Modules\User;

/**
 * User Role Model.
 * Creates the Studio Lead User Role.
 */
class User {
	const STUDIO_LEAD_ROLE_SLUG = 'studio_lead';
	const STUDIO_LEAD_ROLE_NAME = 'Studio Lead';
	const ADMIN_ROLE_SLUG       = 'administrator';

	/**
	 * The current user ID.
	 *
	 * @var int The User ID.
	 */
	public $id;

	/**
	 * The current user roles.
	 *
	 * @var array The User roles.
	 */
	public $roles;

	/**
	 * The current user enabled studios set in the Dashboard.
	 *
	 * @var array The enabled studios.
	 */
	public $enabled_studios;

	/**
	 * User constructor.
	 */
	public function __construct() {
		$user                  = wp_get_current_user();
		$this->id              = $user ? $user->ID : 0;
		$this->roles           = $user ? $user->roles : [];
		$this->enabled_studios = lean_acf_array( 'studio_lead_studios', 'user_' . $this->id );
	}

	/**
	 * Function called automatically and works as the entry point of the class.
	 */
	public static function init() {
		add_action( 'init', [ __CLASS__, 'register_role' ] );
	}

	/**
	 * Has the current user a Studio Lead role?
	 */
	public function is_studio_lead() {
		return in_array( self::STUDIO_LEAD_ROLE_SLUG, $this->roles, true );
	}

	/**
	 * Register the Studio Lead User role.
	 */
	public static function register_role() {
		add_role(
			self::STUDIO_LEAD_ROLE_SLUG,
			self::STUDIO_LEAD_ROLE_NAME
		);
	}
}
