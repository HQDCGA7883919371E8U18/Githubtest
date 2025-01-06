<?php
/**
 * Admin functions and definitions.
 *
 * @package Motta
 */

namespace Motta;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Mobile initial
 *
 */
class Admin {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}



	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		if ( ! is_admin() ) {
			return;
		}

		\Motta\Admin\Plugin_Install::instance();
		\Motta\Admin\Block_Editor::instance();
		\Motta\Admin\Meta_Boxes::instance();
		\Motta\Admin\Transients::instance();
	}
}
