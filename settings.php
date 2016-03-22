<?php

namespace ProfilePress\PP_Admin_Bar_Control;

class Settings {

	private static $instance;

	public function __construct() {
		if ( function_exists( 'is_plugin_active_for_network' )
		     && is_plugin_active_for_network( basename( dirname( __FILE__ ) ) . '/admin-bar-dashboard-control.php' )
		) {
			add_action( 'network_admin_menu', array( __CLASS__, 'register_menu_page' ) );
		} else {
			add_action( 'admin_menu', array( __CLASS__, 'register_menu_page' ) );
		}
	}

	public static function register_menu_page() {

		add_menu_page(
			__( 'Admin Bar & Dashboard Control' ),
			__( 'Admin Bar & Dash' ),
			'manage_options',
			'admin-bar-dashboard-control',
			array(
				__CLASS__,
				'settings_page',
			),
			'dashicons-universal-access-alt'
		);

	}

	public static function settings_page() {
		// call to save the setting options
		self::save_options();

		require 'include.settings-page.php';
	}


	public static function save_options() {
		if ( isset( $_POST['settings_submit'] ) && check_admin_referer( 'abc_settings_nonce', '_wpnonce' ) ) {

			$saved_options = $_POST['abc_options'];

			update_option( 'abc_options', $saved_options );

			wp_redirect( admin_url('admin.php?page=admin-bar-dashboard-control&settings-updated=true') );
			exit;
		}
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}