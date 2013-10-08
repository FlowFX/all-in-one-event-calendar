<?php

/**
 * WordPress backed options management
 *
 * @author     Justas Butkus <justas@butkus.lt>
 * @since      2012.10.02
 *
 * @package    AllInOneCalendar
 * @subpackage AllInOneCalendar.Model.Meta
 */
class Ai1ec_Meta_Option extends Ai1ec_Meta
{

	/**
	 * Check if current user should see notice about update (if any)
	 *
	 * @return bool Availability of update
	 */
	public function is_visible_update() {
		if ( ! $this->get( 'ai1ec_update_available', NULL, false ) ) {
			return false;
		}
		return current_user_can( 'update_plugins' );
	}

	/**
	 * _fetch method
	 *
	 * Fetch actual option using WP interface.
	 *
	 * @uses get_option To get actual value
	 *
	 * @param string $name     Option to fetch
	 * @param NULL   $meta_key Discarded option
	 * @param NULL   $default  Value to return if $name is not found
	 * @param NULL   $single   Discarded option
	 *
	 * @return mixed Value or $default
	 */
	protected function _fetch(
		$name,
		$meta_key = NULL,
		$default  = false,
		$single   = false
	) {
		return get_option( $name, $default );
	}

	protected function _after_initialize() {
		add_action( 'add_site_option',    array( $this, 'clean' ) );
		add_action( 'add_option',         array( $this, 'clean' ) );
		add_action( 'update_site_option', array( $this, 'clean' ) );
		add_action( 'update_option',      array( $this, 'clean' ) );
		add_action( 'delete_site_option', array( $this, 'clean' ) );
		add_action( 'delete_option',      array( $this, 'clean' ) );
	}

}
